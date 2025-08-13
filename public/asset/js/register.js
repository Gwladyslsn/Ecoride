// Remplacer les caracteres utilisés pour faille xss si inner.html:
/*function escapeHtml(text) {
    const map = {
        "&": "&amp",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;",
    };
    return text.replace(/[&<>"']/g, function (m) {
        return map[m]
    });
}*/

/* SECU CONNEXION */

document.addEventListener("DOMContentLoaded", function () {
    const emailLogInput = document.getElementById('email_log');
    const passwordLogInput = document.getElementById('password_log');
    const btnLog = document.getElementById('btn_log');
    const feedbackLogin = document.getElementById('feedbackLogin');
    const formLog = document.getElementById('form_log');

    /* masque / affiche mdp */

    const passwordShowIcon1 = document.querySelector('.password-show1');
    const passwordHideIcon1 = document.querySelector('.password-hide1');

    passwordShowIcon1.addEventListener('click', function () {
        passwordLogInput.type = 'text';
        passwordShowIcon1.classList.add('hidden');
        passwordHideIcon1.classList.remove('hidden');
    });

    passwordHideIcon1.addEventListener('click', function () {
        passwordLogInput.type = 'password';
        passwordHideIcon1.classList.add('hidden');
        passwordShowIcon1.classList.remove('hidden');
    });

    btnLog.addEventListener("click", function (event) {
        event.preventDefault();
        //console.log("click btn login");

        //Nettoyage des input
        let emailLog = emailLogInput.value.trim();
        let passwordLog = passwordLogInput.value.trim();

        //Stock erreurs
        const errors = {};

        //Vérification des champs
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailLog === "") {
            errors['emailLog'] = "Le champ Mail ne doit pas etre vide !"
        } else if (!emailRegex.test(emailLog)) {
            errors['emailLog'] = "Le format de l'adresse mail est invalide !"
        }

        if (passwordLog === "") {
            errors['passwordLog'] = "Le champ Mot de passe ne doit pas etre vide"
        }

        //Afficher message si erreur
        if (Object.keys(errors).length > 0) {
            feedbackLogin.innerHTML = '';

            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';

            const ul = document.createElement('ul');

            for (let key in errors) {
                const li = document.createElement('li');
                li.textContent = errors[key];
                ul.appendChild(li);
            }

            alertDiv.appendChild(ul);
            feedbackLogin.appendChild(alertDiv);

            //console.log("Erreurs de validation côté client :", errors);
        } else {
            formLog.submit();
        }

    })

});




/* SECU INSCRIPTION */
document.addEventListener("DOMContentLoaded", function () {
    const nameSignInput = document.getElementById('name_user_sign');
    const lastnameSignInput = document.getElementById('lastname_user_sign');
    const emailSignInput = document.getElementById('email_sign');
    const passwordSignInput = document.getElementById('password_sign');
    const passwordCheckInput = document.getElementById('password_sign_check');
    const btnSign = document.getElementById('btn_sign');
    const feedbackSign = document.getElementById('feedbackSign');
    const formSign = document.getElementById('form_sign');

    /* Masque / affichage mdp */ //A ameliorer + tard (repetition de code)

    const passwordShowIcon2 = document.querySelector('.password-show2');
    const passwordHideIcon2 = document.querySelector('.password-hide2');
    const passwordShowIcon3 = document.querySelector('.password-show3');
    const passwordHideIcon3 = document.querySelector('.password-hide3');

    passwordShowIcon2.addEventListener('click', function () {
        passwordSignInput.type = 'text';
        passwordShowIcon2.classList.add('hidden');
        passwordHideIcon2.classList.remove('hidden');
    });

    passwordHideIcon2.addEventListener('click', function () {
        passwordSignInput.type = 'password';
        passwordHideIcon2.classList.add('hidden');
        passwordShowIcon2.classList.remove('hidden');
    });

    passwordShowIcon3.addEventListener('click', function () {
        passwordCheckInput.type = 'text';
        passwordShowIcon3.classList.add('hidden');
        passwordHideIcon3.classList.remove('hidden');
    });

    passwordHideIcon3.addEventListener('click', function () {
        passwordCheckInput.type = 'password';
        passwordHideIcon3.classList.add('hidden');
        passwordShowIcon3.classList.remove('hidden');
    });



    btnSign.addEventListener("click", function (event) {
        event.preventDefault();

        //Nettoyage des input
        let nameSign = nameSignInput.value.trim();
        let lastnameSign = lastnameSignInput.value.trim();
        let emailSign = emailSignInput.value.trim();
        let passwordSign = passwordSignInput.value.trim();
        let passwordCheck = passwordCheckInput.value.trim();

        //Stock erreurs
        const errors = {};

        //Vérification des champs
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailSign === "") {
            errors['emailSign'] = "Le Mail ne doit pas etre vide "
        } else if (!emailRegex.test(emailSign)) {
            errors['emailSign'] = "Le format de l'adresse mail est invalide !"
        }

        if (nameSign === "") {
            errors['nameSign'] = "Le Prénom ne doit pas etre vide"
        }

        if (lastnameSign === "") {
            errors['lastnameSign'] = "Le Nom ne doit pas etre vide"
        }

        if (passwordSign === "") {
            errors['passwordSign'] = "Le Mot de passe ne doit pas etre vide"
        }
        if (passwordSign.length < 9) {
            errors['passwordSign'] = "Le Mot de passe doit contenir au moins 9 caractères"
        }
        if (passwordCheck != passwordSign) {
            errors['passwordCheck'] = "La confirmation du mot de passe est différente"
        }

        //Afficher message si erreur
        if (Object.keys(errors).length > 0) {

            feedbackSign.innerHTML = '';

            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';

            const ul = document.createElement('ul');


            for (let key in errors) {
                const li = document.createElement('li');
                li.textContent = errors[key];
                ul.appendChild(li);
            }

            alertDiv.appendChild(ul);
            feedbackSign.appendChild(alertDiv);

            console.log("Erreurs de validation côté client :", errors);
        } else {
            formSign.submit();
        }

    })

});