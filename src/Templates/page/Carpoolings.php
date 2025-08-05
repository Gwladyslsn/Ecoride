<?php

require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\CarpoolingRepository;


?>


    <section class="text-center mb-12">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-navy mb-4">
            Trouvez votre trajet
            <span class="text-green-300">dès maintenant !</span>
        </h1>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto">
            Voyagez malin, économique et écologique avec notre plateforme de covoiturage
        </p>
    </section>

    <!--SearchBar-->
    <section class="body-font">
        <div class="container px-5 py-12 mx-auto">

            <div class=" rounded-2xl card-shadow p-6 sm:p-8 border border-gray-100">
                <form id="formSearch" method="post" action="<?= BASE_URL ?>Carpoolings" class="flex flex-col lg:flex-row gap-4 lg:gap-6">
                    <div class="relative flex-grow w-full">
                        <label for="departureCity" class="leading-7 text-lg">Ville de départ</label>
                        <input type="text" id="departure_city_search" name="departureCitySearch" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-black py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative flex-grow w-full">
                        <label for="arrivalCity" class="leading-7 text-lg">Ville d'arrivée</label>
                        <input type="text" id="arrival_city_search" name="arrivalCitySearch" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-black py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative flex-grow w-full">
                        <label for="date" class="leading-7 text-lg">date</label>
                        <input type="date" id="date_search" name="dateSearch" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-transparent focus:ring-2 focus:ring-green-200 text-base outline-none text-black py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <button type="submit" id="btn_search" class="border-0 py-2 px-6 rounded-xl text-lg btn-search">
                        Rechercher
                    </button>
                </form>
                <div id="feedback-search" class="mt-5"></div>
            </div>
        </div>
    </section>


<!--Results-->
    <section class="default-trip container-trip mx-auto py-2 px-8 max-w-screen-3xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <?php foreach ($trips as $trip): ?>
                <?php include ROOTPATH . 'src/Templates/trip_item.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <?php
        if (!$trips) { ?>
            <div id="results" class="text-center mb-5 text-lg">Aucun eco'Driver n'a proposé ce trajet pour le moment</div>
            <img src="../asset/image/noresult.jpg" alt="logo recherche trajet" class="w-400 rounded-lg mx-auto">
        <?php } ?>
    </section>




<script src="/asset/js/resultSearch.js"></script>
<script src="/asset/js/searchForm.js"></script>


<?php
require_once ROOTPATH . '/src/Templates/footer.php';
?>