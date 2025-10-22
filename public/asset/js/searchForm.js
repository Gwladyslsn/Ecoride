document.addEventListener("DOMContentLoaded", () => {
    const formSearch = document.getElementById("formSearch");

    if (!formSearch) return;

    formSearch.addEventListener("submit", () => {

        const departureCityInput = document.getElementById("departure_city_search");
        const arrivalCityInput = document.getElementById("arrival_city_search");
        const dateInput = document.getElementById("date_search");

        let departureCity = departureCityInput.value.trim();
        let arrivalCity = arrivalCityInput.value.trim();
        let dateTrip = dateInput.value;

        const searchData = {
            departureCitySearch: departureCity,
            arrivalCitySearch: arrivalCity,
            dateSearch: dateTrip
        };

        if (!departureCity || !arrivalCity || !dateTrip) {
            alert("Veuillez remplir tous les champs !");
        }
    });
});
