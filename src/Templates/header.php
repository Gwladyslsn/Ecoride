<?php
require_once ROOTPATH . '/src/Entity/Auth.php';
require_once ROOTPATH . 'config/config.php';


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/asset/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <meta description="Voyagez, partagez grâce à l'écologie">
    <title>Eco'ride</title>
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
                        <?php  if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>history" class="text-lg">Historique</a>
                        <?php elseif(isset($_SESSION['admin'])): ?>
                            <a href="<?= BASE_URL ?>dashboardAdmin" class="text-lg">Dashboard</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>about" class="text-lg">A propos</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php  if (isset($_SESSION['user'])): ?>
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
                        <?php  if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>history" class="text-lg">Historique</a>
                            <?php elseif(isset($_SESSION['admin'])): ?>
                            <a href="<?= BASE_URL ?>dashboardAdmin" class="text-lg">Dashboard</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>about" class="text-lg">A propos</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php  if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>dashboardUser" class="text-lg ">Mon espace</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>about" class="text-lg hidden ">A propos</a>
                        <?php endif; ?>
                    </li>
                    <li><a href="<?= BASE_URL ?>contact" class="text-lg ">Contact</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            <?php  if (isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
                <a href="<?= BASE_URL ?>logout" class="btn btn-header">Déconnexion</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>register" class="btn btn-header">Connexion / Inscription</a>
            <?php endif; ?>
        </div>
    </div>
