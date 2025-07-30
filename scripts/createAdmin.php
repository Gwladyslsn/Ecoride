<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Database\Database;

if (php_sapi_name() !== 'cli') {
    exit("Ce script ne peut être exécuté que via la ligne de commande.\n");
}

function createAdmin()
{

    $database = new Database();
    $pdo = $database->getConnection();
    $hashedPassword = password_hash('mdp2jose', PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (name_admin, lastname_admin, email_admin, password_admin, id_role)
            VALUES (:name, :lastname, :email, :password, :role)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => 'José',
        ':lastname' => 'jojo',
        ':email' => 'jose@email.com',
        ':password' => $hashedPassword,
        ':role' => 4
    ]);

    echo "Admin créé avec succès.";
}


createAdmin();





