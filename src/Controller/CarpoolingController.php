<?php

namespace App\Controller;

use App\Repository\CarpoolingRepository;
use App\Repository\CarRepository;
use App\Entity\Carpooling;
use App\Database\Database;
use App\Service\CityVerifier;
use App\Repository\UserRepository;

class CarpoolingController
{

    // READ
    public function newCarpooling(): void
    {
        $database = new Database();
        $pdo = $database->getConnection();

        $carpoolingRepo = new CarpoolingRepository($pdo);
        $carRepo = new CarRepository($pdo);
        $cityVerifier = new CityVerifier(); // ✅ Ajout du service de vérification

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

        // Vérification des villes via API ✅
        $departureCity = $data['departure_city'] ?? '';
        $arrivalCity = $data['arrival_city'] ?? '';

        if (!$cityVerifier->cityExists($departureCity)) {
            echo json_encode(['success' => false, 'message' => "La ville de départ \"$departureCity\" n'existe pas."]);
            exit;
        }

        sleep(2); // ou plus nécessaire grâce au cache

        if (!$cityVerifier->cityExists($arrivalCity)) {
            echo json_encode(['success' => false, 'message' => "La ville d'arrivée \"$arrivalCity\" n'existe pas."]);
            exit;
        }

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
                $departureCity,
                $departureDate,
                $data['departure_hour'],
                $arrivalCity,
                $arrivalDate,
                $data['arrival_hour'],
                (int) $data['nb_place'],
                (float) $data['price_place'],
                $data['info_carpooling'],
                (int) $idCar,
                (int) $userId 
            );
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur de format des dates']);
            exit;
        }

        // Sauvegarde en base
        $success = $carpoolingRepo->newCarpooling($carpooling);

        echo json_encode(['success' => $success]);
    }


    // READ

    public function showTrips()
    {
        $database = new Database();
        $pdo = $database->getConnection();

        $carpoolingRepo = new CarpoolingRepository($pdo);

        $departure = $_POST['departureCitySearch'] ?? null;
        $arrival = $_POST['arrivalCitySearch'] ?? null;
        $date = $_POST['dateSearch'] ?? null;

        if ($departure && $arrival && $date) {
            $trips = $carpoolingRepo->showTripsSearched($departure, $arrival, $date);
        } else {
            $trips = $carpoolingRepo->getAllTrips();
        }

        // Envoie les trajets à la vue
        require_once ROOTPATH . 'src/Templates/page/Carpoolings.php';
    }
public function showTripDetails()
{
    $tripId = $_GET['id'] ?? null;
    if (!$tripId) return;

    $pdo = Database::getConnection();
    $carpoolingRepository = new CarpoolingRepository($pdo);
    $userRepo = new UserRepository($pdo);

    $trip = $carpoolingRepository->getTripById($tripId);

    if (!$trip) return;

    // ⚠️ Si $trip est un tableau
    $driverId = $trip['driver_id'];

    $driverPrefs = $userRepo->getUserPreferences($driverId);
    $allPrefs = $userRepo->getAllPreferences();
    $carpooling = $carpoolingRepository->getTripById($tripId);

    require_once ROOTPATH . 'src/Templates/page/tripDetails.php';
}


}
