<?php
require_once ROOTPATH . '/src/Templates/header.php'; ?>

<section class="content-section">
    <div class="container-about">
        <h2 class="section-title">Notre Vision</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🛣</div>
                <h3 class="value-title">Trajets du Quotidien</h3>
                <p class="value-description">Des trajets essentiellement locaux et régionaux, pour réduire les émissions liées aux déplacements quotidiens et créer du lien social.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🚗</div>
                <h3 class="value-title">Véhicules Propres</h3>
                <p class="value-description">Mise en avant des véhicules électriques et hybrides pour encourager une mobilité plus respectueuse de l'environnement.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">👋</div>
                <h3 class="value-title">Connexions Humaines</h3>
                <p class="value-description">Une communauté qui partage bien plus que des kilomètres : des valeurs communes et des échanges locaux solidaires.</p>
            </div>
        </div>
    </div>
</section>

<section class="mission-section">
    <div class="container-about">
        <h2 class="section-title">Notre Histoire</h2>
        <div class="mission-content">
            <div>
                <p class="mission-text">
                    <strong>EcoRide</strong>, c'est bien plus qu'un site de mise en relation. C'est une initiative née d'une idée simple :
                    <em>"Je voyais tous ces trajets à vide dans ma région. Des routes pleines de voitures… mais vides de bon sens."</em>
                </p>
                <p class="mission-text" style="margin-top: 20px;">
                    Parce que la voiture n'est pas toujours évitable, mais elle peut être repensée. Parce que le changement ne viendra pas d'en haut,
                    mais de chacun de nous. <strong>EcoRide est né de cette idée brute : faire mieux, avec moins.</strong>
                </p>
            </div>
            <div class="mission-stats">
                <div class="stat-item">
                    <div class="stat-number">🛣</div>
                    <div class="stat-label">Moins de voitures</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">🌍</div>
                    <div class="stat-label">Moins de CO₂</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">👋</div>
                    <div class="stat-label">Plus de rencontres</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">💡</div>
                    <div class="stat-label">Plus de logique</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="commitment-section">
    <div class="container-about">
        <h2 class="section-title" style="color: var(--text-white);">EcoRide Concrètement</h2>
        <div class="commitment-grid">
            <div class="commitment-item">
                <div class="commitment-icon">🌱</div>
                <h3 class="commitment-title">Covoiturage Éco-Responsable</h3>
                <p>Une plateforme qui privilégie les véhicules propres, les trajets courts, et les connexions humaines authentiques.</p>
            </div>
            <div class="commitment-item">
                <div class="commitment-icon">🗺️</div>
                <h3 class="commitment-title">Trajets Locaux</h3>
                <p>Focus sur les déplacements régionaux et quotidiens pour créer un impact réel sur votre territoire.</p>
            </div>
            <div class="commitment-item">
                <div class="commitment-icon">⚡</div>
                <h3 class="commitment-title">Véhicules Électriques</h3>
                <p>Mise en avant et encouragement de l'utilisation de véhicules électriques ou hybrides.</p>
            </div>
            <div class="commitment-item">
                <div class="commitment-icon">💚</div>
                <h3 class="commitment-title">Communauté de Valeurs</h3>
                <p>Plus qu'un simple transport, une communauté qui partage des valeurs communes et des échanges solidaires.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container-about">
        <h2 style="margin-bottom: 20px;">Et Demain ?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 15px;">José ne veut pas faire d'EcoRide un géant impersonnel.</p>
        <p style="font-size: 1.1rem; margin-bottom: 30px;">Il veut que cela reste un outil proche des gens, ancré dans les territoires, et utile à la transition écologique.</p>
        <p style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">Parce que chaque trajet compte. Parce qu'on peut changer les choses… un covoit' à la fois.</p>
        <button class="cta-button">
        <a href="<?= BASE_URL ?>?controller=page&action=register">Rejoindre la Communauté EcoRide</a>
        </button>
    </div>
</section>

<?php
$page_script = '/asset/js/about.js';
require_once ROOTPATH . '/src/Templates/footer.php'; ?>