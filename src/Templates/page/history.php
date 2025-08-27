<?php
require_once ROOTPATH . '/src/Templates/header.php'; 
$nextTrips = $nextTrips ?? [];
$oldTrips = $oldTrips ?? [];


?>

<body>
    <div class="container">
        <h1 class="page-title">Mon Historique</h1>

        <!-- Trajets à venir -->
        <section class="section upcoming-trips">
            <div class="section-header">
                <svg class="detail-icon" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 21c-4.96 0-9-4.04-9-9s4.04-9 9-9 9 4.04 9 9-4.04 9-9 9z" />
                </svg>
                Trajets à venir
            </div>
            <div class="section-content">
                <?php if (empty($nextTrips)): ?>
                    <p class="text-black">Aucun trajet à venir.</p>
                <?php else: ?>
                <?php foreach ($nextTrips as $nextTrip): ?>
                <?php include ROOTPATH . 'src/Templates/next_trip_item.php'; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Trajets passés -->
        <section class="section past-trips">
            <div class="section-header">
                <svg class="detail-icon" viewBox="0 0 24 24">
                    <path d="M9 11H7v6h2v-6zm4 0h-2v6h2v-6zm4 0h-2v6h2v-6zm2.5-5H18V4c0-.55-.45-1-1-1s-1 .45-1 1v2H8V4c0-.55-.45-1-1-1s-1 .45-1 1v2H4.5C3.67 6 3 6.67 3 7.5v11C3 19.33 3.67 20 4.5 20h15c.83 0 1.5-.67 1.5-1.5v-11C21 6.67 20.33 6 19.5 6z" />
                </svg>
                Trajets passés
            </div>
            <div class="section-content">
                <?php if (empty($oldTrips)): ?>
                    <p class="text-black">Aucun trajet passé.</p>
                <?php else: ?>
                <?php foreach ($oldTrips as $oldTrip): ?>
                <?php include ROOTPATH . 'src/Templates/old_trip_item.php'; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Avis donnés -->
        <section class="section reviews-given">
            <div class="section-header">
                <svg class="detail-icon" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                Avis donnés
            </div>
            <div class="section-content">
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">Marie D.</div>
                        <div class="review-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <div class="review-text">
                        "Excellente conductrice ! Très ponctuelle et conduite souple. Conversation agréable pendant le trajet. Je recommande vivement."
                    </div>
                    <div class="review-date">Trajet Paris → Lyon - 15 Mars 2025</div>
                </div>

                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">Sophie M.</div>
                        <div class="review-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">☆</span>
                        </div>
                    </div>
                    <div class="review-text">
                        "Bon trajet dans l'ensemble. Quelques minutes de retard au départ mais elle a prévenu. Véhicule propre et conduite sécurisée."
                    </div>
                    <div class="review-date">Trajet Nantes → Rennes - 28 Février 2025</div>
                </div>
            </div>
        </section>

        <!-- Avis reçus -->
        <section class="section reviews-received">
            <div class="section-header">
                <svg class="detail-icon" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                Avis reçus
            </div>
            <div class="section-content">
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">Thomas K.</div>
                        <div class="review-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <div class="review-text">
                        "Passager très sympa et respectueux. À l'heure au point de rendez-vous et bonne compagnie pour le trajet. Je le recommande !"
                    </div>
                    <div class="review-date">Trajet Toulouse → Bordeaux - 5 Mars 2025</div>
                </div>

                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">Lisa R.</div>
                        <div class="review-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <div class="review-text">
                        "Conducteur fiable et sérieux. Trajet agréable, véhicule en bon état. Communication claire avant le départ. Parfait !"
                    </div>
                    <div class="review-date">Trajet Toulouse → Bordeaux - 5 Mars 2025</div>
                </div>
            </div>
        </section>
    </div>
    <div class="text-center mt-8">
        <button class="px-6 py-3 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition-colors shadow-md">
            <a href="<?= BASE_URL ?>Carpoolings">Rechercher un trajet</a>
        </button>
    </div>

    <script src="/asset/js/history.js"></script>

    <?php
    require_once ROOTPATH . '/src/Templates/footer.php';?>