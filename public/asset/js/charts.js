document.addEventListener("DOMContentLoaded", () => {
    const ctx1 = document.getElementById('ridesPerDayChart');
    const ctx2 = document.getElementById('creditsPerDayChart');

    fetch('/api/stats/carpoolings-per-day')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(item => item.day);
        const values = data.map(item => item.total);

        const ctx1 = document.getElementById('ridesPerDayChart');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Covoiturages par jour',
                    data: values,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0,0,255,0.2)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });
    });

    fetch('/api/stats/credits-per-day')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(item => item.day);
        const values = data.map(item => item.total);

        const ctx2 = document.getElementById('creditsPerDayChart');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Crédits gagnés par jour',
                    data: values,
                    borderColor: 'green',
                    backgroundColor: 'rgba(16, 194, 70, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });
    });

    new Chart(ctx1, config1);
    new Chart(ctx2, config2);
});




