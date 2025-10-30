<?php
require_once ROOTPATH . 'src/Entity/auth.php';
require_once ROOTPATH . 'config/config.php';


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/asset/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta description="Voyagez, partagez grâce à l'écologie">
    <?php if (isset($csrfToken)): ?>
        <meta name="csrf-token" content="<?= htmlspecialchars($csrfToken) ?>">
    <?php endif; ?>
    <title>Ecoride</title>
</head>

<body>
    <div class="navbar">
        <div class="navbar-start">
            <a href="<?= BASE_URL ?>">
                <img src="/asset/image/logoEcoride.png" alt="Logo Ecoride" class="rounded-full logo">
            </a>
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn lg:hidden btn-header">
                    Menu
                </div>
                <ul class="menu menu-sm dropdown-content rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li>
                        <a href="<?= BASE_URL ?>Carpoolings" class="text-lg ">Covoiturages</a>
                    </li>
                    <li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>history" class="text-lg">Historique</a>
                        <?php elseif (isset($_SESSION['admin'])): ?>
                            <a href="<?= BASE_URL ?>dashboardAdmin" class="text-lg">Dashboard</a>
                        <?php elseif (isset($_SESSION['employee'])): ?>
                            <a href="<?= BASE_URL ?>dashboardEmployee" class="text-lg">Dashboard</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>about" class="text-lg">A propos</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>dashboardUser" class="text-lg ">Mon espace</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>about" class="text-lg hidden ">A propos</a>
                        <?php endif; ?>
                    </li>
                    <li><a href="<?= BASE_URL ?>contact" class="text-lg ">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 justify-around">
                <li>
                    <a href="<?= BASE_URL ?>Carpoolings" class="text-lg">Covoiturages</a>
                </li>
                <li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?= BASE_URL ?>history" class="text-lg">Historique</a>
                    <?php elseif (isset($_SESSION['admin'])): ?>
                        <a href="<?= BASE_URL ?>dashboardAdmin" class="text-lg">Dashboard</a>
                    <?php elseif (isset($_SESSION['employee'])): ?>
                        <a href="<?= BASE_URL ?>dashboardEmployee" class="text-lg">Dashboard</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>about" class="text-lg">A propos</a>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?= BASE_URL ?>dashboardUser" class="text-lg ">Mon espace</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>about" class="text-lg hidden ">A propos</a>
                    <?php endif; ?>
                </li>
                <li><a href="<?= BASE_URL ?>contact" class="text-lg ">Contact</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            <?php if (isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['employee'])): ?>
                <a href="<?= BASE_URL ?>logout" class="btn btn-header btn-desktop">Déconnexion</a>
                <a href="<?= BASE_URL ?>logout" class="icon-header btn-mobile" aria-label="Déconnexion">
                    <i class="fa-solid fa-power-off" style="color: #d60303ff;"></i>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>register" class="btn btn-header btn-desktop">Connexion / Inscription</a>
                <a href="<?= BASE_URL ?>register" class="icon-header btn-mobile" aria-label="Connexion / Inscription">
                    <i class="fa-solid fa-power-off"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>