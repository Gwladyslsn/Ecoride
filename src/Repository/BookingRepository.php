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

    public function userBookingOnDate($userId, $date)
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
}
