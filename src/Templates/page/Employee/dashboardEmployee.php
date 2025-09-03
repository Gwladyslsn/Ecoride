<?php
require_once ROOTPATH . '/src/Templates/header.php';

if (!isset($_SESSION['admin']) && !isset($_SESSION['employee'])) {
    header('Location: /register');
    exit;
}

?>

<!-- Header -->
<div class="bg-darkblue text-white p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-2">Dashboard Employé</h1>
        <p class="text-blue-200">Gestion des avis clients - EcoRide</p>
    </div>
</div>

<div class="max-w-7xl mx-auto p-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avis en attente</p>
                    <p class="text-2xl font-bold text-black" id="pending-count"><?= $nbTripsPending ?></p>
                </div>
                <div class="p-3 rounded-full bg-orange-light">
                    <svg class="w-6 h-6 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avis traités</p>
                    <p class="text-2xl font-bold text-green" id="processed-count"></p>
                </div>
                <div class="p-3 rounded-full bg-green-light">
                    <svg class="w-6 h-6 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Note moyenne</p>
                    <p class="text-2xl font-bold text-black"><?= $noteAverage ?>/5</p>
                </div>
                <div class="p-3 rounded-full bg-lightblue-light">
                    <svg class="w-6 h-6 text-lightblue" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total avis</p>
                    <p class="text-2xl font-bold text-black"><?= count($reviews) ?></p>
                </div>
                <div class="p-3 rounded-full bg-darkblue-light">
                    <svg class="w-6 h-6 text-darkblue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Avis en attente -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4 text-darkblue">
            Avis en attente de traitement (<span id="pending-title-count"><?= $nbTripsPending ?></span>)
        </h2>
        <div class="grid gap-6">
            <? foreach ($reviews  as $review): ?>
                <div id="pending-reviews">
                    <div class="review-card bg-white rounded-xl p-6 shadow-sm border" data-review-id="1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h3 class="font-semibold text-lg text-black">Avis de <?= $review['author_name'] ?></h3>
                                    <h4 class="text-black">Pour <?= $review['recipient_name'] ?></h4>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>avis du <?= $review['date_reviews'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En attente</span>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="flex" data-rating="4">
                                    <div class="review-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review['note_reviews']): ?>
                                                <i class="fa-solid fa-star text-yellow-500"></i> <!-- étoile remplie -->
                                            <?php else: ?>
                                                <i class="fa-regular fa-star text-yellow-500"></i> <!-- étoile vide -->
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-700"><?= $review['note_reviews'] ?>/5</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?= $review['departure_city'] ?> -</span> - <?= $review['arrival_city'] ?> </span>
                                <span>, Le <?= $review['departure_date'] ?></span>
                            </div>
                            <p class="text-gray-800 leading-relaxed"><?= $review['comment_reviews'] ?></p>
                        </div>

                        <div class="flex space-x-3 pt-4 border-t">
                            <button class="btn-transition flex items-center space-x-2 px-4 py-2 bg-green text-white rounded-lg font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="accept-review-btn"
                                    data-review-id="<?= $review['id_reviews'] ?>">Accepter</span>
                            </button> 

                            <button class="btn-transition flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <a href="" id="btn-reject-review">Refuser</a>
                            </button>

                            <button class="btn-transition flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <a href="" id="btn-contact-review">Contacter</a>
                            </button>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>

    <!-- Avis traités -->
    <div>
        <h2 class="text-xl font-semibold mb-4 text-darkblue">
            Avis récemment traités (<span id="processed-title-count">1</span>)
        </h2>
        <div class="grid gap-4" id="processed-reviews">
            <!-- Les avis traités seront injectés ici via PHP/JS -->
            <div class="review-card bg-white rounded-xl p-6 shadow-sm border opacity-75" data-review-id="4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-lightblue flex items-center justify-center text-white font-semibold">
                            AL
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Antoine Leroy</h3>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>2025-08-31</span>
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Accepté</span>
                </div>

                <div class="mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="flex">
                            <svg class="w-4 h-4 star-filled" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg class="w-4 h-4 star-filled" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg class="w-4 h-4 star-filled" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg class="w-4 h-4 star-filled" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg class="w-4 h-4 star-filled" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">5/5</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Toulouse - Capitole</span>
                    </div>
                    <p class="text-gray-800 leading-relaxed">Parfait ! Chauffeur très professionnel, véhicule écologique comme promis. Application facile à utiliser.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/asset/js/dashboardEmployee.js"></script>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>