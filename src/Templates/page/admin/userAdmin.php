<?php
require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\UserRepository;
use App\Database\Database;

if (!isset($_SESSION['admin'])) {
    header('Location: /register');
    exit;
}

$pdo = (new Database())->getConnection();
$userRepo = new UserRepository($pdo);
$users = $userRepo->getAllUsers();
$totalUsers = count($users);
$usersWithCredit = $userRepo->countUsersWithCredit();
$totalCredits = $userRepo->getTotalCredits();
$averageCredit = $userRepo->getAverageCredit();
?>

<h1 class="page-title">Gestion des utilisateurs</h1>

<div class="pl-4 text-lg">
    <i class="fa-solid fa-arrow-left-long"></i>
    <a href="<?= BASE_URL ?>dashboardAdmin">Retour</a>
</div>

<div class="main-content p-8">

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $totalUsers ?></div>
            <div class="stat-label">Utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $usersWithCredit ?></div>
            <div class="stat-label">Utilisateurs avec crédits</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $totalCredits ?></div>
            <div class="stat-label">Total crédits utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $averageCredit ?></div>
            <div class="stat-label">Moyenne crédits/utilisateur</div>
        </div>
    </div>

    <div class="actions-bar">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Rechercher un utilisateur..." id="searchUser">
        </div>
    </div>


    <section class="admin-section">
        <div class="table-admin-container">
            <table class="table-admin mx-auto">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Crédits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id_user']) ?></td>
                            <td>
                                <div class="user-name"><?= htmlspecialchars($user['name_user'] . ' ' . $user['lastname_user']) ?></div>
                            </td>
                            <td>
                                <div class="user-email"><?= htmlspecialchars($user['email_user']) ?></div>
                            </td>
                            <td>
                                <span class="credit-badge"><?= $user['credit_user'] ?> <i class="fa-brands fa-pagelines"></i></span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="/admin/user_edit.php?id=<?= $user['id_user'] ?>" class="btn-link">Modifier</a>
                                    <a href="/admin/user_delete.php?id=<?= $user['id_user'] ?>" class="btn-link">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="pl-4 text-lg">
    <i class="fa-solid fa-arrow-left-long"></i>
    <a href="<?= BASE_URL ?>dashboardAdmin">Retour</a>
</div>

<?php require_once ROOTPATH . '/src/Templates/footer.php'; ?>