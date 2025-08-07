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
        WHERE p.id_user = :userId AND DATE(c.date_depart) = :date";
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
        $stmt->execute();
        return $stmt->execute();
    }
}
