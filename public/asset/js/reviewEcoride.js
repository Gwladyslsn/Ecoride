document.addEventListener("DOMContentLoaded", function () {
    const nameReviewEcorideInput = document.getElementById('name-review-ecoride');
    const emailReviewEcorideInput = document.getElementById('email-review-ecoride');
    const textReviewEcorideInput = document.getElementById('text-review-ecoride');
    const btnReviewEcoride = document.getElementById('btn-review-ecoride');
    const feedbackReviewEcoride = document.getElementById('feedback-review-ecoride');
    const formReviewEcoride = document.getElementById('reviewForm');

    btnReviewEcoride.addEventListener('click', (e) => {
        e.preventDefault();

        //Nettoyage des données
        let nameReviewEcoride = nameReviewEcorideInput.value.trim();
        let emailReviewEcoride = emailReviewEcorideInput.value.trim();
        let selectedRating = document.querySelector('input[name="rating-4"]:checked').value;
        let textReviewEcoride = textReviewEcorideInput.value.trim();

        //console.log('data :',nameReviewEcoride, emailReviewEcoride, selectedRating, textReviewEcoride);


        const errors = {}

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailReviewEcoride === "") {
            errors['emailReviewEcoride'] = "Le Mail ne doit pas etre vide"
        } else if (!emailRegex.test(emailReviewEcoride)) {
            errors['emailReviewEcoride'] = "Le format de l'adresse mail est invalide !"
        }

        if (nameReviewEcoride === "") {
            errors['nameReviewEcoride'] = "Le prénom ne doit pas etre vide"
        }

        if (selectedRating === "") {
            errors['selectedRating'] = "La note doit etre selectionnée"
        }

        if (textReviewEcoride === "") {
            errors['textReviewEcoride'] = "Votre avis ne doit pas être vide"
        }

        if (Object.keys(errors).length > 0) {
            feedbackReviewEcoride.innerHTML = '';
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            const ul = document.createElement('ul');


            for (let key in errors) {
                const li = document.createElement('li');
                li.textContent = errors[key];
                ul.appendChild(li);
            }

            alertDiv.appendChild(ul);
            formReviewEcoride.appendChild(alertDiv);

        } else {
            fetch('?controller=page&action=addReviewEcoride', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nameReviewEcoride: nameReviewEcoride,
                    emailReviewEcoride: emailReviewEcoride,
                    selectedRating: selectedRating,
                    textReviewEcoride: textReviewEcoride
                })
            })
                .then(response => response.text())
                .then(data => {
                    feedbackReviewEcoride.innerHTML = '';
                    const alertSuccess = document.createElement('div');
                    alertSuccess.className = 'alert alert-success';
                    alertSuccess.textContent = 'Votre message a été envoyé avec succès';
                    formReviewEcoride.appendChild(alertSuccess);

                    setTimeout(() => {
                        formReviewEcoride.reset();
                    }, 5000);
                })
                .catch(error => {
                    feedbackReviewEcoride.innerHTML = '';
                    const alertError = document.createElement('div');
                    alertError.className = 'alert alert-danger';
                    alertError.textContent = "Une erreur est survenue lors de l’envoi du message.";
                    formReviewEcoride.appendChild(alertError);
                    console.error('Erreur fetch :', error);
                });



        }

    })
})
