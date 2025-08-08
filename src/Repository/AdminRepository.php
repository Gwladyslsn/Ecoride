<?php

namespace App\Repository;

use PDO;

class AdminRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Compte tous les utilisateurs
    public function countUsers(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM user");
        return (int) $stmt->fetchColumn();
    }

    // Compte tous les trajets
    public function countCarpoolings(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM carpooling");
        return (int) $stmt->fetchColumn();
    }

    // trajets avec prise en compte des resa
    public function getCarpoolingsWithBookingStats(): array
    {
        $query = "
            SELECT 
                c.id_carpooling,
                c.departure_city,
                c.arrival_city,
                c.departure_date,
                c.arrival_date,
                c.departure_hour,
                c.arrival_hour,
                c.nb_place,
                c.price_place,
                c.driver_id,
                COUNT(p.id_participation) AS booked_seats
            FROM carpooling c
            JOIN user u ON c.driver_id = u.id_user
            LEFT JOIN Participer p ON p.id_carpooling = c.id_carpooling
            GROUP BY c.id_carpooling
            ORDER BY c.departure_date
        ";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
