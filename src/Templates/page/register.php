<?php

use App\Repository\UserRepository;
use App\Database\Database;

$database = new Database();
$pdo = $database->getConnection();

$userRepo = new UserRepository($pdo);

use App\Entity\Auth;
$auth = new Auth();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'log') {
        $email = $_POST["email_user"] ?? '';
        $password = $_POST["password_user"] ?? '';

        // 1. Tentative connexion admin
        $admin = $userRepo->getAdminByEmail($email);
        if ($admin && password_verify($password, $admin['password_admin'])) {
            $_SESSION['admin'] = [
                'id_admin' => $admin['id_admin'],
                'email_admin' => $admin['email_admin'],
                'name_admin' => $admin['name_admin']
            ];
            header('Location: dashboardAdmin');
            exit;
        }

        // 2. Sinon tentative connexion utilisateur
        $id_user = $userRepo->verifUserExists($email, $password);
        if ($id_user !== false) {
            $_SESSION['user'] = $id_user;
            header('Location: http://localhost:8000/dashboardUser');
            exit;
        } else {
            echo "Identifiants et/ou mot de passe incorrect(s).";
        }
    } elseif ($formType === 'sign') {
        $name_user = $_POST["name_user"] ?? '';
        $lastname_user = $_POST["lastname_user"] ?? '';
        $email_user = $_POST["email_user"] ?? '';
        $password_user = $_POST["password_user"] ?? '';
        $id_role = $_POST["id_role"] ?? '';
        $credit_user = 20;

        $errors = $userRepo->verifyUserInput($_POST);

        if (empty($errors)) {
            if ($userRepo->emailExists($email_user)) {
                echo '<div class="alert alert-success">
                        <p class="text-white bg-gray-900 body-font">Un compte avec cette adresse email existe déjà. Veuillez vous connecter ou utiliser une autre adresse.</p>
                        </div>';
            } else {
                if ($userRepo->addUser($name_user, $lastname_user, $email_user, $password_user, $id_role, $credit_user)) {
                    echo '<div class="alert alert-success">
                            <p class="text-gray-400 bg-gray-900 body-font">✅ Inscription réussie ! Vous pouvez maintenant vous connecter !</p>
                            </div>';
                } else {
                    $errors[] = "Une erreur est survenue";
                }
            }
        }
    }
}

require_once ROOTPATH . '/src/Templates/header.php';
?>




<section class="text-gray-600 body-font pt-20 flex justify-center sectionLog">

    <form method="post" id="form_log" class="container containerLog">
        <input type="hidden" name="form_type" value="log">
        <div class="lg:w-5/6 md:w-2/2 form rounded-lg p-10 flex flex-col mt-10 md:mt-0">
            <h2 class="text-gray-900 text-lg font-medium title-font text-center mb-5">Connexion</h2>
            <div id="feedbackLogin"></div>
            <div class="relative mb-4">
                <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                <input type="email" id="email_log" name="email_user" class="w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
                <label for="password_user" class="leading-7 text-sm text-gray-600">Mot de passe</label>
                <input type="password" id="password_log" name="password_user" class="w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <button type="button" class="password-show1 absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 mt-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>

                <button type="button" class="password-hide1 absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <button id="btn_log" class="text-white btn-register border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">Se connecter</button>
        </div>
    </form>


    <div class="divider divider-horizontal">OU</div>


    <form method="post" id="form_sign" class="container containerLog form_sign">
        <input type="hidden" name="form_type" value="sign">
        <div class="lg:w-5/6 md:w-2/2 form rounded-lg p-10 flex flex-col mt-10 md:mt-0">
            <h2 class="text-gray-900 text-lg font-medium title-font text-center mb-5">Inscription</h2>
            <div id="feedbackSign"></div>
            <div class="relative mb-4">
                <label for="name_user" class="leading-7 text-sm text-gray-600">Prénom</label>
                <input type="text" id="name_user_sign" name="name_user" class="w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
                <label for="lastname_user	" class="leading-7 text-sm text-gray-600">Nom</label>
                <input type="text" id="lastname_user_sign" name="lastname_user" class="w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
                <label for="email_user" class="leading-7 text-sm text-gray-600">Email</label>
                <input type="email" id="email_sign" name="email_user" class="w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4 field-password">
                <label for="password_user" class="leading-7 text-sm text-gray-600">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="password_sign" name="password_user" class="password w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 pr-10 leading-8 transition-colors duration-200 ease-in-out">
                    <button type="button" class="password-show2 absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>

                    <button type="button" class="password-hide2 absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative mb-4">
                <label for="password_user" class="leading-7 text-sm text-gray-600">Confirmation de mot de passe</label>
                <input type="password" id="password_sign_check" class="password w-full bg-white rounded border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <button type="button" class="password-show3 absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>

                <button type="button" class="password-hide3 absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <div class="relative mb-4">
                <label for="role" class="leading-7 text-sm text-gray-600">Vous êtes : </label>
                <select id="role" name="id_role" class="bg-white">
                    <option value="">--Choirsir un rôle--</option>
                    <option value="1">Chauffeur</option>
                    <option value="2">Passager</option>
                    <option value="3">Chauffeur-Passager</option>
                </select>
            </div>
            <button id="btn_sign" class="text-white btn-register border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">S'inscrire</button>
        </div>
    </form>
</section>

<?php
$page_script = '/asset/js/register.js';

require_once ROOTPATH . '/src/Templates/footer.php'; ?>