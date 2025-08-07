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

        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour réserver.";
        }

        $userId = $_SESSION['id_user'];

        if (!isset($_SESSION['id_user'])) {
            // Répondre avec une erreur JSON si l'utilisateur n'est pas connecté
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $carpoolingId = $_POST['id_carpooling'] ?? null;
        $dateDepart = $_POST['departure_date'] ?? null;

        if (!$carpoolingId || !$dateDepart) {
            $_SESSION['error'] = "Données de réservation incomplètes.";
        }

        // Vérifie si déjà réservé ce trajet
        if ($this->bookingRepository->userAlreadyBooked($userId, $carpoolingId)) {
            $_SESSION['error'] = "Vous avez déjà réservé ce trajet.";
        }

        // Vérifie si déjà une réservation ce jour-là
        if ($this->bookingRepository->userBookingOnDate($userId, $dateDepart)) {
            $_SESSION['error'] = "Vous avez déjà réservé un trajet ce jour-là.";
        }

        // Tente la réservation
        if ($this->bookingRepository->addBooking($userId, $carpoolingId)) {
            $_SESSION['success'] = "Réservation effectuée avec succès.";
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la réservation.";
        }
    }
}
