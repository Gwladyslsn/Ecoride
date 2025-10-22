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


    // Annuler sa participation au trajet
    document.querySelectorAll('[id^="btn-cancel-booking-"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.id.replace('btn-cancel-booking-', '');
            const modal = document.getElementById('modal-cancel-booking-' + id);
            if (!modal) return;

            modal.style.display = 'flex';

            const carpoolingId = btn.dataset.carpoolingId;
            const btnYes = modal.querySelector('.btn-yes');
            const btnNo = modal.querySelector('.btn-no');

            btnYes.onclick = async () => {
                try {
                    const response = await fetch('/cancelBooking', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({carpoolingId})
                    });
                    const data = await response.json();
                    alert(data.message);

                    if (data.status === 'ok') {
                        // Optionnel : masquer le trajet annulé
                        document.getElementById('trip-' + id)?.remove();
                    }

                    modal.style.display = 'none';
                } catch (err) {
                    console.error(err);
                }
            };

            btnNo.onclick = () => {
                modal.style.display = 'none';
            };
        });
    });


    // Annuler son trajet
    document.querySelectorAll('[id^="btn-cancel-trip-"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.id.replace('btn-cancel-trip-', '');
            const modal = document.getElementById('modal-cancel-trip-' + id);
            if (!modal) return;

            modal.style.display = 'flex';

            const carpoolingId = btn.dataset.carpoolingId;
            const btnYes = modal.querySelector('.btn-yes');
            const btnNo = modal.querySelector('.btn-no');

            btnYes.onclick = async () => {
                try {
                    const response = await fetch('/cancelTrip', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({carpoolingId})
                    });
                    const data = await response.json();
                    alert(data.message);

                    if (data.status === 'ok') {
                        // Optionnel : masquer le trajet annulé
                        document.getElementById('trip-' + id)?.remove();
                    }

                    modal.style.display = 'none';
                } catch (err) {
                    console.error(err);
                }
            };

            btnNo.onclick = () => {
                modal.style.display = 'none';
            };
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
            const loaderOverlay = document.getElementById('loader-overlay');

            if (!recipientId || !rating || !idCarpooling) {
                alert('Veuillez remplir tous les champs.');
                return;
            }

            const data = {
                id_recipient: Number.parseInt(recipientId),
                note_reviews: Number.parseInt(rating),
                comment_reviews: comment,
                id_carpooling: Number.parseInt(idCarpooling),
                id_user: null
            };

            loaderOverlay.style.display = 'flex';

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
                    setTimeout(() => globalThis.location.reload(), 2000);
                } else {
                    alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                    loaderOverlay.style.display = 'none';
                }

            } catch (error) {
                //console.error('Fetch error:', error);
                loaderOverlay.style.display = 'none';
                alert('Erreur réseau ou serveur : ' + error.message);
            }

            // Fermer modal & reset form
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
            form.reset();
        });
    });




});



