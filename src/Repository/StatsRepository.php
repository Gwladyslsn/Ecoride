<?php

namespace App\Repository;

use PDO;

class StatsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCarpoolingsPerDay(): array
{
    $sql = "WITH RECURSIVE all_dates AS (
                SELECT (SELECT MIN(DATE(departure_date)) FROM carpooling) AS day
                UNION ALL
                SELECT day + INTERVAL 1 DAY
                FROM all_dates
                WHERE day + INTERVAL 1 DAY <= CURDATE()
            )
            SELECT d.day, COALESCE(c.total, 0) AS total
            FROM all_dates d
            LEFT JOIN (
                SELECT DATE(departure_date) AS day, COUNT(*) AS total
                FROM carpooling
                GROUP BY day
            ) c ON d.day = c.day
            ORDER BY d.day ASC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


        // renvoie le nombre de crédit gagnés par jour
    public function getCreditsPerDay()
    {
        header('Content-Type: application/json');

        $sql = "SELECT DATE(earned_at) as day, SUM(credits_earned) as total
                FROM platform_earnings
                GROUP BY day
                ORDER BY day ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $creditPerDay = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
