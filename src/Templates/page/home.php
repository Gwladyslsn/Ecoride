<?php

// Inclusion de l'autoload pour gérer les namespaces et classes
require_once ROOTPATH . 'vendor/autoload.php'; 

require_once ROOTPATH . 'src/Templates/header.php';
require_once ROOTPATH . 'src/Entity/auth.php';

// Utilisation de la classe POO pour récupérer les avis
use Entity\ReviewRepository;

$repo = new ReviewRepository();
$reviews = $repo->getAllReviews();

// Si tu veux garder le carousel avec des groupes de 2, tu peux garder cette ligne
$groupedReviews = array_chunk($reviews, 2);

?>

<div class="hero w-auto min-h-dvh bg-image">
    <div class="hero-overlay"></div>
    <div class="hero-content text-neutral-content text-center">
        <div class="max-w-lg text-home">
            <h1 class="mb-5 text-5xl font-bold">Avec Eco'ride, voyagez proprement</h1>
            <p class="text-xl mt-8">
                Chez Ecoride, on croit qu’il est possible de se déplacer tout en respectant la planète. Notre plateforme de covoiturage met en relation conducteurs et passagers pour partager un trajet, réduire leur empreinte carbone et faire des économies, tout simplement.<br>
                Que vous soyez conducteur avec des places disponibles ou passager à la recherche d’un trajet pratique et économique, Ecoride vous accompagne à chaque étape.<br><br>
                🔍 Recherchez un trajet en quelques clics<br>
                🚗 Réservez votre place grâce à un système de crédits simple et sécurisé<br>
                🤝 Rencontrez des personnes qui partagent vos valeurs<br>
            </p>
            <button class="btn btn-home mt-5">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= BASE_URL ?>?controller=page&action=about">A propos de nous</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>?controller=page&action=register" rel="noopener noreferrer">Nous rejoindre</a>
                <?php endif; ?>
            </button>
        </div>
    </div>
</div>

<!--Galerie ville accessible par Ecoride-->
<section class="body-font">
    <!-- ... ta section Galerie inchangée ... -->
</section>

<!--SearchBar-->
<section class="body-font">
    <!-- ... ta section formulaire inchangée ... -->
</section>

<!--Avis sur ecoride-->
<section class="text-gray-600">
    <h1 class="text-white text-3xl text-center mt-24 mb-10">Les avis des utilisateurs </h1>
    <div class="relative w-full max-w-6xl mx-auto">
        <div id="carousel-reviews" class="overflow-hidden relative w-full">
            <div id="carousel-inner" class="flex transition-transform duration-500 ease-in-out">
                <?php foreach ($groupedReviews as $group): ?>
                    <div class="w-full flex-shrink-0 flex gap-6 px-4">
                        <?php foreach ($group as $review): ?>
                            <div class="w-full md:w-1/2">
                                <?php 
                                // Adapter le chemin si besoin, ici en relatif à ROOTPATH
                                include ROOTPATH . 'src/Templates/review_item.php'; 
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Flèches -->
        <button id="prevReview" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white text-gray-800 px-3 py-2 rounded-full shadow-md hover:bg-gray-100 z-10">‹</button>
        <button id="nextReview" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white text-gray-800 px-3 py-2 rounded-full shadow-md hover:bg-gray-100 z-10">›</button>
    </div>
</section>

<script src="/asset/js/searchForm.js"></script>
<script src="/asset/js/home.js"></script>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; 
?>
