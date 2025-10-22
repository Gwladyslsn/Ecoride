document.addEventListener('DOMContentLoaded', () => {
    const btnAddEmployee = document.getElementById('btn-add-employee');
    //const formEmployee = document.getElementById('employeeForm');
    const inputLastnameEmployee = document.getElementById('lastname_employee');
    const inputNameEmployee = document.getElementById('name_employee');
    const inputEmailEmployee = document.getElementById('email_employee');
    const inputTelEmployee = document.getElementById('tel_employee');
    const inputDateHireEmployee = document.getElementById('dateHire_employee');
    const inputPasswordEmployee = document.getElementById('password_employee');
    const feedbackAddEmployee = document.getElementById('feedbackAddEmployee');


    btnAddEmployee.addEventListener('click', (event) => {
        event.preventDefault();

        //nettoyage Input
        let LastnameEmployee = inputLastnameEmployee.value.trim();
        let NameEmployee = inputNameEmployee.value.trim();
        let EmailEmployee = inputEmailEmployee.value.trim();
        let TelEmployee = inputTelEmployee.value.trim();
        let DateHireEmployee = inputDateHireEmployee.value.trim();
        let PasswordEmployee = inputPasswordEmployee.value.trim();


        //Stock erreurs
        const errors = {};

        // Simple validation
        if (!LastnameEmployee) {
            errors['LastnameEmployee'] = 'Le champ Nom ne doit pas etre vide.';
        }
        if (!NameEmployee) {
            errors['NameEmployee'] = 'Le champ Prénom ne doit pas etre vide.';
        }
        if (!DateHireEmployee) {
            errors['DateHireEmployee'] = 'Le champ Date d\'embauche ne doit pas etre vide.';
        }

        // Email format validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(EmailEmployee)) {
            errors['EmailEmployee'] = 'Veuillez entrer une adresse e-mail valide.';
        }

        // Telephone validation
        const telPattern = /^\+?[0-9\s-]{7,15}$/;
        if (!telPattern.test(TelEmployee)) {
            errors['TelEmployee'] = ('Veuillez entrer un numéro de téléphone valide.');
        }
        if (TelEmployee === "") {
            errors['TelEmployee'] = "Le champ Téléphone ne doit pas etre vide."
        }

        const specialCharRegex = /[^A-Za-z0-9]/;
        if (PasswordEmployee === "") {
            errors['PasswordEmployee'] = "Le champ Mot de passe ne doit pas etre vide."
        } else if (PasswordEmployee.length < 9) {
            errors['PasswordEmployee'] = "Le mot de passe doit contenir au moins 9 caractères."
        } else if (!specialCharRegex.test(PasswordEmployee)) {
            errors['PasswordEmployee'] = "Le mot de passe doit contenir au moins un caractère special."
        }

        const inputs = document.querySelectorAll('input[name]');
        const data = {};
        for (const input of inputs) {
            data[input.name] = input.value.trim();
        }

        fetch('/addNewEmployee', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    //debug : alert('Informations mises à jour !');
                    setTimeout(() => {
                        globalThis.location.reload();
                    }, 8000);
                } else {
                    alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                }
            })
            .catch(() => {
                alert('Erreur réseau ou serveur');
            });




        //Afficher message si erreur
        if (Object.keys(errors).length > 0) {

            feedbackAddEmployee.innerHTML = '';

            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';

            const ul = document.createElement('ul');


            for (let key in errors) {
                const li = document.createElement('li');
                li.textContent = errors[key];
                ul.appendChild(li);
            }

            alertDiv.appendChild(ul);
            feedbackAddEmployee.appendChild(alertDiv);

            console.log("Erreurs de validation côté client :", errors);
        } else {
            feedbackAddEmployee.innerHTML = `L'employé ${NameEmployee} ${LastnameEmployee} a bien été créé.`;
            //formEmployee.submit();
        }
    });




});