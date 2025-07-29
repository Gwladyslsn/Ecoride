<?php
namespace App\Database;

use PDO;
use Exception;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $jawsdb_url = getenv('JAWSDB_URL');

            if ($jawsdb_url) {
                $url = parse_url($jawsdb_url);

                $db_host = $url['host'];
                $db_user = $url['user'];
                $db_password = $url['pass'];
                $db_name = ltrim($url['path'], '/');
                $db_port = $url['port'] ?? 3306;

                $this->pdo = new PDO(
                    "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
                    $db_user,
                    $db_password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } else {
                $db_host = getenv('db_host');
                $db_user = getenv('db_user');
                $db_password = getenv('db_password');
                $db_name = getenv('db_name');
                $db_port = getenv('db_port') ?: 3306;

                if ($db_host && $db_user && $db_password && $db_name) {
                    $this->pdo = new PDO(
                        "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
                        $db_user,
                        $db_password,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        ]
                    );
                } else {
                    $config = parse_ini_file(ROOTPATH . ".env");

                    $this->pdo = new PDO(
                        "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                        $config['db_user'],
                        $config['db_password'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        ]
                    );
                }
            }
        } catch (Exception $e) {
            if (getenv('JAWSDB_URL')) {
                error_log('Erreur de connexion BDD: ' . $e->getMessage());
                die('Erreur de connexion à la base de données');
            } else {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
