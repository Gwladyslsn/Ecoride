<?php
$avatarDriver = !empty($trip['avatar_user'])
    ? '/asset/uploads/avatar/' . htmlspecialchars($trip['avatar_user'])
    : '/asset/image/userIconDeafault.png';

use App\Repository\CarRepository;
// Création du repository
$carRepo = new CarRepository($pdo);

// Vérifie que l'id_car existe dans $trip
$car = null;
if (!empty($trip['id_car'])) {
    $car = $carRepo->getCarById($trip['id_car']);
}




?>

<?php if ($trip['nb_place'] < 1): ?>
    <div class="trip w-full max-w-5xl bg-white rounded-2xl p-6 border border-3 border-red-600">
<?php else: ?>
    <div class="trip w-full max-w-5xl bg-white rounded-2xl p-6 border transition-all duration-300 transform hover:-translate-y-1">
<?php endif; ?>

    <!-- Driver Info -->
    <div class="flex items-center space-x-3 mb-6">
        <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center">
            <img src="<?= $avatarDriver; ?>" alt="icone de profil du conducteur" class="w-full h-full object-cover rounded-full">
        </div>
        <div>
            <h3 class="font-semibold text-black">Trajet proposé par <?= htmlspecialchars($trip['name_user']) ?></h3>
            <p class="text-sm text-gray-500">Conducteur expérimenté</p>
        </div>
    </div>

    <div class="flex justify-end">
        <p class="text-black">Prix : <?= htmlspecialchars($trip['price_place']) ?> <i class="fa-brands fa-pagelines"></i></p>
    </div>

    <!-- Route Info -->
    <div class="space-y-4 mb-6">
        <div class="">
            <div class="flex items-center space-x-4 route-line relative">
                <div class="flex-1">

                    <p class="font-semibold text-black"> <?= htmlspecialchars($trip['departure_city']) ?></p>
                    <p class="text-sm text-gray-500">Le <?= date('d/m/Y', strtotime($trip['departure_date'])) ?> à <?= htmlspecialchars($trip['departure_hour']) ?></p>
                </div>
            </div>
            <div class="flex items-center justify-between route-line relative">
                <!-- Infos de trajet -->
                <div>
                    <p class="font-semibold text-black"><?= $trip['arrival_city'] ?></p>
                    <p class="text-sm text-gray-500">Le <?= date('d/m/Y', strtotime($trip['arrival_date'])) ?> à <?= $trip['arrival_hour'] ?></p>
                </div>

                <!-- Énergie -->
                <?php if ($car && strtolower(trim($car['energy_car'])) === 'électrique'): ?>
                    <div class="flex items-center space-x-2">
                        <img src="/asset/image/energy_green.webp" alt="Voiture électrique" class="w-12 h-12">
                        <span class="text-black text-sm font-medium">Véhicule électrique</span>
                    </div>
                <?php endif; ?>
            </div>


            <!-- Card Footer -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-black">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                    <?php if ($trip['nb_place'] < 1): ?>
                        <span class="font-semibold text-red-600"> Complet </span>
                    <?php else: ?>
                        <span class="font-semibold text-black"><?= htmlspecialchars($trip['nb_place']) ?> place(s) restante(s)</span>
                    <?php endif; ?>
                </div>
                <button class="bg-navy text-black px-4 py-2 rounded-lg font-medium transition-all duration-200 transform hover:scale-105">
                    <a href="<?= BASE_URL ?>tripDetails?id=<?= $trip['id_carpooling'] ?>">Voir le détail</a>


                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>