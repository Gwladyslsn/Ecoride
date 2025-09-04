<div class="section-content">
    <div class="review-item">
        <div class="review-header">
            <div class="review-user"><?= htmlspecialchars($reviewReceived['author_name']) ?></div>
            <div class="review-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($i <= $reviewReceived['note_reviews']): ?>
                        <i class="fa-solid fa-star text-yellow-500"></i> <!-- étoile remplie -->
                    <?php else: ?>
                        <i class="fa-regular fa-star text-yellow-500"></i> <!-- étoile vide -->
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
        <div class="review-text"><?= htmlspecialchars($reviewReceived['comment_reviews']) ?>
        </div>
        <div class="review-date">Trajet <?= htmlspecialchars($reviewReceived['departure_city']) ?> → <?= htmlspecialchars($reviewReceived['arrival_city']) ?> - <?= htmlspecialchars($reviewReceived['departure_date']) ?></div>
    </div>
</div>