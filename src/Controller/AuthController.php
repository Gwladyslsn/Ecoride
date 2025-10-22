<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\Auth;
use App\Security\CsrfManager;

class AuthController
{
    public function __construct(private UserRepository $userRepo, private CsrfManager $csrf)
    {
        Auth::startSession();
    }

    /**
     * Méthode principale appelée quand un formulaire est soumis
     */
    public function handleForm(array $post): void
    {
        $formType = $post['form_type'] ?? '';
        $token = $post['_csrf'] ?? '';

        // Vérification du token CSRF (lié à un formId spécifique)
        if (!$this->csrf->validate($token, $formType . '_form')) {
            echo "❌ Token CSRF invalide ou expiré. Veuillez réessayer.";
            exit;
        }

        // Redirige vers la méthode appropriée
        if ($formType === 'login') {
            $this->processLogin($post);
            
        } elseif ($formType === 'register') {
            $this->processRegister($post);
        } else {
            echo "❌ Type de formulaire inconnu.";
            exit;
        }
    }

    /**
     * Connexion d’un utilisateur, d’un employé ou d’un admin
     */
    public function processLogin(array $post): void
    {

        $email = trim($post['email_user'] ?? '');
        $password = trim($post['password_user'] ?? '');

        // --- admin
        $admin = $this->userRepo->getAdminByEmail($email);
        if ($admin && password_verify($password, $admin['password_admin'])) {
            $_SESSION['admin'] = [
                'id_admin' => $admin['id_admin'],
                'email_admin' => $admin['email_admin'],
                'name_admin' => $admin['name_admin']
            ];
            header('Location: dashboardAdmin');
            exit;
        }

        // --- employé
        $employee = $this->userRepo->getEmployeeByEmail($email);
        if ($employee && password_verify($password, $employee['password_employee'])) {
            $_SESSION['employee'] = $employee;
            header('Location: dashboardEmployee');
            exit;
        }

        // --- utilisateur
        $id_user = $this->userRepo->verifUserExists($email, $password);
        if ($id_user !== false) {
            $_SESSION['user'] = $id_user;
            header('Location: dashboardUser');
            exit;
        }
        
        echo "❌ Identifiants ou mot de passe incorrects.";
    }

    /**
     * Inscription d’un nouvel utilisateur
     */
    public function processRegister(array $post): void
    {
        $name_user = trim($post["name_user"] ?? '');
        $lastname_user = trim($post["lastname_user"] ?? '');
        $email_user = trim($post["email_user"] ?? '');
        $password_user = trim($post["password_user"] ?? '');
        $id_role = $post["id_role"] ?? '';
        $credit_user = 20;

        $errors = $this->userRepo->verifyUserInput($post);

        if (!empty($errors)) {
            echo "❌ " . implode('<br>', $errors);
            return;
        }

        if ($this->userRepo->emailExists($email_user)) {
            echo "⚠️ Un compte avec cette adresse existe déjà.";
            return;
        }

        if ($this->userRepo->addUser($name_user, $lastname_user, $email_user, $password_user, $id_role, $credit_user)) {
            echo "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            echo "❌ Erreur lors de l'inscription.";
        }
    }
}
