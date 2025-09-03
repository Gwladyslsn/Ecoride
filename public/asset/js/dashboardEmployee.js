document.addEventListener('DOMContentLoaded', () => {
    const btnCheckReview = document.querySelector('.accept-review-btn');
    const btnRejectReview = document.getElementById('btn-reject-review');
    const btnContactReview = document.getElementById('btn-contact-review');

    btnCheckReview.addEventListener('click', (e) => {
        e.preventDefault();
        const reviewId = btnCheckReview.dataset.reviewId;
        console.log('Review ID to accept:', reviewId);
        


        fetch('/acceptReview', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_reviews: reviewId })
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    btnCheckReview.closest('.review-row').querySelector('.status').textContent = 'accept';
                    window.location.reload();
                } else {
                    alert('Erreur : ' + response.message);
                }
            })
            .catch(err => console.error(err));
    });

});