<?php

require_once ROOTPATH . '/src/Templates/header.php';

?>

<section class="new-carpooling ">
    <div class="header">
        <div class="text-white mb-15 mt-10 text-center sm:text-xl md:text-3xl">Proposez votre trajet</div>
    </div>

    <form id="tripForm" class="max-w-6xl mx-auto" method="POST">
        <!-- Départ -->
        <div class="form-section rounded-lg">
            <div class="section-title text-black">
                <div class="section-icon">📍</div>
                Départ
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label class="label-add-carpooling" for="departure-city">Lieu de départ</label>
                    <input type="text" id="departure-city" name="departure_city" placeholder="Ex: Paris, 75001">
                </div>
                <div class="form-group">
                    <label class="label-add-carpooling" for="departure-date">Date de départ</label>
                    <input type="date" id="departure-date" name="departure_date">
                </div>
                <div class="form-group">
                    <label class="label-add-carpooling" for="departure-hour">Heure de départ</label>
                    <input type="time" id="departure-hour" name="departure_hour">
                </div>
            </div>
        </div>

        <!-- Arrivée -->
        <div class="form-section rounded-lg">
            <div class="section-title text-black">
                <div class="section-icon">🎯</div>
                Arrivée
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label class="label-add-carpooling" for="arrival-city">Lieu d'arrivée</label>
                    <input type="text" id="arrival-city" name="arrival-city" placeholder="Ex: Lyon" class="text-black">
                </div>
                <div class="form-group">
                    <label class="label-add-carpooling" for="arrival-date">Date d'arrivée estimée</label>
                    <input type="date" id="arrival-date" name="arrival_date">
                </div>
                <div class="form-group">
                    <label class="label-add-carpooling" for="arrival-hour">Heure d'arrivée estimée</label>
                    <input type="time" id="arrival-hour" name="arrival_hour">
                </div>
            </div>
        </div>

        <!-- Détails -->
        <div class="form-section rounded-lg">
            <div class="section-title text-black">
                <div class="section-icon">⚙️</div> <!--a chganger par icon svg-->
                Détails
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="label-add-carpooling">Nombre de places disponibles</label>
                    <input type="hidden" id="selected-seats" name="nb_place" value="">
                    <div class="seats-selector" id="seat-selector">
                        <div class="seat-option" data-seats="1">1</div>
                        <div class="seat-option" data-seats="2">2</div>
                        <div class="seat-option" data-seats="3">3</div>
                        <div class="seat-option" data-seats="4">4</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-add-carpooling" for="price-place">Prix par personne</label>
                    <div class="price-input">
                        <input type="number" id="price-place" name="price_place" placeholder="Nombre d'EcoCrédit" min="2" step="1">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="label-add-carpooling" for="description">Description du trajet (optionnel)</label>
                <textarea id="description" rows="3" placeholder="Informations supplémentaires, conditions particulières..."></textarea>
            </div>
        </div>

        <div id="feedback-add-carpooling">

        </div>
        <div role="alert" id="alert-success" class="hidden text-center">
            Votre nouveau trajet a bien été pris en compte
        </div>



        <button class="submit-btn" id="btn-submit-trip">
            Publier mon trajet
        </button>
    </form>


</section>

<?php
$page_script = '/asset/js/newCarpooling.js';
require_once ROOTPATH . '/src/Templates/footer.php';
?>