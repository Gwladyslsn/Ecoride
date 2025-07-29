<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Database\Database;

class UserController
{
    public function updateUser()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Mauvaise méthode']);
            exit;
        }

        session_start();
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(['success' => false, 'message' => 'Données JSON invalides']);
            exit;
        }

        $userId = $_SESSION['user'];

        $db = new Database();
        $pdo = $db->getConnection();
        $userRepo = new UserRepository($pdo);

        $data = [];
        if (!empty($input['name_user'])) $data['name_user'] = $input['name_user'];
        if (!empty($input['lastname_user'])) $data['lastname_user'] = $input['lastname_user'];
        if (!empty($input['email_user'])) $data['email_user'] = $input['email_user'];
        if (!empty($input['phone_user'])) $data['phone_user'] = $input['phone_user'];

        $success = $userRepo->updateUserInfo($userId, $data);

        echo json_encode(['success' => $success]);
        exit;
    }

    public function updateCar()
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Requête invalide ou utilisateur non connecté.']);
        return;
    }

    $userId = $_SESSION['user'];
    $carModel = htmlspecialchars($_POST['car_model'] ?? '');
    $carColor = htmlspecialchars($_POST['car_color'] ?? '');
    $photoPath = null;

    // Gestion du fichier uploadé
    if (isset($_FILES['car_photo']) && $_FILES['car_photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = ROOTPATH . '/public/uploads/cars/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES['car_photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('car_', true) . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['car_photo']['tmp_name'], $destination)) {
            $photoPath = '/uploads/cars/' . $filename;
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l’enregistrement du fichier.']);
            return;
        }
    }

    // Mise à jour en base
    $database = new Database();
    $pdo = $database->getConnection();
    $userRepo = new UserRepository($pdo);

    $success = $userRepo->updateCarInfo($userId, $carModel, $carColor, $photoPath);

    echo json_encode(['success' => $success]);
}

}
