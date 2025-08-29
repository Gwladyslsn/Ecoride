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
        'comment_reviews'=> $tripReview->getCommentReviews(),
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

// Dans TripReviewRepository
public function hasReview(int $idUser, int $idRecipient, int $idCarpooling): bool {
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





}