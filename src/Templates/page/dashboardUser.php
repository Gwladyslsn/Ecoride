<?php
require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\UserRepository;
use App\Database\Database;

// Connexion BDD et instanciation
$database = new Database();
$pdo = $database->getConnection();
$userRepo = new UserRepository($pdo);

if (isset($_SESSION['user'])) {
    $id_user = $_SESSION['user'];

    // Récupérer les infos utilisateur avec la méthode correcte
    $user = $userRepo->getDataUser($id_user);

    // Récupérer le rôle (table role)
    $role = $userRepo->getRole((int) $user['id_role']);

    // Récupérer la voiture liée à l'utilisateur
    $car = $userRepo->getDataCar($id_user);

    // Construction des chemins vers les images
    $avatarPath = !empty($user['avatar_user'])
        ? '/asset/uploads/avatars/' . htmlspecialchars($user['avatar_user'])
        : 'https://placehold.co/128x128/a78bfa/ffffff?text=Avatar';

    $avatarPathCar = !empty($car['photo_car'])
        ? '/asset/uploads/car/' . htmlspecialchars($car['photo_car'])
        : 'https://placehold.co/128x128/a78bfa/ffffff?text=car';

    // 🛠 Mise à jour des infos utilisateur si formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $data = [];

    if (!empty($_POST['name_user'])) $data['name_user'] = $_POST['name_user'];
    if (!empty($_POST['lastname_user'])) $data['lastname_user'] = $_POST['lastname_user'];
    if (!empty($_POST['email_user'])) $data['email_user'] = $_POST['email_user'];
    if (!empty($_POST['phone_user'])) $data['phone_user'] = $_POST['phone_user'];

    $updated = $userRepo->updateUserInfo($id_user, $data);

    if ($updated) {
        $successMessage = "Profil mis à jour avec succès.";
    } else {
        $errorMessage = "Échec de la mise à jour.";
    }
}

// 🛠 Mise à jour des infos voiture si formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_car'])) {
    $dataCar = [];

    if (!empty($_POST['brand_car'])) $dataCar['brand_car'] = $_POST['brand_car'];
    if (!empty($_POST['model_car'])) $dataCar['model_car'] = $_POST['model_car'];
    if (!empty($_POST['color_car'])) $dataCar['color_car'] = $_POST['color_car'];
    if (!empty($_POST['year_car'])) $dataCar['year_car'] = $_POST['year_car'];
    if (!empty($_POST['energy_car'])) $dataCar['energy_car'] = $_POST['energy_car'];
    // Ajoute d'autres champs si besoin

    $updatedCar = $userRepo->updateCarInfo($id_user, $dataCar['brand_car'], $dataCar['model_car'], $dataCar['color_car'], $dataCar['year_car'], $dataCar['energy_car']);
    
    if ($updatedCar) {
        $successMessage = "Voiture mise à jour avec succès.";
    } else {
        $errorMessage = "Échec de la mise à jour de la voiture.";
    }
}
}
?>


