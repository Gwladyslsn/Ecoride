<?php
require_once ROOTPATH . '/src/Templates/header.php';

use App\Repository\AdminRepository;
use App\Database\Database;

if (!isset($_SESSION['admin'])) {
    header('Location: /register');
    exit;
}

$pdo = (new Database())->getConnection();
$adminRepo = new AdminRepository($pdo);
$carpoolings = $adminRepo->getCarpoolingsWithBookingStats();
?>

<h1 class="admin-title">Gestion des trajets</h1>

<section class="admin-section flex justify-center">
    <table class="table-admin">
        <thead>
            <tr>
                <th>Id trajet</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date départ</th>
                <th>Date arrivée</th>
                <th>Places disponibles</th>
                <th>Places reservées</th>
                <th>Prix</th>
                <th>Conducteur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carpoolings as $carpooling): ?>
                <tr>
                    <td><?= htmlspecialchars($carpooling['id_carpooling']) ?></td>
                    <td><?= htmlspecialchars($carpooling['departure_city']) ?></td>
                    <td><?= htmlspecialchars($carpooling['arrival_city']) ?></td>
                    <td><?= htmlspecialchars($carpooling['departure_date']) ?> à <?= htmlspecialchars($carpooling['departure_hour']) ?></td>
                    <td><?= htmlspecialchars($carpooling['arrival_date']) ?> à <?= htmlspecialchars($carpooling['arrival_hour']) ?></td>
                    <td><?= htmlspecialchars($carpooling['nb_place']) ?></td>
                    <td><?= htmlspecialchars($carpooling['booked_seats']) ?></td>
                    <td><?= htmlspecialchars($carpooling['price_place']) ?> crédits</td>
                    <td><?= htmlspecialchars($carpooling['driver_id']) ?></td>
                    <td>
                        <a href="/admin/carpooling_edit.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Modifier</a>
                        <a href="/admin/carpooling_delete.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once ROOTPATH . '/src/Templates/footer.php'; ?>
