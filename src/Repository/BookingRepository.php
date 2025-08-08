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

    public function addBooking($userId, $carpoolingId){
        $query = "INSERT INTO Participer (id_user, id_carpooling, date_reservation)
        VALUES (:userId, :carpoolingId, NOW())";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':carpoolingId', $carpoolingId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
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
