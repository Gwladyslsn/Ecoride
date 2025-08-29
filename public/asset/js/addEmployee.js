document.addEventListener('DOMContentLoaded', () => {
    const btnAddEmployee = document.getElementById('btn-add-employee');
    const formEmployee = document.getElementById('employeeForm');
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
        if (!LastnameEmployee || !NameEmployee || !EmailEmployee || !TelEmployee || !DateHireEmployee || !PasswordEmployee) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        // Email format validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(inputEmailEmployee.value)) {
            alert('Veuillez entrer une adresse e-mail valide.');
            return;
        }

        // Telephone format validation (basic)
        const telPattern = /^\+?[0-9\s\-]{7,15}$/;
        if (!telPattern.test(inputTelEmployee.value)) {
            alert('Veuillez entrer un numéro de téléphone valide.');
            return;
        }

        const specialCharRegex = /[^A-Za-z0-9]/;
        if (PasswordEmployee === "") {
            errors['PasswordEmployee'] = "Le champ Mot de passe ne doit pas etre vide."
        } else if (PasswordEmployee.length < 9) {
            errors['PasswordEmployee'] = "Le mot de passe doit contenir au moins 9 caractères."
        } else if (!specialCharRegex.test(PasswordEmployee)) {
            errors['PasswordEmployee'] = "Le mot de passe doit contenir au moins un caractère special."
        }

        
        

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
            //formEmployee.submit();
            console.log('data');
        }
    });




});