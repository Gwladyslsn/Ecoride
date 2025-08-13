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

<h1 class="page-title">Gestion des trajets</h1>

<div class="main-content p-8">

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"></div>
            <div class="stat-label">Covoiturages en cours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"></div>
            <div class="stat-label">Covoiturage passés</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"></div>
            <div class="stat-label">Total covoiturage</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"></div>
            <div class="stat-label">Total réservation</div>
        </div>
    </div>

    <section class="admin-section p-8">
        <div class="table-admin-container">
            <table class="table-admin mx-auto">
                <thead>
                    <tr>
                        <th>Id trajet</th>
                        <th>Trajet Eco</th>
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

                            <td>
                                <? if ($carpooling['is_ecologic']): ?>
                                    <i class="fa-brands fa-envira"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-ban"></i>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($carpooling['departure_city']) ?></td>
                            <td><?= htmlspecialchars($carpooling['arrival_city']) ?></td>
                            <td><?= htmlspecialchars($carpooling['departure_date']) ?> à <?= htmlspecialchars($carpooling['departure_hour']) ?></td>
                            <td><?= htmlspecialchars($carpooling['arrival_date']) ?> à <?= htmlspecialchars($carpooling['arrival_hour']) ?></td>
                            <td><?= htmlspecialchars($carpooling['nb_place']) ?></td>
                            <td><?= htmlspecialchars($carpooling['booked_seats']) ?></td>
                            <td><?= htmlspecialchars($carpooling['price_place']) ?> <i class="fa-brands fa-pagelines"></td>
                            <td><?= htmlspecialchars($carpooling['driver_id']) ?></td>
                            <td>
                                <a href="/admin/carpooling_edit.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Modifier</a>
                                <a href="/admin/carpooling_delete.php?id=<?= $carpooling['id_carpooling'] ?>" class="btn-link">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </div>
        </table>
    </section>
</div>

<?php require_once ROOTPATH . '/src/Templates/footer.php'; ?>