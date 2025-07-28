document.addEventListener("DOMContentLoaded", () => {
    let searchData = null;

    if (!searchData && sessionStorage.getItem("searchData")) {
        searchData = JSON.parse(sessionStorage.getItem("searchData"));
    }

    if (searchData) {
        fetchTrips(searchData);
    }
});

// Fonction pour faire la requête à ton API
function fetchTrips(searchData) {
    fetch("http://localhost:8000/?controller=page&action=searchTripAPI", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(searchData),
    })
        .then((res) => {
            if (!res.ok) throw new Error("Erreur lors du fetch");
            return res.json();
        })
        .then((data) => {
            if (data.success && Array.isArray(data.trips)) {
                showTripsSearched(data.trips);
            } else {
                displayNoResults();
            }
        })
        .catch((err) => {
            console.error("Erreur réseau ou serveur :", err);
            displayNoResults();
        });
}

