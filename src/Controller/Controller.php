<?php

namespace App\Controller;

abstract class Controller
{
    protected function render(string $template, array $data = []): void
    {
        extract($data);
        require_once ROOTPATH .'src/' . $template . '.php';
    }

    // --- AJOUT CSRF ---
    protected function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function checkCsrfToken(?string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
