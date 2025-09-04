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
        $name = $data['nameReviewEcoride'] ?? '';
        $email = $data['emailReviewEcoride'] ?? '';
        $note = (int)($data['selectedRating'] ?? 0);
        $comment = $data['textReviewEcoride'] ?? '';
        $date = (new DateTime())->format(DateTime::ATOM);

        $result = $this->collection->insertOne([
            'name' => $name,
            'email' => $email,
            'note' => $note,
            'comment' => $comment,
            'created_at' => $date
        ]);

        return [
            'success' => true,
            'insertedId' => (string)$result->getInsertedId()
        ];
    }

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
