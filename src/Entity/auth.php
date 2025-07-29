<?php
namespace App\Entity;

class Auth
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function ifLog(string $redirectTo = 'dashboardUser'): void
    {
        self::startSession();
        if (isset($_SESSION['user'])) {
            header("Location: $redirectTo");
            exit();
        }
    }

    public static function ifNotLog(string $redirectTo = 'register'): void
    {
        self::startSession();
        if (!isset($_SESSION['user'])) {
            header("Location: $redirectTo");
            exit();
        }
    }

    public static function logout(string $redirectTo = ''): void
    {
        self::startSession();
        session_unset();
        session_destroy();
        header("Location: $redirectTo");
        exit();
    }
}
