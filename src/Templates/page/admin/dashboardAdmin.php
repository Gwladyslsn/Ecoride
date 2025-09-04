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

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl sm:text-3xl lg:text-4xl text-center mt-8 sm:mt-12 lg:mt-15 mb-6 sm:mb-8 lg:mb-10 font-bold">Mon dashboard</h1>

    <!-- Section des cartes de statistiques -->
    <section class="mb-8 sm:mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 w-full">
            <div class="card-dashboard border bg-white rounded-xl p-4 sm:p-6 shadow-md hover:shadow-lg transition-shadow">
                <p class="carpooling text-black text-sm sm:text-base font-semibold mb-2">Nombre d'employés</p>
                <p class="carpooling text-black text-xl sm:text-2xl font-bold mb-4"><?= $totalEmployees ?></p>
                <button class="btn btn-dashboard rounded-xl w-full sm:w-auto px-4 py-2">
                    <a href="/employeAdmin" class="block">Gérer les employés</a>
                </button>
            </div>
            
            <div class="card-dashboard border bg-white rounded-xl p-4 sm:p-6 shadow-md hover:shadow-lg transition-shadow">
                <p class="user text-black text-sm sm:text-base font-semibold mb-2">Nombre d'utilisateurs</p>
                <p class="user text-black text-xl sm:text-2xl font-bold mb-4"><?= $totalUsers ?></p>
                <button class="btn btn-dashboard rounded-xl w-full sm:w-auto px-4 py-2">
                    <a href="/userAdmin" class="block">Gérer les utilisateurs</a>
                </button>
            </div>
            
            <div class="card-dashboard border bg-white rounded-xl p-4 sm:p-6 shadow-md hover:shadow-lg transition-shadow md:col-span-2 xl:col-span-1">
                <p class="carpooling text-black text-sm sm:text-base font-semibold mb-2">Nombre de covoiturages</p>
                <p class="carpooling text-black text-xl sm:text-2xl font-bold mb-4"><?= $totalCarpoolings ?></p>
                <button class="btn btn-dashboard rounded-xl w-full sm:w-auto px-4 py-2">
                    <a href="/carpoolingAdmin" class="block">Gérer les covoiturages</a>
                </button>
            </div>
        </div>
    </section>

    <!-- Section des graphiques -->
    <section>
        <h2 class="text-center text-xl sm:text-2xl lg:text-3xl mt-8 sm:mt-12 lg:mt-15 mb-6 sm:mb-8 lg:mb-10 font-bold">Chiffres clés</h2>
        
        <div class="space-y-6 sm:space-y-8 lg:space-y-10">
            <div class="w-full overflow-x-auto">
                <canvas id="ridesPerDayChart" class="bg-white rounded-xl w-full max-w-4xl h-64 sm:h-80 lg:h-96 mx-auto shadow-md"></canvas>
            </div>
            
            <div class="w-full overflow-x-auto">
                <canvas id="creditsPerDayChart" class="bg-white rounded-xl w-full max-w-4xl h-64 sm:h-80 lg:h-96 mx-auto shadow-md"></canvas>
            </div>
        </div>
    </section>
</div>

<script src="/asset/js/charts.js"></script>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>