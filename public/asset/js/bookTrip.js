document.addEventListener('DOMContentLoaded', () => {
    const btnBook = document.getElementById('book-btn');
    const idUser = btnBook.dataset.user;
    const idCarpooling = btnBook.dataset.carpooling;

    // Création du conteneur de récap sous le bouton
    const recapContainer = document.createElement('div');
    recapContainer.id = 'recap-container';
    recapContainer.style.marginTop = '60px';
    btnBook.parentNode.insertBefore(recapContainer, btnBook.nextSibling);

    btnBook.addEventListener('click', (e) => {
        e.preventDefault();

        if (!document.getElementById('confirm-btn')) {
            recapContainer.innerHTML = `
        <div style="
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        max-width: 320px;
        ">
        <p class="text-black" style="margin-bottom: 15px; font-weight: 500;">Êtes-vous sûr de vouloir réserver ce trajet ? Pensez à vérifier les informations ci-dessus</p>
        <button id="confirm-btn" style="
            background-color: #7A9E7E;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 10px;
        ">Confirmer</button>
        <button id="cancel-btn" style="
            background-color: #E5690B;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        ">Annuler</button>
        </div>
    `;

            document.getElementById('confirm-btn').addEventListener('click', confirmBooking);
            document.getElementById('cancel-btn').addEventListener('click', () => {
                recapContainer.innerHTML = '';
            });
        }
    });

    function confirmBooking() {
        const data = {
            id_user: idUser,
            id_carpooling: idCarpooling,
        };

        fetch('/bookTrip', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        })
            .then((res) => res.json())
            .then((response) => {
                if (response.status === 'ok') {
                    recapContainer.innerHTML = `<p style="color:green; font-weight:600;">Réservation confirmée avec succès ! Retrouvez votre voyage dans votre onglet "Historique"</p>`;
                    btnBook.style.display = 'none';
                } else if (response.status === 'deja_reserve') {
                    recapContainer.innerHTML = `<p style="color:orange; font-weight:600;">Vous avez déjà réservé ce trajet.</p>`;
                } else if (response.status === 'autre_trajet_ce_jour') {
                    recapContainer.innerHTML = `<p style="color:orange; font-weight:600;">Vous avez déjà un trajet réservé ce jour.</p>`;
                } else if (response.status === 'complet') {
                    recapContainer.innerHTML = `<p style="color:orange; font-weight:600;">Ce trajet est déja complet.</p>`;
                } else if (response.status === 'role_non_autorise') {
                    recapContainer.innerHTML = `<p style="color:red; font-weight:600;">En tant que chauffeur, vous n'êtes pas autorisé(e) à réserver ce trajet.</p>`;
                } else {
                    recapContainer.innerHTML = `<p style="color:red; font-weight:600;">Erreur lors de la réservation.</p>`;
                }
            })
            .catch((error) => {
                console.error('Fetch error:', error);
                recapContainer.innerHTML = `<p style="color:red; font-weight:600;">Erreur réseau ou serveur.</p>`;
            });
    }
});


