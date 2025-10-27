<?php

namespace App\Repository;

use MongoDB\Client;
use DateTime;

class ReviewRepository
{
    private $collection;

    public function __construct()
    {
        $uri = getenv('MONGODB_URI');
        if (!$uri) {
            throw new \Exception("Erreur : MONGODB_URI non défini");
        }

        $client = new Client($uri);
        $this->collection = $client->ecoride->reviews;
    }

    //CREATE
    public function addReview(array $data): array
{
    // Récupération des données avec valeurs par défaut
    $name = $data['nameReviewEcoride'] ?? '';
    $email = $data['emailReviewEcoride'] ?? '';
    $note = (int)($data['selectedRating'] ?? 0);
    $comment = $data['textReviewEcoride'] ?? '';
    $date = (new DateTime())->format(DateTime::ATOM);

    try {
        // Insertion dans la collection MongoDB
        $result = $this->collection->insertOne([
            'name' => $name,
            'email' => $email,
            'note' => $note,
            'comment' => $comment,
            'created_at' => $date
        ]);

        // Affichage pour debug
        echo "Insertion réussie ! ID : " . (string)$result->getInsertedId() . "\n";

        return [
            'success' => true,
            'insertedId' => (string)$result->getInsertedId()
        ];
    } catch (\Exception $e) {
        // Log de l'erreur pour debug
        error_log("Erreur MongoDB : " . $e->getMessage());
        echo "Erreur lors de l'insertion : " . $e->getMessage() . "\n";

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

// --- Test rapide ---
$test = $this->addReview([
    'nameReviewEcoride' => 'Test',
    'emailReviewEcoride' => 'test@test.com',
    'selectedRating' => 5,
    'textReviewEcoride' => 'Ceci est un test'
]);

var_dump($test);


    //READ

    public function getAllReviews(): array
    {
        $cursor = $this->collection->find();
        $reviews = [];

        foreach ($cursor as $review) {
            $reviews[] = $review;
        }

        return $reviews;
    }
}
