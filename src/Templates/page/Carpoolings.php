<?php

require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\CarpoolingRepository;


?>

<!--SearchBar-->
<section class="body-font">
    <div class="container px-5 py-12 mx-auto">
        <div class="flex flex-col text-center w-full mb-8">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2">Trouvez votre trajet dès maintenant !</h1>
        </div>
        <form id="formSearch" method="post" action="<?= BASE_URL ?>Carpoolings" class="flex lg:w-1/1 w-full sm:flex-row flex-col mx-auto px-8 sm:space-x-4 sm:space-y-0 space-y-4 sm:px-0 items-end">
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
            <button type="submit" id="btn_search" class="border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg btn-search">
                <a>Rechercher</a>
            </button>
        </form>
        <div id="feedback-search" class="mt-5"></div>
    </div>
</section>

<section class="default-trip container-trip">
    <?php foreach ($trips as $trip): ?>
        <?php include ROOTPATH . 'src/Templates/trip_item.php'; ?>
    <?php endforeach; ?>
</section>

<section>
    <?php
        if (!$trips){?>
            <div id="results" class="text-center mb-5 text-lg">Aucun eco'Driver n'a proposé ce trajet pour le moment</div>
            <img src="../asset/image/noresult.jpg" alt="logo recherche trajet" class="w-400 rounded-lg mx-auto">
        <?php }?>
</section>




<script src="/asset/js/resultSearch.js"></script>
<script src="/asset/js/searchForm.js"></script>


<?php
require_once ROOTPATH . '/src/Templates/footer.php';
?>
