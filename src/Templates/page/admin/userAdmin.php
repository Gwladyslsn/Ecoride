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
?>

<h1 class="admin-title">Gestion des utilisateurs</h1>

<section class="admin-section flex justify-center">
    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Crédits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id_user']) ?></td>
                    <td><?= htmlspecialchars($user['name_user'] . ' ' . $user['lastname_user']) ?></td>
                    <td><?= htmlspecialchars($user['email_user']) ?></td>
                    <td><?= $user['credit_user'] ?></td>
                    <td>
                        <a href="/admin/user_edit.php?id=<?= $user['id_user'] ?>" class="btn-link">Modifier</a>
                        <a href="/admin/user_delete.php?id=<?= $user['id_user'] ?>" class="btn-link">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once ROOTPATH . '/src/Templates/footer.php'; ?>
