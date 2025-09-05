<?php

namespace App\Repository;

use PDO;

class BookingRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function userAlreadyBooked($userId, $carpoolingId)
    {
        $query = "SELECT COUNT(*) FROM Participer WHERE id_user = :userId AND id_carpooling = :carpoolingId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':carpoolingId', $carpoolingId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function userBookingOnDate($userId, $nb_place)
    {
        $query = "SELECT COUNT(*) FROM Participer p
        JOIN carpooling c ON p.id_carpooling = c.id_carpooling
        WHERE p.id_user = :userId AND DATE(c.departure_date) = :date";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function isTripFull(int $carpoolingId): bool
    {
        $query = "SELECT nb_place FROM carpooling WHERE id_carpooling = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $carpoolingId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !$result || (int)$result['nb_place'] <= 0;
    }



    public function addBooking(int $idUser, int $idCarpooling): bool
    {
        try {
            $this->pdo->beginTransaction();


            // 1. Récupérer le prix de la place et le driver_id
            $stmt = $this->pdo->prepare("SELECT price_place, driver_id FROM carpooling WHERE id_carpooling = :idCarpooling");
            $stmt->execute(['idCarpooling' => $idCarpooling]);
            $trip = $stmt->fetch();

            if (!$trip) {
                $this->pdo->rollBack();
                return false; // trajet introuvable
            }

            $pricePlace = $trip['price_place'];
            $driverId = $trip['driver_id'];

            // 2. Vérifier crédits passager
            $stmt = $this->pdo->prepare("SELECT credit_user FROM user WHERE id_user = :idUser FOR UPDATE");
            $stmt->execute(['idUser' => $idUser]);
            $user = $stmt->fetch();

            if (!$user || $user['credit_user'] < $pricePlace) {
                $this->pdo->rollBack();
                return false; // crédits insuffisants
            }



            // 3. Insérer réservation
            $stmt = $this->pdo->prepare("INSERT INTO Participer (id_user, id_carpooling) VALUES (:idUser, :idCarpooling)");
            $stmt->execute(['idUser' => $idUser, 'idCarpooling' => $idCarpooling]);

            // 4. Déduire crédits passager
            $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user - :price WHERE id_user = :idUser");
            $stmt->execute(['price' => $pricePlace, 'idUser' => $idUser]);

            // 5. Ajouter crédits chauffeur
            $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user + :price WHERE id_user = :driverId");
            $stmt->execute(['price' => $pricePlace, 'driverId' => $driverId]);

            // 6. Ajouter crédits plateforme (2 crédits fixes par réservation)
            $platformCredits = 2;
            $stmt = $this->pdo->prepare("INSERT INTO platform_earnings (id_carpooling, credits_earned) VALUES (:idCarpooling, :credits)");
            $stmt->execute(['idCarpooling' => $idCarpooling, 'credits' => $platformCredits]);

            // 7. Réduire le nombre de places disponibles dans le trajet
            $stmt = $this->pdo->prepare("UPDATE carpooling SET nb_place = nb_place - 1 WHERE id_carpooling = :idCarpooling");
            $stmt->execute(['idCarpooling' => $idCarpooling]);


            $this->pdo->commit();

            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e; // ou gérer l’erreur selon ton système
        }
    }

    public function getDateDepart(int $carpoolingId): ?string
    {
        $query = "SELECT departure_date FROM carpooling WHERE id_carpooling = :carpoolingId LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':carpoolingId', $carpoolingId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['departure_date'])) {
            return $result['departure_date'];
        }
        return null;  // si pas trouvé
    }


    // DELETE
    public function cancelBooking(int $idUser, int $idCarpooling): bool
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Vérifier si la réservation existe
            $stmt = $this->pdo->prepare("SELECT * FROM Participer WHERE id_user = :idUser AND id_carpooling = :idCarpooling");
            $stmt->execute(['idUser' => $idUser, 'idCarpooling' => $idCarpooling]);
            $booking = $stmt->fetch();

            if (!$booking) {
                $this->pdo->rollBack();
                return false; // aucune réservation trouvée
            }

            // 2. Récupérer infos du trajet
            $stmt = $this->pdo->prepare("SELECT price_place, driver_id FROM carpooling WHERE id_carpooling = :idCarpooling FOR UPDATE");
            $stmt->execute(['idCarpooling' => $idCarpooling]);
            $trip = $stmt->fetch();

            if (!$trip) {
                $this->pdo->rollBack();
                return false; // trajet introuvable
            }

            $pricePlace = $trip['price_place'];
            $driverId = $trip['driver_id'];

            // 3. Supprimer la réservation
            $stmt = $this->pdo->prepare("DELETE FROM Participer WHERE id_user = :idUser AND id_carpooling = :idCarpooling");
            $stmt->execute(['idUser' => $idUser, 'idCarpooling' => $idCarpooling]);

            // 4. Rembourser crédits passager
            $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user + :price WHERE id_user = :idUser");
            $stmt->execute(['price' => $pricePlace, 'idUser' => $idUser]);

            // 5. Retirer crédits chauffeur
            $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user - :price WHERE id_user = :driverId");
            $stmt->execute(['price' => $pricePlace, 'driverId' => $driverId]);

            // 6. Retirer les crédits de la plateforme
            $stmt = $this->pdo->prepare("DELETE FROM platform_earnings WHERE id_carpooling = :idCarpooling LIMIT 1");
            $stmt->execute(['idCarpooling' => $idCarpooling]);

            // 7. Réaugmenter le nombre de places disponibles
            $stmt = $this->pdo->prepare("UPDATE carpooling SET nb_place = nb_place + 1 WHERE id_carpooling = :idCarpooling");
            $stmt->execute(['idCarpooling' => $idCarpooling]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e; // ou gérer autrement selon ton système
        }
    }

    public function cancelTrip(int $idUser, int $idCarpooling): bool
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Récupérer infos du trajet
            $stmt = $this->pdo->prepare("SELECT price_place, driver_id FROM carpooling WHERE id_carpooling = :idCarpooling FOR UPDATE");
            $stmt->execute(['idCarpooling' => $idCarpooling]);
            $trip = $stmt->fetch();

            if (!$trip) {
                $this->pdo->rollBack();
                return false; // trajet introuvable
            }

            $pricePlace = $trip['price_place'];
            $driverId = $trip['driver_id'];

            if ($idUser === (int)$driverId) {
                // L'utilisateur est le conducteur => annuler tout le trajet

                // a. Rembourser tous les passagers
                $stmt = $this->pdo->prepare("
                SELECT id_user 
                FROM Participer 
                WHERE id_carpooling = :idCarpooling
            ");
                $stmt->execute(['idCarpooling' => $idCarpooling]);
                $passengers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($passengers as $passenger) {
                    $stmt = $this->pdo->prepare("
                    UPDATE user 
                    SET credit_user = credit_user + :price 
                    WHERE id_user = :idUser
                ");
                    $stmt->execute([
                        'price' => $pricePlace,
                        'idUser' => $passenger['id_user']
                    ]);
                }

                // b. Supprimer toutes les participations
                $stmt = $this->pdo->prepare("DELETE FROM Participer WHERE id_carpooling = :idCarpooling");
                $stmt->execute(['idCarpooling' => $idCarpooling]);

                // c. Supprimer crédits plateforme liés au trajet
                $stmt = $this->pdo->prepare("DELETE FROM platform_earnings WHERE id_carpooling = :idCarpooling");
                $stmt->execute(['idCarpooling' => $idCarpooling]);

                // d. Supprimer le trajet
                $stmt = $this->pdo->prepare("DELETE FROM carpooling WHERE id_carpooling = :idCarpooling");
                $stmt->execute(['idCarpooling' => $idCarpooling]);
            } else {
                // L'utilisateur est un passager => annuler sa participation

                // Vérifier si la réservation existe
                $stmt = $this->pdo->prepare("SELECT * FROM Participer WHERE id_user = :idUser AND id_carpooling = :idCarpooling");
                $stmt->execute(['idUser' => $idUser, 'idCarpooling' => $idCarpooling]);
                $booking = $stmt->fetch();

                if (!$booking) {
                    $this->pdo->rollBack();
                    return false; // aucune réservation trouvée
                }

                // Supprimer la réservation
                $stmt = $this->pdo->prepare("DELETE FROM Participer WHERE id_user = :idUser AND id_carpooling = :idCarpooling");
                $stmt->execute(['idUser' => $idUser, 'idCarpooling' => $idCarpooling]);

                // Rembourser crédits passager
                $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user + :price WHERE id_user = :idUser");
                $stmt->execute(['price' => $pricePlace, 'idUser' => $idUser]);

                // Retirer crédits chauffeur
                $stmt = $this->pdo->prepare("UPDATE user SET credit_user = credit_user - :price WHERE id_user = :driverId");
                $stmt->execute(['price' => $pricePlace, 'driverId' => $driverId]);

                // Retirer les crédits de la plateforme (1 réservation)
                $stmt = $this->pdo->prepare("DELETE FROM platform_earnings WHERE id_carpooling = :idCarpooling LIMIT 1");
                $stmt->execute(['idCarpooling' => $idCarpooling]);

                // Réaugmenter le nombre de places disponibles
                $stmt = $this->pdo->prepare("UPDATE carpooling SET nb_place = nb_place + 1 WHERE id_carpooling = :idCarpooling");
                $stmt->execute(['idCarpooling' => $idCarpooling]);
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
