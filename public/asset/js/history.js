document.addEventListener('DOMContentLoaded', function () {

    // CONTACT UTILISATEUR
    // Pour chaque bouton "Discuter du trajet"
    document.querySelectorAll('[id^="btn-contact-user-"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = btn.id.replace('btn-contact-user-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'flex';
        });
    });

    // Pour chaque bouton de fermeture de modal
    document.querySelectorAll('[id^="close-modal-"]').forEach(function (closeBtn) {
        closeBtn.addEventListener('click', function () {
            const id = closeBtn.id.replace('close-modal-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
        });
    });

    // Fermer la modal en cliquant à l'extérieur
    document.querySelectorAll('[id^="modal-discussion-"]').forEach(function (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Gestion de l'envoi du formulaire
    document.querySelectorAll('form[id^="form-message-"]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = form.id.replace('form-message-', '');
            const recipient = form.querySelector('select[name="recipient"]').value;
            const message = form.querySelector('textarea[name="message"]').value;
            alert('Message envoyé à ' + recipient + ' :\n' + message);
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
            form.reset();
        });
    });


    // Annuler trajet si conducteur



    // Annuler participation si passager

    // AVIS TRAJET
    // Pour chaque bouton "Laisser un avis"
    document.querySelectorAll('[id^="btn-review-"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            // console.log('click laisser avis');
            const id = btn.id.replace('btn-review-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'flex';
        });
    });

    // Pour chaque bouton de fermeture de modal
    document.querySelectorAll('[id^="close-modal-"]').forEach(function (closeBtn) {
        closeBtn.addEventListener('click', function () {
            const id = closeBtn.id.replace('close-modal-', '');
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
        });
    });

    // Fermer la modal en cliquant à l'extérieur
    document.querySelectorAll('[id^="modal-discussion-"]').forEach(function (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Gestion de l'envoi du formulaire
    document.querySelectorAll('form[id^="form-message-"]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = form.id.replace('form-message-', '');
            const message = form.querySelector('textarea[name="message"]').value;
            alert('Avis envoyé : ' + message);
            const modal = document.getElementById('modal-discussion-' + id);
            if (modal) modal.style.display = 'none';
            form.reset();
        });
    });

});

