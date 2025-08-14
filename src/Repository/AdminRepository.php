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
            COUNT(p.id_participation) AS booked_seats,
            CASE 
                WHEN ca.energy_car = 'Electrique' THEN 1
                ELSE 0
            END AS is_ecologic
        FROM carpooling c
        JOIN user u 
            ON c.driver_id = u.id_user
        JOIN car ca 
            ON c.id_car = ca.id_car
        LEFT JOIN Participer p 
            ON p.id_carpooling = c.id_carpooling
        GROUP BY c.id_carpooling
        ORDER BY c.departure_date
    ";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarpoolingStats(): array
    {
        $sql = "
            SELECT
                -- Covoiturages en cours (date + heure >= maintenant)
                (SELECT COUNT(*) 
                 FROM carpooling 
                 WHERE TIMESTAMP(departure_date, departure_hour) >= NOW()) AS nb_carpoolings_in_progress,

                -- Covoiturages passés (date + heure < maintenant)
                (SELECT COUNT(*) 
                 FROM carpooling 
                 WHERE TIMESTAMP(departure_date, departure_hour) < NOW()) AS nb_carpoolings_past,

                -- Covoiturages prévus aujourd'hui
                (SELECT COUNT(*) 
                 FROM carpooling 
                 WHERE departure_date = CURDATE()) AS nb_carpoolings_today,

                -- Nombre total de covoiturages
                (SELECT COUNT(*) 
                 FROM carpooling) AS nb_carpoolings_total,

                 -- Nombre total de réservations
                (SELECT COUNT(*) 
                 FROM Participer) AS nb_reservations_total,

                -- Conducteur avec le plus de covoiturages
                (SELECT driver_id
                 FROM carpooling
                 GROUP BY driver_id
                 ORDER BY COUNT(*) DESC
                 LIMIT 1) AS top_driver_id,

                -- Trajet le plus populaire
                (SELECT CONCAT(departure_city, ' → ', arrival_city)
                 FROM carpooling
                 GROUP BY departure_city, arrival_city
                 ORDER BY COUNT(*) DESC
                 LIMIT 1) AS top_route
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/*         -- Conducteur avec le plus de covoiturages
        (SELECT driver_id
         FROM carpoolings
         GROUP BY driver_id
         ORDER BY COUNT(*) DESC
         LIMIT 1) AS top_driver_id, */
