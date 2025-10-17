<?php require_once ROOTPATH . '/src/Templates/header.php';  ?>


<!-- Hero Section améliorée -->
<section class="relative text-center mb-16 py-12 overflow-hidden">
    <!-- Background décoratif -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-green-50/20 to-transparent"></div>
    <div class="absolute top-10 left-10 w-32 h-32 bg-green-200 rounded-full opacity-20 blur-xl"></div>
    <div class="absolute bottom-10 right-10 w-24 h-24 bg-blue-200 rounded-full opacity-20 blur-xl"></div>

    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-navy mb-6 leading-tight">
            Trouvez votre trajet
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600 animate-pulse">
                dès maintenant !
            </span>
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed mb-8">
            🌱 Voyagez malin, économique et écologique avec notre plateforme de covoiturage
        </p>
    </div>
</section>

<!-- SearchBar modernisée -->
<section class="relative mb-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Titre de section -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-navy mb-2">
                    🔍 Rechercher un trajet
                </h2>
                <p class="text-gray-300">
                    Trouvez le trajet parfait en quelques clics
                </p>
            </div>

            <!-- Formulaire amélioré -->
            <div class="relative bg-white rounded-3xl p-6 sm:p-8 border-2 border-gray-100 shadow-2xl backdrop-blur-sm">
                <!-- Décoration -->
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <form id="formSearch" method="post" action="<?= BASE_URL ?>Carpoolings" class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        <!-- Départ -->
                        <div class="relative group">
                            <label for="departure_city_search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                Ville de départ
                            </label>
                            <div class="relative">
                                <input type="text"
                                    id="departure_city_search"
                                    name="departureCitySearch"
                                    placeholder="Ex: Paris, Lyon..."
                                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl px-4 py-4 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:bg-white focus:ring-4 focus:ring-green-100 outline-none transition-all duration-300 group-hover:border-green-300">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Arrivée -->
                        <div class="relative group">
                            <label for="arrival_city_search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <div class="w-3 h-3 bg-orange-300 rounded-full"></div>
                                Ville d'arrivée
                            </label>
                            <div class="relative">
                                <input type="text"
                                    id="arrival_city_search"
                                    name="arrivalCitySearch"
                                    placeholder="Ex: Marseille, Bordeaux..."
                                    class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl px-4 py-4 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:bg-white focus:ring-4 focus:ring-green-100 outline-none transition-all duration-300 group-hover:border-green-300">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="relative group">
                            <label for="date_search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Date de départ
                            </label>
                            <input type="date"
                                id="date_search"
                                name="dateSearch"
                                min="<?= date('Y-m-d') ?>"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl px-4 py-4 text-gray-900 focus:border-green-500 focus:bg-white focus:ring-4 focus:ring-green-100 outline-none transition-all duration-300 group-hover:border-green-300">
                        </div>

                        <!-- Bouton -->
                        <div class="flex items-end">
                            <button type="submit"
                                id="btn_search"
                                class="w-full group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl focus:ring-4 focus:ring-green-200 outline-none">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                    Rechercher
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <div id="feedback-search" class="mt-6"></div>
            </div>
        </div>
    </div>
</section>

<!-- Résultats -->
<section class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="max-w-screen-2xl mx-auto">

        <!-- Trajets exacts -->
        <?php if (!empty($tripsData['exactTrips'])): ?>
            <div class="mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-navy mb-2">
                    🚗 Trajets
                </h2>
                <p class="text-gray-300 mb-6">
                    <?= count($tripsData['exactTrips']) ?> trajet<?= count($tripsData['exactTrips']) > 1 ? 's' : '' ?> trouvé<?= count($tripsData['exactTrips']) > 1 ? 's' : '' ?> au départ de <?= $departure ?>, arrivée <?= $arrival ?>
                </p>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php foreach ($tripsData['exactTrips'] as $trip): ?>
                        <?php include ROOTPATH . 'src/Templates/trip_item.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Trajets alternatifs -->
        <?php if (empty($tripsData['exactTrips']) && !empty($tripsData['alternativeTrips'])): ?>
            <div class="mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-navy mb-2">
                    📅 Aucun trajet ce jour-là, mais voici d’autres dates proches
                </h2>
                <p class="text-gray-300 mb-6">
                    <?= count($tripsData['alternativeTrips']) ?> trajet<?= count($tripsData['alternativeTrips']) > 1 ? 's' : '' ?> proposé<?= count($tripsData['alternativeTrips']) > 1 ? 's' : '' ?>
                </p>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php foreach ($tripsData['alternativeTrips'] as $trip): ?>
                        <?php include ROOTPATH . 'src/Templates/trip_item.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Aucun résultat -->
        <?php if (empty($tripsData['exactTrips']) && empty($tripsData['alternativeTrips'])): ?>
            <section class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
                <div class="max-w-2xl mx-auto text-center">
                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-3xl p-12 border-2 border-dashed border-gray-200">
                        <!-- Illustration -->
                        <div class="mb-8">
                            <img src="../asset/image/noresult.jpg"
                                alt="Aucun résultat trouvé"
                                class="w-64 h-64 mx-auto rounded-2xl shadow-lg object-cover">
                        </div>

                        <!-- Contenu -->
                        <div class="space-y-6">
                            <h3 class="text-2xl font-bold text-gray-600 mb-2">🔍 Aucun trajet trouvé</h3>
                            <p class="text-gray-600 text-lg">Aucun eco'Driver n'a proposé ce trajet pour le moment</p>

                            <!-- Suggestions -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                                <h4 class="font-bold text-gray-900 mb-4">💡 Suggestions :</h4>
                                <ul class="text-left space-y-2 text-gray-600">
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Essayez des villes voisines
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Modifiez votre date de départ
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Créez une alerte pour ce trajet
                                    </li>
                                </ul>
                            </div>

                            <!-- CTA -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button class="bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-3 px-6 rounded-2xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                    🔔 Créer une alerte
                                </button>
                                <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold py-3 px-6 rounded-2xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                                    📝 Proposer ce trajet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</section>


<script src="/asset/js/resultSearch.js"></script>
<script src="/asset/js/searchForm.js"></script>

<?php require_once ROOTPATH . '/src/Templates/footer.php'; ?>