document.addEventListener('DOMContentLoaded', function () {

    // --- CONTACT UTILISATEUR ---
    document.querySelectorAll('[id^="btn-contact-user-"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.id.replace('btn-contact-user-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'flex';
        });
    });

    document.querySelectorAll('[id^="close-modal-"]').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const id = closeBtn.id.replace('close-modal-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
        });
    });

    document.querySelectorAll('[id^="modal-discussion-"]').forEach(modal => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) modal.style.display = 'none';
        });
    });

    // --- AVIS TRAJET ---
    document.querySelectorAll('[id^="btn-review-"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.id.replace('btn-review-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'flex';
        });
    });

    document.querySelectorAll('form[id^="form-review-"]').forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const id = form.id.replace('form-review-', '');

            // --- Récupération des champs ---
            const recipientId = form.querySelector('select[name="id_recipient"]').value; // ID numérique
            const rating = form.querySelector('input[name="note_reviews"]:checked')?.value;
            const comment = form.querySelector('textarea[name="comment_reviews"]').value;
            const idCarpooling = form.dataset.carpooling; // via dataset

            console.log('Form ID:', form.id);
            console.log('Selected recipient:', recipientId);

            if (!recipientId || !rating || !idCarpooling) {
                alert('Veuillez remplir tous les champs.');
                return;
            }

            const data = {
                id_recipient: parseInt(recipientId),
                note_reviews: parseInt(rating),
                comment_reviews: comment,
                id_carpooling: parseInt(idCarpooling),
                id_user: null
            };
            console.log(data);
            

            try {
                const res = await fetch('/addReview', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const response = await res.json();

                if (response.status === 'ok') {
                    const alertSuccess = document.getElementById('alert-success');
                    if (alertSuccess) alertSuccess.classList.remove('hidden');
                    setTimeout(() => window.location.reload(), 10000);
                } else {
                    alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                }

            } catch (error) {
                console.error('Fetch error:', error);
                alert('Erreur réseau ou serveur : ' + error.message);
            }

            // Fermer modal & reset form
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
            form.reset();
        });
    });

});



