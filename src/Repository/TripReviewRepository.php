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
    // Vérifier si l'avis existe déjà
    $sqlCheck = "SELECT COUNT(*) FROM reviews 
                WHERE id_user = :id_user 
                AND id_recipient = :id_recipient 
                AND id_carpooling = :id_carpooling";
    $stmtCheck = $this->pdo->prepare($sqlCheck);
    $stmtCheck->execute([
        'id_user' => $tripReview->getIdUser(),
        'id_recipient' => $tripReview->getIdRecipient(),
        'id_carpooling' => $tripReview->getIdCarpooling()
    ]);

    if ($stmtCheck->fetchColumn() > 0) {
        // L'avis existe déjà
        return 0; // <- on renvoie 0 pour indiquer "déjà laissé"
    }

    // Insérer l'avis
    $sqlInsert = "INSERT INTO reviews (note_reviews, date_reviews, comment_reviews, status_reviews, id_user, id_recipient, id_carpooling) 
                VALUES (:note, :date, :comment, :status, :id_user, :id_recipient, :id_carpooling)";
    $stmtInsert = $this->pdo->prepare($sqlInsert);

    try {
        $stmtInsert->execute([
            'note' => $tripReview->getNoteReviews(),
            'date' => $tripReview->getDateReviews()->format('Y-m-d H:i:s'),
            'comment' => $tripReview->getCommentReviews(),
            'status' => $tripReview->getStatusReviews(),
            'id_user' => $tripReview->getIdUser(),
            'id_recipient' => $tripReview->getIdRecipient(),
            'id_carpooling' => $tripReview->getIdCarpooling()
        ]);

        return (int)$this->pdo->lastInsertId();
    } catch (\PDOException $e) {
        return null; // erreur SQL
    }
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

    public function getReviewsPending(): array
{
    $sql = "SELECT * FROM reviews WHERE status_reviews = 'pending' ORDER BY id_reviews";
    $stmt = $this->pdo->query($sql);
    $reviewPending = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $reviewPending; // ✅ retourne un array
}

    public function getReviewsAccept(): array
{
    $sql = "SELECT * FROM reviews WHERE status_reviews = 'accept' ORDER BY id_reviews";
    $stmt = $this->pdo->query($sql);
    $reviewsAccepted = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $reviewsAccepted; // ✅ retourne un array
}

    public function getReviewsReject(): array
{
    $sql = "SELECT * FROM reviews WHERE status_reviews = 'reject' ORDER BY id_reviews";
    $stmt = $this->pdo->query($sql);
    $reviewsRejected = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $reviewsRejected; // ✅ retourne un array
}

    public function getReviewsProcessed(): array
{
    $sql = "SELECT * FROM reviews WHERE status_reviews = 'reject' OR status_reviews = 'accept' ORDER BY id_reviews";
    $stmt = $this->pdo->query($sql);
    $reviewsProcessed = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $reviewsProcessed; // ✅ retourne un array
}

    public function getNoteAverage(): ?float
    {
        $sql = "SELECT AVG(note_reviews) AS average_note FROM reviews";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['average_note'] !== null 
        ? round((float)$result['average_note'], 1) 
        : null;
    }

    public function getDataNewReviews()
    {
        $sql = "SELECT 
            r.id_reviews,
            r.note_reviews,
            r.comment_reviews,
            r.date_reviews,
            r.status_reviews,
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

    public function getDataOldReviews()
    {
        $sql = "SELECT 
            r.id_reviews,
            r.note_reviews,
            r.comment_reviews,
            r.date_reviews,
            r.status_reviews,
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
        WHERE r.status_reviews = 'accept' OR r.status_reviews = 'reject'
        ORDER BY r.date_reviews DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // UPDATE

    public function updateStatus(int $idReview, string $status, int $idEmployee): bool
    {
        $sql = "UPDATE reviews SET status_reviews = :status, id_employee = :id_employee WHERE id_reviews = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id_employee' => $idEmployee,
            'id' => $idReview            

        ]);
    }
}
