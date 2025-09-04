<?php
require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\AdminRepository;
use App\Database\Database;
use App\Repository\EmployeeRepository;

if (!isset($_SESSION['admin'])) {
    header('Location: /register');
    exit;
}

$pdo = (new Database())->getConnection();
$employeeRepo = new EmployeeRepository($pdo);
$employees = $employeeRepo->getAllEmployees();
$totalEmployees = count($employees);
?>

<div class="container">
    <h1 class="page-title">Gestion des employés</h1>

    <div class="pl-4 text-lg">
        <i class="fa-solid fa-arrow-left-long"></i>
        <a href="<?= BASE_URL ?>dashboardAdmin">Retour</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number"><?= $totalEmployees ?></span>
            <div class="stat-label">Employés actifs</div>
        </div>
        <div class="stat-card">
            <span class="stat-number"></span>
            <div class="stat-label">Avis en attente</div>
        </div>
        <div class="stat-card">
            <span class="stat-number"></span>
            <div class="stat-label">Avis traités</div>
        </div>
    </div>

    <div class="actions-bar">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Rechercher un employé..." id="searchInput">
        </div>
        <a href="<?= BASE_URL ?>addEmployee" target="_blank" rel="noopener noreferrer">
            <button class="add-btn" onclick="addEmployee()">+ Ajouter un employé</button>
        </a>
    </div>

    <div class="table-container">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>id employé</th>
                    <th>Identité</th>
                    <th>Date d'embauche</th>
                    <th>Email</th>
                    <th>Avis acceptés</th>
                    <th>Avis rejetés</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody">
                <?php foreach ($employees as $employee): ?>
                    <tr></tr>
                    <td><?= htmlspecialchars($employee['id_employee']) ?></td>
                    <td><?= htmlspecialchars($employee['name_employee']) ?> <?= htmlspecialchars($employee['lastname_employee']) ?></td>
                    <td><?= htmlspecialchars($employee['dateHire_employee']) ?></td>
                    <td><?= htmlspecialchars($employee['email_employee']) ?></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="/admin/carpooling_edit.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Modifier</a>
                        <a href="/admin/carpooling_delete.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Supprimer</a>
                    </td>
                <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="pl-4 text-lg">
    <i class="fa-solid fa-arrow-left-long"></i>
    <a href="<?= BASE_URL ?>dashboardAdmin">Retour</a>
</div>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>