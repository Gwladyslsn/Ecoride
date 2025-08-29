<?php

namespace App\Controller;

use App\Repository\TripReviewRepository;
use App\Entity\TripReview;
use App\Database\Database;

class ReviewController
{
    private TripReviewRepository $reviewRepository;

    public function __construct()
    {
        $pdo = (new Database())->getConnection();
        $this->reviewRepository = new TripReviewRepository($pdo);
    }

    /*Ajoute un avis depuis un formulaire */
    public function addReview(): void
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
            exit;
        }

        $note_reviews    = isset($data['note_reviews']) ? (int)$data['note_reviews'] : null;
        $comment_reviews = $data['comment_reviews'] ?? null;
        $idUser  = $_SESSION['user'] ?? null;
        $idRecipient = isset($data['id_recipient']) ? (int)$data['id_recipient'] : null;
        $idCarpooling = isset($data['id_carpooling']) ? (int)$data['id_carpooling'] : null;

        if (is_null($note_reviews)) {
            echo json_encode(['status' => 'error', 'message' => 'note_reviews = null']);
            exit;
        }

        if (empty(trim($comment_reviews))) {
            echo json_encode(['status' => 'error', 'message' => 'comment_reviews = null']);
            exit;
        }


        if (is_null($idRecipient)) {
            echo json_encode(['status' => 'error', 'message' => 'id_Recipient = null']);
            exit;
        }


        $tripReview = new TripReview(
            $note_reviews,
            new \DateTime(),
            $comment_reviews,
            'pending',
            $idUser,
            $idRecipient,
            $idCarpooling
        );


        $success = $this->reviewRepository->newTripReview($tripReview);

        if ($success) {
            echo json_encode(['status' => 'ok', 'message' => 'Avis ajouté avec succès']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'avis']);
        }

        exit;
    }

}
