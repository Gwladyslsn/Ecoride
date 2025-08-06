<?php

use App\Repository\CarpoolingRepository;
use App\Database\Database;
use App\Repository\UserRepository;

require_once ROOTPATH . '/src/Templates/header.php';

$pdo = (new Database())->getConnection();
$userRepo = new UserRepository($pdo);

// Récupère l'ID depuis l'URL
$idCarpooling = $_GET['id'] ?? null;
$carpoolingRepo = new CarpoolingRepository($pdo);
$trip = $idCarpooling ? $carpoolingRepo->getTripById((int)$idCarpooling) : null;
// Protection si le trajet est introuvable
if (!$trip) {
    echo "🚫 Trajet introuvable.";
    exit;
}
$id_user = $trip['id_user']; // ✅ Récupération depuis le trajet
$user = $userRepo->getDataUser($id_user); // ✅ Maintenant c’est bon
$car = $userRepo->getDataCar($id_user);

$avatarDriver = !empty($trip['avatar_user'])
    ? '/asset/uploads/avatar/' . htmlspecialchars($trip['avatar_user'])
    : '/asset/image/userIconDeafault.png';

$avatarPathCar = !empty($car['photo_car'])
    ? '/asset/uploads/cars/' . htmlspecialchars($car['photo_car'])
    : 'https://placehold.co/128x128/a78bfa/ffffff?text=car';


?>

<div class="max-w-4xl mx-auto px-5 py-3 mt-10 mb-10 bg-lightblue rounded-lg shadow-lg">
    <h2 class="text-xl text-black font-bold mb-4 text-center">Détails du trajet</h2>
</div>



<div class="space-y-4 px-8 py-4 max-w-6xl mx-auto">
    <!-- Accordéon Trajet -->
    <details class="details border rounded-xl p-3 bg-white">
        <summary class="font-semibold text-black cursor-pointer text-center mb-4">Trajet</summary>
        <div class="flex flex-col md:flex-row md:justify-center items-center gap-4">
            <div class="mt-2 text-md text-gray-700">
                <p><strong>Départ :</strong> <?= htmlspecialchars($trip['departure_city']) ?> - <?= date('d/m/Y', strtotime($trip['departure_date'])) ?> à <?= htmlspecialchars($trip['departure_hour']) ?></p>
                <p><strong>Arrivée :</strong> <?= $trip['arrival_city'] ?> - <?= date('d/m/Y', strtotime($trip['arrival_date'])) ?> à <?= $trip['arrival_hour'] ?></p>
                <p><strong>Place(s) disponible(s) :</strong> <?= htmlspecialchars($trip['nb_place']) ?></p>
                <p><strong>EcoCrédit nécessaire :</strong> <?= htmlspecialchars($trip['price_place']) ?> <i class="fa-brands fa-pagelines"></i></p>
            </div>
            <div>
                <div id="map" class="map"></div>
            </div>
        </div>
    </details>

    <!-- Accordéon Chauffeur -->
    <details class="details border rounded-xl p-3 bg-white">
        <summary class="font-semibold text-black cursor-pointer text-center mb-4">Chauffeur</summary>
        <div class="flex flex-col md:flex-row md:justify-center items-center gap-8">
            <div class="mt-2 space-y-1 text-md flex flex-col items-center pl-4">
                <img src="<?= $avatarDriver; ?>" class="w-25 h-25 rounded-full" alt="avatar chauffeur">
                <p class="text-md text-gray-600"><?= htmlspecialchars($trip['name_user']) ?></p>
                <p class="text-md text-yellow-600">★ 4.8 (23 avis)</p>
            </div>
            <div class="flex flex-col">
                <div class="driver-preferences flex gap-4 mt-4">
                    <p class="text-black">Préférences de trajet : </p>
                    <?php foreach ($allPrefs as $pref):
                        // Est-ce que le conducteur a cette préférence ?
                        $hasPref = in_array($pref['id_preference'], $driverPrefs);

                        // Définir l'icône FontAwesome correspondante
                        $icons = [
                            1 => 'fa-smoking',       // Smoker
                            2 => 'fa-dog',           // Pet
                            3 => 'fa-music',         // Music
                            4 => 'fa-comments'       // Speak
                        ];
                        $iconClass = $icons[$pref['id_preference']] ?? 'fa-circle';
                    ?>
                        <i class="fa-solid <?= $iconClass ?> text-xl <?= $hasPref ? 'text-green-500' : 'text-red-500' ?>"
                            title="<?= htmlspecialchars($pref['preference_name']) ?>"></i>
                    <?php endforeach; ?>
                </div>
                <div>
                    <?php if ($trip['info_carpooling']): ?>
                        <p class="text-black"><strong>Message de <?= htmlspecialchars($trip['name_user']) ?> :</strong> <?= htmlspecialchars($trip['info_carpooling']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </details>

    <!-- Accordéon Véhicule -->
    <details class="details border rounded-xl p-3 bg-white">
        <summary class="font-semibold text-black cursor-pointer text-center mb-4">Véhicule</summary>
        <div class="flex flex-col md:flex-row md:justify-center items-center gap-4">
            <div>
                <p class="text-md text-gray-700 mt-1"> Marque : <?= $car['brand_car'] ?></p>
                <p class="text-md text-gray-700 mt-1"> Modèle : <?= $car['model_car'] ?></p>
                <p class="text-md text-gray-700 mt-1"> Année : <?= $car['year_car'] ?></p>
                <p class="text-md text-gray-700 mt-1"> Energie : <?= $car['energy_car'] ?></p>
            </div>
            <img src="<?= $avatarPathCar ?>" class="w-70 h-40 object-cover rounded" alt="Voiture">
        </div>
        <?php if ($car['energy_car'] === 'électrique'): ?>
            <img src="/asset/image/energy_green.webp" alt="Voiture électrique" class="w-12 h-12">
            <span class="text-black text-sm font-medium">Véhicule électrique</span>
        <?php endif; ?>
    </details>
</div>



<?php


?>
<script>
    const departureCity = "<?= $trip['departure_city'] ?>";
    const arrivalCity = "<?= $trip['arrival_city'] ?>";
</script>

<?php
$page_script = '/asset/js/tripMap.js';
require_once ROOTPATH . '/src/Templates/footer.php';
?>