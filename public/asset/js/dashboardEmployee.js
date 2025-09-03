document.addEventListener('DOMContentLoaded', () => {
    const btnCheckReview = document.querySelector('.accept-review-btn');
    const btnRejectReview = document.querySelector('.reject-review-btn');
    const btnContactReview = document.getElementById('btn-contact-review');

    btnCheckReview.addEventListener('click', (e) => {
        e.preventDefault();
        const reviewId = btnCheckReview.dataset.reviewId;
        //console.log('Review ID to accept:', reviewId);
        const text = btnCheckReview.querySelector('.btn-text');
        const loaderOverlay = document.getElementById('loader-overlay');

        loaderOverlay.style.display = 'flex';

        fetch('/acceptReview', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_reviews: reviewId })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('Erreur : ' + response.message);
                loaderOverlay.style.display = 'none';
            }
        })
        .catch(err => {
            console.error(err);
            loaderOverlay.style.display = 'none';
        });
    });

    btnRejectReview.addEventListener('click', (e) => {
        e.preventDefault();
        const reviewId = btnRejectReview.dataset.reviewId;
        const loaderOverlay = document.getElementById('loader-overlay');

        loaderOverlay.style.display = 'flex';

        fetch('/rejectReview', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_reviews: reviewId })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('Erreur : ' + response.message);
                loaderOverlay.style.display = 'none';
            }
        })
        .catch(err => {
            console.error(err);
            loaderOverlay.style.display = 'none';
        });
    });
});
