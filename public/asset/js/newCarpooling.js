document.addEventListener('DOMContentLoaded', () => {
    const departureCityInput = document.getElementById('departure-city');
    const departureDateInput = document.getElementById('departure-date');
    const departureHourInput = document.getElementById('departure-hour');
    const arrivalCityInput = document.getElementById('arrival-city');
    const arrivalDateInput = document.getElementById('arrival-date');
    const arrivalHourInput = document.getElementById('arrival-hour');
    const pricePlaceInput = document.getElementById('price-place');
    const btnSubmitTrip = document.getElementById('btn-submit-trip');
    const infoCarpoolingInput = document.getElementById('info-carpooling');
    const feedbackAdd = document.getElementById('feedback-add-carpooling');


    let selectedSeats = null;

    document.querySelectorAll('.seat-option').forEach(option => {
        option.addEventListener('click', function () {
            document.querySelectorAll('.seat-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            selectedSeats = Number.parseInt(this.dataset.seats);
        });
    });


    btnSubmitTrip.addEventListener('click', async (e) => {
        e.preventDefault();

        let departureCity = departureCityInput.value.trim();
        let departureDate = departureDateInput.value.trim();
        let departureHour = departureHourInput.value.trim();
        let arrivalCity = arrivalCityInput.value.trim();
        let arrivalDate = arrivalDateInput.value.trim();
        let arrivalHour = arrivalHourInput.value.trim();
        let pricePlace = pricePlaceInput.value.trim();
        let infoCarpooling = infoCarpoolingInput.value.trim();
        let nbPlace = selectedSeats;

        const errors = {};

        // Verif remplissage
        if (!departureCity || departureCity.length < 2) {
            errors['departureCity'] = "La ville de départ ne doit pas être vide ou contenir qu'1 caractère";
        }
        if (!departureDate) {
            errors['departureDate'] = "La date de départ ne doit pas être vide";
        }
        if (!departureHour) {
            errors['departureHour'] = "L'heure de départ ne doit pas être vide";
        }
        if (!arrivalCity || arrivalCity.length < 2) {
            errors['arrivalCity'] = "La ville d'arrivée ne doit pas être vide ou contenir qu'1 caractère";
        }
        if (!arrivalDate) {
            errors['arrivalDate'] = "La date d'arrivée ne doit pas être vide";
        }
        if (!arrivalHour) {
            errors['arrivalHour'] = "L'heure d'arrivée ne doit pas être vide";
        }
        if (!pricePlace) {
            errors['pricePlace'] = "Le nombre de crédits ne doit pas être vide";
        }
        if (!nbPlace) {
            errors['nbPlace'] = "Le nombre de places ne doit pas être vide";
        }

        if (Object.keys(errors).length > 0) {
            afficherErreurs(errors);
            return;
        };

        
        // Envoi Back
        const data = {
            departure_city: departureCity,
            departure_date: departureDate,
            departure_hour: departureHour,
            arrival_city: arrivalCity,
            arrival_date: arrivalDate,
            arrival_hour: arrivalHour,
            price_place: pricePlace,
            info_carpooling: infoCarpooling,
            nb_place: nbPlace
        };

        fetch('/newCarpooling', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    const alertSuccess = document.getElementById('alert-success');
                    alertSuccess.classList.remove('hidden');
                    setTimeout(() => {
                        globalThis.location.reload();
                    }, 3000)
                } else {
                    alert('Erreur : ' + (response.message || 'Impossible de sauvegarder'));
                }
            })
            .catch((errors) => {
                console.error('Fetch error:', errors);
                alert('Erreur réseau ou serveur : ' + errors.message);
            });
    });

    function afficherErreurs(errors) {
        feedbackAdd.innerHTML = "";

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';

        const ul = document.createElement('ul');
        for (let key in errors) {
            const li = document.createElement('li');
            li.textContent = errors[key];
            ul.appendChild(li);
        }

        alertDiv.appendChild(ul);
        feedbackAdd.appendChild(alertDiv);
    }
});



