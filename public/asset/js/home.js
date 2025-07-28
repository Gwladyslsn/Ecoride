document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.getElementById("carousel-inner");
    const slides = carousel.children;
    const totalSlides = slides.length;
    let currentIndex = 0;

    const updateCarousel = () => {
        const offset = -currentIndex * slides[0].offsetWidth;
        carousel.style.transform = `translateX(${offset}px)`;
    };

    document.getElementById("prevReview").addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateCarousel();
    });

    document.getElementById("nextReview").addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateCarousel();
    });

    // Redimensionnement (mobile, etc.)
    window.addEventListener("resize", updateCarousel);
});