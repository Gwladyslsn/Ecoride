<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Entity\ReviewRepository;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    try {
        $repo = new ReviewRepository();
        $result = $repo->addReview($input);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
