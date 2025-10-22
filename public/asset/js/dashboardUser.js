document.addEventListener('DOMContentLoaded', () => {

    /* Modif photo de profil */
    const editPhoto = document.getElementById('edit-photo');
    const fileInput = document.getElementById('file-input');
    const submitBtn = document.getElementById('submit-btn');

    editPhoto.addEventListener('click', (e) => {
        e.preventDefault();
        fileInput.classList.remove('hidden');
        submitBtn.classList.remove('hidden');
    })

    fileInput.addEventListener('change', () => {
    });


    /* Modif info perso */
    const editBtn = document.getElementById('edit-user-btn');
    const profileSection = editBtn.closest('.profile-section');

    editBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (editBtn.textContent.includes('Modifier')) {
            const spans = profileSection.querySelectorAll('span.edit-info');
            for (const span of spans) {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = span.dataset.field;
                input.value = span.textContent.trim();
                input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');
                span.replaceWith(input);
            }
            editBtn.textContent = 'Sauvegarder mes informations';
        } else {
            const inputs = profileSection.querySelectorAll('input[name]');
            const data = {};
            for (const input of inputs) {
                data[input.name] = input.value.trim();
            }

            fetch('/updateUser', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        //debug : alert('Informations mises à jour !');
                        globalThis.location.reload();
                    } else {
                        alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                    }
                })
                .catch(() => {
                    alert('Erreur réseau ou serveur');
                });
        }
    });

    /* Modif info voiture */
    const editCar = document.getElementById('edit-btn-car');
    const sectionCar = editCar.closest('.car-section');

    editCar.addEventListener('click', (e) => {
        e.preventDefault();
        if (editCar.textContent.includes('Modifier')) {
            const spansCar = sectionCar.querySelectorAll('span.edit-car');
            for (const spanCar of spansCar) {
                let input;
                if (spanCar.dataset.field === 'energy_car') {
                    // Création du select pour énergie
                    input = document.createElement('select');
                    input.name = spanCar.dataset.field;
                    input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');

                    // Liste des options possibles
                    const options = ['Essence', 'Diesel', 'Électrique', 'Hybride'];
                    for (const optionValue of options) {
                        const option = document.createElement('option');
                        option.value = optionValue.toLowerCase();
                        option.textContent = optionValue;
                        if (spanCar.textContent.trim().toLowerCase() === optionValue.toLowerCase()) {
                            option.selected = true;
                        }
                        input.appendChild(option);
                    }
                } else {
                    // Sinon input texte normal
                    input = document.createElement('input');
                    input.type = 'text';
                    input.name = spanCar.dataset.field;
                    input.value = spanCar.textContent.trim();
                    input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');
                }
                spanCar.replaceWith(input);
            }
            editCar.textContent = 'Sauvegarder mes informations';
        } else {
            const inputs = sectionCar.querySelectorAll('input[name], select[name]');
            const data = {};
            for (const input of inputs) {
                data[input.name] = input.value.trim();
            }

            fetch('/updateCar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        globalThis.location.reload();
                    } else {
                        alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                    }
                })
                .catch(() => {
                    alert('Erreur réseau ou serveur');
                });
        }
    });


    /* Modif photo voiture */
    const editPhotoCar = document.getElementById('edit-photo-car');
    const fileInputCar = document.getElementById('file-input-car');
    const submitBtnCar = document.getElementById('submit-btn-car');

    editPhotoCar.addEventListener('click', (e) => {
        e.preventDefault();
        fileInputCar.classList.remove('hidden');
        submitBtnCar.classList.remove('hidden');
    })

    fileInputCar.addEventListener('change', () => {
    });

    /* --- Préférences utilisateur : toggles live --- */
    const prefSection = document.getElementById('preferences-section');
    const prefInputs = prefSection.querySelectorAll('input[type="checkbox"]');

    for (const input of prefInputs) {
    // Chaque checkbox doit avoir un data-id-preference correspondant à id_preference en BDD
    const prefId = input.dataset.idPreference;

    input.addEventListener('change', () => {
        const checked = input.checked;

        const data = {
            id_preference: prefId,
            checked: checked
        };

        fetch('/updatePreferences', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(response => {
                if (!response.success) {
                    alert('Erreur : Impossible de sauvegarder la préférence');
                    // Revenir à l’état précédent si erreur
                    input.checked = !checked;
                }
            })
            .catch(() => {
                alert('Erreur réseau ou serveur');
                input.checked = !checked;
            });
    });
}

});
