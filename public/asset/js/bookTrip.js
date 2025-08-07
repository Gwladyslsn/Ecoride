document.addEventListener('DOMContentLoaded', () => {
    const btnBook = document.getElementById('book-btn');
    const idUser = btnBook.dataset.user;
    const idCarpooling = btnBook.dataset.carpooling;

    btnBook.addEventListener('click', (e) => {
        e.preventDefault();
        firstCheck();

    });


    function firstCheck() {
        // Envoi Back
        const data = {
            id_user: idUser,
            id_carpooling: idCarpooling,
        };

        fetch('/bookTrip', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(response => {
                if (response.status === "ok") {
                    // Afficher bloc de confirmation
                    console.log('afficher bloc de resa');

                } else if (response.status === "deja_reserve") {
                    // Message spécifique
                    console.log('deja reservé');
                } else if (response.status === "autre_trajet_ce_jour") {
                    // Autre message spécifique
                    console.log('deja trajet ce jour');
                }
            })
            .catch((errors) => {
                console.error('Fetch error:', errors);
                alert('Erreur réseau ou serveur : ' + errors.message);
            });



    }
});
