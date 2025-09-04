<div class="section-content">
    <div class="review-item">
        <div class="review-header">
            <div class="review-user"><?= htmlspecialchars($reviewGiven['recipient_name']) ?></div>
            <div class="review-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($i <= $reviewGiven['note_reviews']): ?>
                        <i class="fa-solid fa-star text-yellow-500"></i> <!-- étoile remplie -->
                    <?php else: ?>
                        <i class="fa-regular fa-star text-yellow-500"></i> <!-- étoile vide -->
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
        <div class="review-text"><?= htmlspecialchars($reviewGiven['comment_reviews']) ?></div>
        <div class="review-date">Trajet <?= htmlspecialchars($reviewGiven['departure_city']) ?> → <?= htmlspecialchars($reviewGiven['arrival_city']) ?> - <?= htmlspecialchars($reviewGiven['departure_date']) ?></div>
    </div>
</div>