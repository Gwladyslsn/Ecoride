<?php

namespace App\Repository;

use PDO;
use App\Entity\TripReview;
use App\Entity\Carpooling;

class TripReviewRepository
{

    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function newTripReview(TripReview $tripReview): ?int
    {
        $sql = "INSERT INTO reviews (
        note_reviews, date_reviews, comment_reviews, status_reviews, id_user, id_recipient, id_carpooling
    ) VALUES (
        :note_reviews, :date_reviews, :comment_reviews, :status_reviews, :id_user, :id_recipient, :id_carpooling
    )";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            'note_reviews'   => $tripReview->getNoteReviews(),
            'date_reviews'   => $tripReview->getDateReviews()->format('Y-m-d'),
            'comment_reviews' => $tripReview->getCommentReviews(),
            'status_reviews' => $tripReview->getStatusReviews(),
            'id_user'        => $tripReview->getIdUser(),
            'id_recipient'   => $tripReview->getIdRecipient(),
            'id_carpooling'  => $tripReview->getIdCarpooling(),
        ]);


        if ($success) {
            return (int)$this->pdo->lastInsertId();
        }

        return null;
    }


    public function hasReview(int $idUser, int $idRecipient, int $idCarpooling): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT 1 FROM reviews 
        WHERE id_user = :idUser AND id_recipient = :idRecipient AND id_carpooling = :idCarpooling
    ");
        $stmt->execute([
            'idUser' => $idUser,
            'idRecipient' => $idRecipient,
            'idCarpooling' => $idCarpooling
        ]);
        return (bool) $stmt->fetchColumn();
    }

    public function getAllTripReviews()
    {
        $sql = "SELECT * FROM reviews ORDER BY id_reviews";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTripsPending(): array
{
    $sql = "SELECT * FROM reviews WHERE status_reviews = 'pending' ORDER BY id_reviews";
    $stmt = $this->pdo->query($sql);
    $tripsPending = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $tripsPending; // ✅ retourne un array
}

    public function getNoteAverage(): ?float
    {
        $sql = "SELECT AVG(note_reviews) AS average_note FROM reviews";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['average_note'] ?? null;
    }

    public function getDataNewReviews()
    {
        $sql = "SELECT 
            r.id_reviews,
            r.note_reviews,
            r.comment_reviews,
            r.date_reviews,
            u_from.id_user   AS author_id,
            CONCAT(u_from.name_user, ' ', u_from.lastname_user) AS author_name,
            u_to.id_user     AS recipient_id,
            CONCAT(u_to.name_user, ' ', u_to.lastname_user) AS recipient_name,
            c.departure_city,
            c.arrival_city,
            c.departure_date,
            c.departure_hour
        FROM reviews r
        INNER JOIN user u_from ON r.id_user = u_from.id_user
        INNER JOIN user u_to   ON r.id_recipient = u_to.id_user
        INNER JOIN carpooling c ON r.id_carpooling = c.id_carpooling
        WHERE r.status_reviews = 'pending'
        ORDER BY r.date_reviews DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $idReview, string $status): bool
    {
        $sql = "UPDATE reviews SET status_reviews = :status WHERE id_reviews = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $idReview
        ]);
    }
}
