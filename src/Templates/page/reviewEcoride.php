<?php
require_once ROOTPATH . '/src/Templates/header.php';

?>
<section class="mx-auto w-200 review-ecoride flex">
    <form id="reviewForm" class="flex flex-col w-full gap-8">
        <div class="p-2">
            <div class="relative">
                <label for="firstname" class="text-lg text-white">Votre prénom</label>
                <input type="text" id="name-review-ecoride" name="nameReviewEcoride" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
        </div>
        <div class="p-2">
            <div class="relative">
                <label for="email" class="text-lg text-white">Votre email</label>
                <input type="email" id="email-review-ecoride" name="emailReviewEcoride" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
        </div>
        <div class="p-2">
            <div class="relative">
                <label for="rating" class="text-lg text-white">Votre note :</label>
                <div class="rating w-full" id="rating-ecoride">
                    <input type="radio" name="rating-4" value="1" class="mask mask-star-2 bg-green-500" aria-label="1 star" />
                    <input type="radio" name="rating-4" value="2" class="mask mask-star-2 bg-green-500" aria-label="2 star" />
                    <input type="radio" name="rating-4" value="3" class="mask mask-star-2 bg-green-500" aria-label="3 star" />
                    <input type="radio" name="rating-4" value="4" class="mask mask-star-2 bg-green-500" aria-label="4 star" />
                    <input type="radio" name="rating-4" value="5" class="mask mask-star-2 bg-green-500" aria-label="5 star" />
                </div>
            </div>
        </div>
        <div class="p-2">
            <div class="relative"></div>
            <label for="text-review-ecoride" class="text-lg text-white">Votre avis :</label>
            <textarea id="text-review-ecoride" name="comment" placeholder="Votre avis..." class="w-full"></textarea>
        </div>
        </div>
        <div class="p-2 w-full">
            <button id="btn-review-ecoride" class="flex mx-auto text-white border-0 py-2 px-8 focus:outline-none rounded text-lg btn-send">Envoyer</button>
        </div>
    </form>
</section>
<div id="feedback-review-ecoride"></div>



<?php
$page_script = '/asset/js/reviewEcoride.js';
require_once ROOTPATH . '/src/Templates/footer.php'; ?>