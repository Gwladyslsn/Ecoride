<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Database\Database;

class UserController
{
    public function updateAvatar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        if (!isset($_FILES['avatar_user'])) {
            echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu.']);
            return;
        }

        switch ($_FILES['avatar_user']['error']) {
            case UPLOAD_ERR_OK:
                // Tout va bien
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'Le fichier est trop volumineux.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'Le fichier n\'a été que partiellement téléchargé.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'Aucun fichier n\'a été téléchargé.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Dossier temporaire manquant.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Échec de l\'écriture sur le disque.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'Une extension PHP a arrêté le téléchargement.';
                break;
            default:
                $message = 'Erreur inconnue.';
        }

        if ($_FILES['avatar_user']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => $message]);
            return;
        }

        // Vérifie le type MIME
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES['avatar_user']['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Type de fichier non autorisé.']);
            return;
        }

        // Déplace le fichier dans le dossier "uploads"
        $uploadDir = ROOTPATH . 'public/asset/uploads/avatar/';
        $fileName = uniqid() . '_' . basename($_FILES['avatar_user']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['avatar_user']['tmp_name'], $destination)) {
            
            // Enregistre le chemin dans la BDD via UserRepository
            $userId = $_SESSION['user'];
            require_once ROOTPATH . 'src/Database/Database.php';
            $database = new Database();
            $pdo = $database->getConnection(); // ou tout autre fichier qui crée l'objet PDO
            $userRepo = new UserRepository($pdo);
            $userRepo->updateAvatar($userId, $fileName);

            header('Location: /dashboardUser'); // ou la page d’origine
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement du fichier.']);
        }
    }

    /*UPDATE USER*/
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



    /* UPDATE VOITURE */
    public function updateCar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Requête invalide ou utilisateur non connecté.']);
            return;
        }


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
        $success = $userRepo->updateCarInfo($userId, $carBrand, $carModel,  $carYear, $carEnergy);

        echo json_encode(['success' => $success]);
    }

    public function updateImgCar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        if (!isset($_FILES['photo_car'])) {
            echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu.']);
            return;
        }

        switch ($_FILES['photo_car']['error']) {
            case UPLOAD_ERR_OK:
                // Tout va bien
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'Le fichier est trop volumineux.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'Le fichier n\'a été que partiellement téléchargé.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'Aucun fichier n\'a été téléchargé.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Dossier temporaire manquant.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Échec de l\'écriture sur le disque.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'Une extension PHP a arrêté le téléchargement.';
                break;
            default:
                $message = 'Erreur inconnue.';
        }

        if ($_FILES['photo_car']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => $message]);
            return;
        }

        // Vérifie le type MIME
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES['photo_car']['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Type de fichier non autorisé.']);
            return;
        }

        // Déplace le fichier dans le dossier "uploads"
        $uploadDir = ROOTPATH . 'public/asset/uploads/cars/';
        $fileName = uniqid() . '_' . basename($_FILES['photo_car']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['photo_car']['tmp_name'], $destination)) {
            
            // Enregistre le chemin dans la BDD via UserRepository
            $userId = $_SESSION['user'];
            require_once ROOTPATH . 'src/Database/Database.php';
            $database = new Database();
            $pdo = $database->getConnection(); // ou tout autre fichier qui crée l'objet PDO
            $userRepo = new UserRepository($pdo);
            $userRepo->updateCarImg($userId, $fileName);

            header('Location: /dashboardUser'); // ou la page d’origine
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement du fichier.']);
        }

        
    }
}
