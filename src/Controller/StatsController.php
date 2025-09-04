<?php

namespace App\Controller;

use App\Database\Database;

class StatsController
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    // Renvoyer le nombre de covoiturages par jour
    public function getCarpoolingsPerDay(): void
    {
        header('Content-Type: application/json');

        $sql = "SELECT DATE(departure_date) as day, COUNT(*) as total
                FROM carpooling
                GROUP BY day
                ORDER BY day ASC";

        $stmt = $this->pdo->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode($results);
    }

    // renvoie le nombre de crédit gagnés par jour
    public function getCreditPerDay(): void
    {
        header('Content-Type: application/json');

        $sql = "SELECT DATE(earned_at) as day, SUM(credits_earned) as total
                FROM platform_earnings
                GROUP BY day
                ORDER BY day ASC";
        $creditPerDay = $this->pdo->query($sql);
        $results = $creditPerDay->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($results);
    }
}
