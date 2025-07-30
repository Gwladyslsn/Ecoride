<?php

namespace App\Controller;

use App\Repository\CarpoolingRepository;
use App\Repository\CarRepository;
use App\Entity\Carpooling;
use App\Database\Database;

class CarpoolingController
{


    /**
     * Ajoute un nouveau trajet en base
     */
public function newCarpooling(): void
{
    $database = new Database();
    $pdo = $database->getConnection();

    $carpoolingRepo = new CarpoolingRepository($pdo);
    $carRepo = new CarRepository($pdo);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405); // Méthode non autorisée
        exit;
    }

    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Données invalides']);
        exit;
    }

    $userId = $_SESSION['user'];

    // On récupère la voiture de l'utilisateur
    $carData = $carRepo->findByUserId((int)$userId);

    if (!$carData || !isset($carData['id_car'])) {
        echo json_encode(['success' => false, 'message' => 'Aucune voiture trouvée']);
        exit;
    }

    $idCar = $carData['id_car'];

    // Création des dates en objets DateTime sécurisés
    $departureDate = !empty($data['departure_date']) ? new \DateTime($data['departure_date']) : null;
    $arrivalDate = !empty($data['arrival_date']) ? new \DateTime($data['arrival_date']) : null;

    if (!$departureDate || !$arrivalDate) {
        echo json_encode(['success' => false, 'message' => 'Les dates de départ et d\'arrivée sont obligatoires']);
        exit;
    }

    // Création de l'objet Carpooling
    try {
        $carpooling = new Carpooling(
            $data['departure_city'],
            $departureDate,
            $data['departure_hour'],
            $data['arrival_city'],
            $arrivalDate,
            $data['arrival_hour'],
            (int) $data['nb_place'],
            (float) $data['price_place'],
            (int) $idCar
        );
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de format des dates']);
        exit;
    }

    // Sauvegarde en base
    $success = $carpoolingRepo->newCarpooling($carpooling);

    echo json_encode(['success' => $success]);
}

}
