<?php
require_once ROOTPATH . '/src/Templates/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: /register');
    exit;
}

use App\Database\Database;
use App\Repository\EmployeeRepository;

$pdo = (new Database())->getConnection();
$employeeRepo = new EmployeeRepository($pdo);
$employees = $employeeRepo->getAllEmployees();
$totalEmployees = count($employees);
?>

<h1 class="text-3xl text-center mt-15 mb-10">Mon dashboard</h1>

<h2 class="text-xl text-center text-white mb-8">Bienvenue sur votre espace de gestion</h2>

<section class="flex column justify-center">
    <div class="flex flex-wrap justify-center gap-8 w-full">
        <div class="card-dashboard border bg-white w-1/3 rounded-xl p-4">
        <p class="carpooling text-black">Nombre d'employés</p>
        <p class="carpooling text-black"><?= $totalEmployees ?></p>
        <button class="btn btn-dashboard rounded-xl"><a href="/employeAdmin">Gérer les employés</a></button>
    </div>
        <div class="card-dashboard border bg-white w-1/3 rounded-xl p-4">
            <p class="user text-black">Nombre d'utilisateurs</p>
            <p class="user text-black"><?= $totalUsers ?></p>
            <button class="btn btn-dashboard rounded-xl"><a href="/userAdmin">Gérer les utilisateurs</a></button>
        </div>
        <div class="card-dashboard border bg-white w-1/3 rounded-xl p-4">
            <p class="carpooling text-black">Nombre de covoiturages</p>
            <p class="carpooling text-black"><?= $totalCarpoolings ?></p>
            <button class="btn btn-dashboard rounded-xl"><a href="/carpoolingAdmin">Gérer les covoiturages</a></button>
        </div>
    </div>
</section>



<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>