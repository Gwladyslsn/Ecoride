<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Database\Database;

class BookingController
{
    private BookingRepository $bookingRepository;

    public function __construct()
    {
        $pdo = (new Database())->getConnection();
        $this->bookingRepository = new BookingRepository($pdo);
    }

    public function bookTrip(): void
    {
        header('Content-Type: application/json');

        // Vérifie si utilisateur connecté
        if (!isset($_SESSION['user'])) {
            echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
            exit;
        }

        // Récupération des données JSON envoyées
        $data = json_decode(file_get_contents('php://input'), true);
        file_put_contents('php://stderr', print_r($data, true));  // écrit dans le log Apache

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
            exit;
        }

        $userId = $_SESSION['user'];
        $carpoolingId = $data['id_carpooling'] ?? null;

        if (!$carpoolingId) {
            echo json_encode(['status' => 'error', 'message' => 'ID trajet manquant']);
            exit;
        }

        // vérifier la réservation
        $dateDepart = $this->bookingRepository->getDateDepart($carpoolingId);
        if (!$dateDepart) {
            echo json_encode(['status' => 'error', 'message' => 'Trajet introuvable']);
            exit;
        }

        // Vérifie si utilisateur a déjà réservé ce trajet
        if ($this->bookingRepository->userAlreadyBooked($userId, $carpoolingId)) {
            echo json_encode(['status' => 'deja_reserve', 'message' => 'Vous avez déjà réservé ce trajet']);
            exit;
        }

        // Vérifie si utilisateur a déjà une réservation à la même date
        if ($this->bookingRepository->userBookingOnDate($userId, $dateDepart)) {
            echo json_encode(['status' => 'autre_trajet_ce_jour', 'message' => 'Vous avez déjà réservé un trajet ce jour-là']);
            exit;
        }

        // Vérifie si le trajet est complet
        if ($this->bookingRepository->isTripFull($carpoolingId)) {
            echo json_encode(['status' => 'complet', 'message' => 'Ce trajet est complet.']);
            exit;
        }



        // Ajoute la réservation
        $added = $this->bookingRepository->addBooking($userId, $carpoolingId);

        switch ($added) {
            case true:
                echo json_encode(['status' => 'ok', 'message' => 'Réservation effectuée avec succès']);
                break;
            case 'insufficient_credit':
                echo json_encode(['status' => 'error', 'message' => 'Crédits insuffisants pour réserver ce trajet.']);
                break;
            case 'user_not_found':
                echo json_encode(['status' => 'error', 'message' => 'Utilisateur introuvable.']);
                break;
            case 'carpooling_not_found':
                echo json_encode(['status' => 'error', 'message' => 'Trajet introuvable.']);
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la réservation.']);
        }

        exit;
    }
}