<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-center">Mon Espace Utilisateur</h1>
    <div class="profile-section flex flex-col md:flex-row items-center md:items-start gap-6">
        <div class="flex-shrink-0">
            <img
                src="/uploads/<?= htmlspecialchars($user['avatar_user']) ?>"
                alt="icone de profil"
                class="w-32 h-32 rounded-full object-cover border-4 border-purple-300 shadow-md">
        </div>
        <div class="flex-grow text-center md:text-left">
            <h2 class="text-2xl font-semibold text-gray-900"><?= $user["name_user"]; ?></h2>
            <p class="text-gray-600"><?= $role['name_role']; ?></p>
            <button id="edit-photo" class="btn rounded-md">Modifier ma photo</button>
            <form action="<?= BASE_URL ?>updateAvatar" method="POST" enctype="multipart/form-data" class="mt-4">
                <input id="file-input" type="file" name="avatar_user" accept="image/*" class="mb-2 hidden text-gray-600">
                <button id="submit-btn" type="submit" name="upload_avatar" class="hidden px-3 py-1 bg-indigo-600 text-white rounded">
                    Mettre à jour la photo
                </button>
            </form>
        </div>
    </div>

    <div class="profile-section">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">Mes Informations Personnelles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 ">
            <div><span class="font-medium">Nom :</span> <span class="text-gray-900 edit-info" data-field="lastname_user"><?= $user["lastname_user"]; ?></span></div>
            <div><span class="font-medium">Prénom :</span> <span class="text-gray-900 edit-info" data-field="name_user"><?= $user["name_user"]; ?></span></div>
            <div><span class="font-medium">Date de naissance :</span> <span class="text-gray-900 edit-info" data-field="dob_user"><?= $user["dob_user"]; ?></span></div>
            <div><span class="font-medium">E-mail :</span> <span class="text-gray-900 edit-info" data-field="email_user"><?= $user["email_user"]; ?></span></div>
            <div><span class="font-medium">Téléphone :</span> <span class="text-gray-900 edit-info" data-field="phone_user"><?= $user["phone_user"]; ?></span></div>
        </div>
        <button id="edit-user-btn" class="mt-6 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition-colors shadow-sm edit-btn">
            Modifier mes informations
        </button>
    </div>

    <div class="profile-section">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">Mes Préférences de Trajet</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Tabac :</span>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Animaux :</span>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Musique :</span>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Parler :</span>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <?php if ($user['id_role'] !== 2): ?>
        <div class="profile-section car-section">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">Mon Véhicule</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <div><span class="font-medium">Marque :</span> <span class="text-gray-900 edit-car" data-field="brand_car"><?= $car ? $car["brand_car"] : "non-renseigné" ?></span></div>
                <div><span class="font-medium">Modèle :</span> <span class="text-gray-900 edit-car" data-field="model_car"><?= $car ? $car["model_car"] : "non-renseigné" ?></span></div>
                <div><span class="font-medium">Année :</span> <span class="text-gray-900 edit-car" data-field="year_car"><?= $car ? $car["year_car"] : "non-renseigné" ?></span></div>
                <div><span class="font-medium">Énergie :</span> <span class="text-gray-900 edit-car" data-field="energy_car"><?= $car ? $car["energy_car"] : "non-renseigné" ?></span></div>
            </div>
            <button id="edit-btn-car" class="mt-6 px-4 py-2 text-white rounded-md shadow-sm edit-btn">
                Modifier mon véhicule
            </button>
            <div class="flex-shrink-0">
                <img
                    src="<?= $avatarPathCar ?>"alt="Illustration de voiture" class="w-90 h-50 object-cover border-4 shadow-md">
            </div>
            <button id="edit-photo-car" class="btn rounded-md">Modifier la photo de ma voiture</button>
            <form action="<?= BASE_URL ?>updateCar" method="POST" enctype="multipart/form-data" class="mt-4">
                <input id="file-input-car" type="file" name="photo_car" accept="image/*" class="mb-2 hidden text-gray-600">
                <button id="submit-btn-car" type="submit" name="photo_car" class="hidden px-3 py-1 bg-indigo-600 text-white rounded">
                    Mettre à jour la photo
                </button>
            </form>
        </div>
    <?php endif; ?>

<?php if ($user['id_role'] !== 2): ?>
    <div class="text-center mt-8">
        <button class="px-6 py-3 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition-colors shadow-md">
            <a href="<?= BASE_URL ?>addCarpooling">Proposer un trajet</a>
        </button>
                <button class="px-6 py-3 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition-colors shadow-md">
            <a href="<?= BASE_URL ?>searchCarpooling">Rechercher un trajet</a>
        </button>
    </div>
    <?php else: ?>
        <div class="text-center mt-8">
        <button class="px-6 py-3 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition-colors shadow-md">
            <a href="<?= BASE_URL ?>searchCarpooling">Rechercher un trajet</a>
        </button>
    </div>
    <?php endif; ?>
</div>




<?php
$page_script = '/asset/js/dashboardUser.js';
require_once ROOTPATH . '/src/Templates/footer.php';
?>
