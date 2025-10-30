<?php

use App\Database\Database;
use App\Repository\UserRepository;
use App\Controller\AuthController;
use App\Entity\Auth;
use App\Security\CsrfManager;



$database = new Database();
$pdo = $database->getConnection();
$userRepo = new UserRepository($pdo);

$csrf = new CsrfManager();

//var_dump('Token login_form : ', $csrf->getToken('login_form'));
//var_dump('Token register_form : ', $csrf->getToken('register_form'));
//var_dump('_SESSION après génération tokens : ', $_SESSION['_csrf_tokens']);


$authController = new AuthController($userRepo, $csrf);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->handleForm($_POST);
}

require_once ROOTPATH . '/src/Templates/header.php';

?>



<section class="flex justify-center mt-25 mb-10">
<div class="section-log">
        <!-- Formulaire Connexion -->
        <form method="post" action="/auth-form" id="login" class="form-container">
            <?= $csrf->getField('login_form'); ?>
            <input type="hidden" name="form_type" value="login">
            
            <h2 class="form-title">Bienvenue</h2>
            <p class="form-subtitle">Connectez-vous à votre compte</p>
            <div id="feedbackLogin" class="feedback"></div>

            <div class="form-group">
                <label for="email_log">Email</label>
                <input type="email" id="email_log" name="email_user" placeholder="vous@exemple.com" required>
            </div>

            <div class="form-group">
                <label for="password_log">Mot de passe</label>
                <div class="password-field">
                    <input type="password" id="password_log" name="password_user" placeholder="" required>
                    <button type="button" class="password-toggle password-show1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <button type="button" class="password-toggle password-hide1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" id="btn_log" class="btn-submit">Se connecter</button>
        </form>

        <div class="divider divider-horizontal">OU</div>

        <!-- Formulaire Inscription -->
        <form method="post" action="/auth-form" id="register" class="form-container">
            <?= $csrf->getField('register_form'); ?>
            <input type="hidden" name="form_type" value="register">
            
            <h2 class="form-title">S'inscrire</h2>
            <p class="form-subtitle">Créez votre compte gratuitement</p>
            <div id="feedbackSign" class="feedback"></div>

            <div class="form-group row">
                <div>
                    <label for="name_user_sign">Prénom</label>
                    <input type="text" id="name_user_sign" name="name_user" placeholder="Jean" required>
                </div>
                <div>
                    <label for="lastname_user_sign">Nom</label>
                    <input type="text" id="lastname_user_sign" name="lastname_user" placeholder="Dupont" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email_sign">Email</label>
                <input type="email" id="email_sign" name="email_user" placeholder="vous@exemple.com" required>
            </div>

            <div class="form-group">
                <label for="password_sign">Mot de passe</label>
                <div class="password-field">
                    <input type="password" id="password_sign" name="password_user" placeholder="" required>
                    <button type="button" class="password-toggle password-show2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <button type="button" class="password-toggle password-hide2 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_sign_check">Confirmation du mot de passe</label>
                <div class="password-field">
                    <input type="password" id="password_sign_check" placeholder="" required>
                    <button type="button" class="password-toggle password-show3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <button type="button" class="password-toggle password-hide3 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="role">Vous êtes</label>
                <select id="role" name="id_role" required>
                    <option value="">-- Choisir un rôle --</option>
                    <option value="1">Chauffeur</option>
                    <option value="2">Passager</option>
                    <option value="3">Chauffeur-Passager</option>
                </select>
            </div>

            <button type="submit" id="btn_sign" class="btn-submit">S'inscrire</button>
        </form>
    </div>
    </section>

<?php
$page_script = '/asset/js/register.js';

require_once ROOTPATH . '/src/Templates/footer.php'; ?>