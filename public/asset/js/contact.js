document.addEventListener("DOMContentLoaded", function () {
    const lastnameContactInput = document.getElementById('lastname-contact');
    const nameContactInput = document.getElementById('name-contact');
    const emailContactInput = document.getElementById('email-contact');
    const phoneContactInput = document.getElementById('phone-contact');
    const subjectContactInput = document.getElementById('subject-contact');
    const messageContactInput = document.getElementById('message-contact');
    const btnSend = document.getElementById('btn-send');
    const formContact = document.getElementById('form-contact');
    const feedbackContact = document.getElementById('feedback-contact');


    btnSend.addEventListener('click', (e) => {
        e.preventDefault();

        //Nettoyer les données
        let lastnameContact = lastnameContactInput.value.trim();
        let nameContact = nameContactInput.value.trim();
        let emailContact = emailContactInput.value.trim();
        let phoneContact = phoneContactInput.value.trim();
        let subjectContact = subjectContactInput.value.trim();
        let messageContact = messageContactInput.value.trim();

        const errors = {};

        //verif des champs
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailContact === "") {
            errors['emailContact'] = "Le champ Mail ne doit pas etre vide"
        } else if (!emailRegex.test(emailContact)) {
            errors['emailContact'] = "Le format de l'adresse mail est invalide !"
        }

        if (lastnameContact === "") {
            errors['lastnameContact'] = "Le nom ne doit pas etre vide"
        }

        if (nameContact === "") {
            errors['nameContact'] = "Le prénom ne doit pas etre vide"
        }

        if (phoneContact === "") {
            errors['phoneContact'] = "Le N° de téléphone ne doit pas etre vide"
        }
        if (subjectContact === "") {
            errors['subjectContact'] = "Le sujet ne doit pas être vide"
        }
        if (messageContact === "") {
            errors['messageContact'] = "Le message ne peux pas être vide"
        }

        if (Object.keys(errors).length > 0) {
            feedbackContact.innerHTML = '';
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            const ul = document.createElement('ul');


            for (let key in errors) {
                const li = document.createElement('li');
                li.textContent = errors[key];
                ul.appendChild(li);
            }

            alertDiv.appendChild(ul);
            formContact.appendChild(alertDiv);

            //console.log("Erreurs de validation côté client :", errors);
        } else {
            // Envoi en AJAX via fetch()
            fetch('/contactUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    lastnameContact: lastnameContact,
                    nameContact: nameContact,
                    emailContact: emailContact,
                    phoneContact: phoneContact,
                    subjectContact: subjectContact,
                    messageContact: messageContact
                })
            })
                .then(response => response.text())
                .then(data => {
                    feedbackContact.innerHTML = '';
                    const alertSuccess = document.createElement('div');
                    alertSuccess.className = 'alert alert-success';
                    alertSuccess.textContent = data;
                    formContact.appendChild(alertSuccess);

                    // Réinitialiser les champs
                    formContact.reset();
                })
                .catch(error => {
                    feedbackContact.innerHTML = '';
                    const alertError = document.createElement('div');
                    alertError.className = 'alert alert-danger';
                    alertError.textContent = "Une erreur est survenue lors de l’envoi du message.";
                    formContact.appendChild(alertError);
                    console.error('Erreur fetch :', error);
                });
        }
    })
})