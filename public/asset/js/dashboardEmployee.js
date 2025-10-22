document.addEventListener('DOMContentLoaded', () => {
    const loaderOverlay = document.getElementById('loader-overlay');

    /**
     * Fonction générique pour traiter une action sur un avis
     * @param {string} endpoint - URL de la route (ex: '/acceptReview')
     * @param {string} reviewId - ID de l'avis concerné
     */
    function handleReviewAction(endpoint, reviewId) {
        loaderOverlay.style.display = 'flex';

        fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_reviews: reviewId })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                setTimeout(() => globalThis.location.reload(), 1000);
            } else {
                alert('Erreur : ' + response.message);
                loaderOverlay.style.display = 'none';
            }
        })
        .catch(err => {
            console.error(err);
            loaderOverlay.style.display = 'none';
        });
    }

    // Sélection des boutons
    const btnCheckReview = document.querySelector('.accept-review-btn');
    const btnRejectReview = document.querySelector('.reject-review-btn');

    // Gestionnaires d’événements
    btnCheckReview?.addEventListener('click', (e) => {
        e.preventDefault();
        handleReviewAction('/acceptReview', btnCheckReview.dataset.reviewId);
    });

    btnRejectReview?.addEventListener('click', (e) => {
        e.preventDefault();
        handleReviewAction('/rejectReview', btnRejectReview.dataset.reviewId);
    });
});

