<?php
require_once ROOTPATH . '/src/Templates/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?controller=admin&action=dashboardAdmin');
    exit;
}
?>

<h1 class="text-3xl text-center mt-20 mb-15">Mon dashboard</h1>

<section class="flex column justify-center">
    <div class="flex justify-center gap-8 w-full flex flex-wrap column">
        <div class="card-dashboard border bg-white w-1/3 rounded-lg p-4">
            <p class="user text-black">Nombre d'utilisateurs</p>
            <p class="user text-black">12</p>
            <button class="btn btn-dashboard"><a href="">Gérer les utilisateurs</a></button>
        </div>
        <div class="card-dashboard border bg-white w-1/3 rounded-lg p-4">
            <p class="carpooling text-black">Nombre de covoiturages</p>
            <p class="carpooling text-black">25</p>
            <button class="btn btn-dashboard"><a href="">Gérer les covoiturages</a></button>
        </div>
        <div class="card-dashboard border bg-white w-1/3 rounded-lg p-4">
            <p class="carpooling text-black">Nombre d'employés</p>
            <p class="carpooling text-black">2</p>
            <button class="btn btn-dashboard"><a href="">Gérer les employés</a></button>
        </div>
        <div class="card-dashboard border bg-white w-1/3 rounded-lg p-4">
            <p class="carpooling text-black">Nombre d'avis</p>
            <p class="carpooling text-black">5</p>
            <button class="btn btn-dashboard"><a href="">Gérer les avis</a></button>
        </div>
    </div>

</section>



<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>
