<?php

use App\Repository\CarpoolingRepository;

$carpoolingRepository = new CarpoolingRepository($pdo);

$passagers = [];
$passagers = $carpoolingRepository->getPassengersByTripId($oldTrip['id_carpooling']);

$modalId = 'modal-discussion-' . $oldTrip['id_carpooling'];
$btnId = 'btn-review-' . $oldTrip['id_carpooling'];
$closeId = 'close-modal-' . $oldTrip['id_carpooling'];
$formId = 'form-message-' . $oldTrip['id_carpooling'];
?>

<div class="trip-item">
    <div class="trip-header">
        <div class="trip-route"><?= htmlspecialchars($oldTrip['departure_city']) ?> <i class="fa-solid fa-arrow-right"></i> <?= htmlspecialchars($oldTrip['arrival_city']) ?></div>
    </div>
    <div class="trip-details">
        <div class="detail-item">
            <svg class="detail-icon" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8z" />
            </svg>
            <span><?= htmlspecialchars($oldTrip['departure_date']) ?></span>
        </div>
        <div class="detail-item">
            <svg class="detail-icon" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
            <span><?= htmlspecialchars($oldTrip['nb_passagers']) ?> passager(s)</span>
        </div>
        <div class="detail-item">
            <svg class="detail-icon" viewBox="0 0 24 24">
                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
            </svg>
            <span><?= htmlspecialchars($oldTrip['price_place']) ?> <i class="fa-brands fa-pagelines"></i></span>
        </div>
        <div class="detail-item">
            <svg class="detail-icon" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            <span>Conducteur: <?= htmlspecialchars($oldTrip['conducteur']) ?></span>
        </div>
    </div>


    <div class="trip-actions">
        <?php if (count($passagers) > 0 && $id_user != $driver_id):  ?>
            <button class="action-btn review-btn text-black" id="<?= $btnId ?>">
                <i class="fa-solid fa-pencil"></i></i>
                Laisser un avis
            </button>
        <?php endif; ?>
        <button class="action-btn help-btn text-black">
            <i class="fa-solid fa-circle-info"></i>
            Contacter Ecoride
        </button>
    </div>
</div>

<!-- Modal avis -->
<div id="<?= $modalId ?>" class="modal-review" style="display:none;">
    <div class="modal-content gap-5">
        <span class="close text-black" id="<?= $closeId ?>">&times;</span>
        <h3 class="text-black text-center mb-4">Laisser un avis</h3>
        <form id="<?= $formId ?>">
            <div class="mb-4">
                <label for="recipient" class="text-black">Destinataire :</label>
                <select id="recipient" name="recipient">
                    <option value="<?= htmlspecialchars($oldTrip['conducteur']) ?>">
                        <?= htmlspecialchars($oldTrip['conducteur']) ?> (Conducteur)
                    </option>
                    <?php foreach ($passagers as $passager): ?>
                        <option value="<?= htmlspecialchars($passager['name_user'] . ' ' . $passager['lastname_user']) ?>">
                            <?= htmlspecialchars($passager['name_user'] . ' ' . $passager['lastname_user']) ?> (Passager)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4 relative">
                <label for="rating" class="text-lg text-black">Votre note :</label>
                <div class="rating w-full text-black" id="rating">
                    <input type="radio" name="rating-4" value="1" class="mask mask-star-2 bg-green-500" aria-label="1 star" />
                    <input type="radio" name="rating-4" value="2" class="mask mask-star-2 bg-green-500" aria-label="2 star" />
                    <input type="radio" name="rating-4" value="3" class="mask mask-star-2 bg-green-500" aria-label="3 star" />
                    <input type="radio" name="rating-4" value="4" class="mask mask-star-2 bg-green-500" aria-label="4 star" />
                    <input type="radio" name="rating-4" value="5" class="mask mask-star-2 bg-green-500" aria-label="5 star" />
                </div>
            </div>
            <div class="mb-4">
                <label for="message" class="text-black">Votre message :</label>
                <textarea id="comment-review" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">Envoyer</button>
        </form>
    </div>
</div>