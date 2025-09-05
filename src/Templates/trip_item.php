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
    <div class="trip group relative bg-white rounded-3xl overflow-hidden border-2 border-red-500 shadow-lg">
        <div class="absolute inset-0 bg-red-50 opacity-30"></div>
    <?php else: ?>
        <div class="trip group relative bg-white rounded-3xl overflow-hidden border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02]">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/30 to-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <?php endif; ?>

        <div class="relative z-10 p-4 sm:p-6 lg:p-8">

            <!-- Header avec conducteur et prix -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <!-- Info conducteur -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl shadow-lg overflow-hidden transform group-hover:scale-110 transition-transform duration-300">
                            <img src="<?= $avatarDriver; ?>"
                                alt="icone de profil du conducteur"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-gray-900 text-lg sm:text-xl truncate">
                            <?= htmlspecialchars($trip['name_user']) ?>
                        </h3>
                    </div>
                </div>

                <!-- Prix -->
                <div class="flex items-center gap-2 bg-gradient-to-r from-green-100 to-green-200 px-4 py-2 rounded-2xl border border-green-300">
                    <span class="text-gray-700 font-medium">Prix :</span>
                    <span class="text-xl font-bold text-gray-900"><?= htmlspecialchars($trip['price_place']) ?></span>
                    <i class="fa-brands fa-pagelines text-green-600 text-lg"></i>
                </div>
            </div>

            <!-- Trajet -->
            <div class="space-y-6 mb-8">
                <!-- Départ -->
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center mt-1">
                        <div class="w-4 h-4 bg-green-500 rounded-full shadow-md"></div>
                        <div class="w-0.5 h-12 bg-gradient-to-b from-green-500 to-orange-300"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">
                                    <?= htmlspecialchars($trip['departure_city']) ?>
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Le <?= date('d/m/Y', strtotime($trip['departure_date'])) ?>
                                </p>
                            </div>
                            <div class="bg-blue-100 px-3 py-1 rounded-lg text-blue-800 font-medium text-sm">
                                <?= htmlspecialchars($trip['departure_hour']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arrivée -->
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center mt-1">
                        <div class="w-4 h-4 bg-orange-300 rounded-full shadow-md"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">
                                    <?= htmlspecialchars($trip['arrival_city']) ?>
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Le <?= date('d/m/Y', strtotime($trip['arrival_date'])) ?>
                                </p>
                            </div>
                            <div class="bg-blue-100 px-3 py-1 rounded-lg text-blue-800 font-medium text-sm">
                                <?= htmlspecialchars($trip['arrival_hour']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Badge véhicule électrique -->
                <?php if ($car && strtolower(trim($car['energy_car'])) === 'électrique'): ?>
                    <div class="flex items-center justify-center gap-3 bg-gradient-to-r from-green-100 to-emerald-100 border-2 border-green-300 rounded-2xl p-4 mt-6">
                        <img src="/asset/image/energy_green.webp" alt="Voiture électrique" class="w-10 h-10 sm:w-12 sm:h-12">
                        <div class="text-center">
                            <span class="text-green-800 font-bold text-sm sm:text-base">Véhicule électrique</span>
                            <p class="text-green-700 text-xs">Trajet éco-responsable</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t-2 border-gray-100">
                <!-- Places disponibles -->
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full bg-gray-100 group-hover:bg-blue-100 transition-colors duration-300">
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </div>
                    <?php if ($trip['nb_place'] < 1): ?>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-red-600 text-lg">⚠️ Complet</span>
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                0 place
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900 text-lg">
                                <?= htmlspecialchars($trip['nb_place']) ?> place<?= $trip['nb_place'] > 1 ? 's' : '' ?>
                            </span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                Disponible<?= $trip['nb_place'] > 1 ? 's' : '' ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Bouton -->
                <button class="group/btn relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white px-6 py-3 rounded-2xl font-bold text-sm sm:text-base transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl min-w-fit">
                    <a href="<?= BASE_URL ?>tripDetails?id=<?= $trip['id_carpooling'] ?>" class="flex items-center gap-2 relative z-10">
                        <span>Voir le détail</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                </button>
            </div>
        </div>
        </div>