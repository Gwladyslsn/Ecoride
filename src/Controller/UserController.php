<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Database\Database;

class UserController
{
    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Mauvaise méthode']);
            exit;
        }

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

    public function updateAvatar()
{
    session_start();
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        http_response_code(401); // Non autorisé
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
        return;
    }

    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l’image.']);
        return;
    }

    $avatar = $_FILES['avatar'];

    // Vérifie que c'est bien une image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($avatar['type'], $allowedTypes)) {
        http_response_code(415); // Unsupported Media Type
        echo json_encode(['success' => false, 'message' => 'Type de fichier non supporté.']);
        return;
    }

    // Génère un nom de fichier unique
    $extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
    $newFileName = 'avatar_' . $userId . '_' . time() . '.' . $extension;

    $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // crée le dossier si inexistant
    }

    $destination = $uploadDir . $newFileName;

    if (!move_uploaded_file($avatar['tmp_name'], $destination)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l’enregistrement du fichier.']);
        return;
    }

    // Met à jour l'utilisateur
    require_once ROOTPATH . '/src/Repository/UserRepository.php';
    $userRepo = new \App\Repository\UserRepository($this->pdo);

    $relativePath = '/uploads/avatars/' . $newFileName;
    $userRepo->updateAvatar($userId, $relativePath);

    echo json_encode(['success' => true, 'avatarPath' => $relativePath]);
}

    public function updateCar()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Requête invalide ou utilisateur non connecté.']);
        return;
    }

    $userId = $_SESSION['user'];

    // Récupération des données JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $carBrand = htmlspecialchars($data['brand_car'] ?? '');
    $carModel = htmlspecialchars($data['model_car'] ?? '');
    $carYear = htmlspecialchars($data['year_car'] ?? '');
    $carEnergy = htmlspecialchars($data['energy_car'] ?? '');


    // Mise à jour
    $database = new Database();
    $pdo = $database->getConnection();
    $userRepo = new UserRepository($pdo);

    $userId = $_SESSION['user'];
    $success = $userRepo->updateCarInfo($userId, $carBrand,$carModel,  $carYear, $carEnergy);

    echo json_encode(['success' => $success]);
}

}
