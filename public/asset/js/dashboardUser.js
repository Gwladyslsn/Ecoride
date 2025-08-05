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
            spans.forEach(span => {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = span.dataset.field;
                input.value = span.textContent.trim();
                input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');
                span.replaceWith(input);
            });
            editBtn.textContent = 'Sauvegarder mes informations';
        } else {
            const inputs = profileSection.querySelectorAll('input[name]');
            const data = {};
            inputs.forEach(input => {
                data[input.name] = input.value.trim();
            });

            fetch('/updateUser', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        //debug : alert('Informations mises à jour !');
                        window.location.reload();
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
        spansCar.forEach(spanCar => {
            let input;
            if (spanCar.dataset.field === 'energy_car') {
                // Création du select pour énergie
                input = document.createElement('select');
                input.name = spanCar.dataset.field;
                input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');

                // Liste des options possibles (à adapter si besoin)
                const options = ['Essence', 'Diesel', 'Électrique', 'Hybride'];
                options.forEach(optionValue => {
                    const option = document.createElement('option');
                    option.value = optionValue.toLowerCase();
                    option.textContent = optionValue;
                    if (spanCar.textContent.trim().toLowerCase() === optionValue.toLowerCase()) {
                        option.selected = true;
                    }
                    input.appendChild(option);
                });
            } else {
                // Sinon input texte normal
                input = document.createElement('input');
                input.type = 'text';
                input.name = spanCar.dataset.field;
                input.value = spanCar.textContent.trim();
                input.classList.add('border', 'border-gray-300', 'rounded', 'px-2', 'py-1', 'w-full');
            }
            spanCar.replaceWith(input);
        });
        editCar.textContent = 'Sauvegarder mes informations';
    } else {
        const inputs = sectionCar.querySelectorAll('input[name], select[name]');
        const data = {};
        inputs.forEach(input => {
            data[input.name] = input.value.trim();
        });

        fetch('/updateCar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                window.location.reload();
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
});
