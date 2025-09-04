<?php

namespace App\Controller;

use App\Repository\StatsRepository;
use App\Database\Database;
class StatsController
{
    private StatsRepository $statRepo;

    public function __construct()
    {
        $pdo = (new Database())->getConnection();
        $this->statRepo = new StatsRepository($pdo);
    }

    public function getCarpoolingsPerDay(): void
    {
        header('Content-Type: application/json');

        try {
            $results = $this->statRepo->getCarpoolingsPerDay();
            echo json_encode($results);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Impossible de récupérer les statistiques']);
        }
    }

    public function getCreditsPerDay()
    {
        header('Content-Type: application/json');

        try {
            $results = $this->statRepo->getCreditsPerDay();
            echo json_encode($results);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Impossible de récupérer les statistiques']);
        }
    }
}
