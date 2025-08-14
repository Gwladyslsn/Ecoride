<?php
require_once ROOTPATH . '/src/Templates/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: /register');
    exit;
}
?>

<div class="container">
    <h1 class="page-title">Gestion des employés</h1>

<div class="pl-4 text-lg">
    <i class="fa-solid fa-arrow-left-long"></i>
    <a href="<?= BASE_URL ?>dashboardAdmin">Retour</a>
</div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number">12</span>
            <div class="stat-label">Employés actifs</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">47</span>
            <div class="stat-label">Avis en attente</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">8</span>
            <div class="stat-label">Signalements</div>
        </div>
    </div>

    <div class="actions-bar">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Rechercher un employé..." id="searchInput">
        </div>
        <button class="add-btn" onclick="addEmployee()">+ Ajouter un employé</button>
    </div>

    <div class="table-container">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Rôle</th>
                    <th>Date d'embauche</th>
                    <th>Avis traités</th>
                    <th>Signalements résolus</th>
                    <th>Statut compte</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody">
                <!-- Les données seront insérées ici par JavaScript -->
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