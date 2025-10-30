// Fonction pour récupérer les coordonnées
async function getCoordinates(cityName) {
    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(cityName)}`);
    const data = await response.json();
    if (data.length === 0) return null;

    return {
        lat: Number.parseFloat(data[0].lat),
        lng: Number.parseFloat(data[0].lon),
    };
}

// Fonction pour initialiser la carte
function initMap(departure, arrival) {
    const map = L.map('map').setView([departure.lat, departure.lng], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([departure.lat, departure.lng]).addTo(map).bindPopup("Départ");
    L.marker([arrival.lat, arrival.lng]).addTo(map).bindPopup("Arrivée");

    L.polyline([
        [departure.lat, departure.lng],
        [arrival.lat, arrival.lng]
    ], { color: 'blue' }).addTo(map);
}

// Main
document.addEventListener("DOMContentLoaded", async () => {
    const mapElement = document.getElementById("map");
    if (!mapElement) return;

    try {
        const departureCoords = await getCoordinates(departureCity);
        const arrivalCoords = await getCoordinates(arrivalCity);

        if (!departureCoords || !arrivalCoords) {
            throw new Error("Coordonnées non trouvées");
        }

        initMap(departureCoords, arrivalCoords);
    } catch (error) {
        console.error("Erreur :", error);
    }
});

window.addEventListener('resize', function () {
    if (window.myMap) { // remplace myMap par ta variable de carte
        myMap.invalidateSize();
    }
});



