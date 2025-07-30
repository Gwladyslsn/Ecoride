<?php

namespace App\Repository;

use PDO;
use PDOException;

class UserRepository
{
    private PDO $pdo;

    // Constructeur : on injecte la connexion PDO
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // --- CREATE ---
    // Add user
    public function addUser(string $name_user, string $lastname_user, string $email_user, string $password_user, string $id_role, int $credit_user): bool
    {
        $query = $this->pdo->prepare("
            INSERT INTO user (name_user, lastname_user, email_user, password_user, id_role, credit_user)
            VALUES (:name_user, :lastname_user, :email_user, :password_user, :id_role, :credit_user)
        ");

        $password = password_hash($password_user, PASSWORD_DEFAULT);

        $query->bindValue(':name_user', $name_user);
        $query->bindValue(':lastname_user', $lastname_user);
        $query->bindValue(':email_user', $email_user);
        $query->bindValue(':password_user', $password);
        $query->bindValue(':id_role', $id_role);
        $query->bindValue(':credit_user', $credit_user);

        return $query->execute();
    }

    // --- READ ---


    /* get user by id*/
    public function getDataUser(string $id_user): ?array
    {
        $sql = "SELECT * FROM user WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /* get role by id*/
    public function getRole(int $id_role): ?array
    {
        $sql = "SELECT name_role FROM role WHERE id_role = :id_role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_role' => $id_role]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        return $role ?: null;
    }

    /* get car by user*/
    public function getDataCar(string $id_user): ?array
    {
        $sql = "SELECT * FROM car WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        return $car ?: null;
    }

    /* check email*/
    public function emailExists(string $email_user): bool
    {
        $sql = "SELECT COUNT(*) FROM user WHERE email_user = :email_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email_user' => $email_user]);
        return $stmt->fetchColumn() > 0;
    }


    /* check and return id*/
    public function verifUserExists(string $email_user, string $password)
    {
        $sql = "SELECT id_user, password_user FROM user WHERE email_user = :email_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email_user' => $email_user]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_user'])) {
            return $user['id_user'];
        }
        return false;
    }

    /* get user by email*/
    public function getAdminByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM admin WHERE email_admin = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        return $admin ?: null;
    }

    // --- UPDATE ---

    /* update avatar user*/
    public function updateAvatar(int $userId, string $fileName): bool
    {
        $sql = "UPDATE user SET avatar_user = :avatar_user WHERE id_user = :idUser";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':avatar_user' => $fileName,
            ':idUser' => $userId,
        ]);
    }

    /* update data user*/
    public function updateUserInfo(int $userId, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $fields = [];
        $params = ['id_user' => $userId];

        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }

        $sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /* update data car*/
    public function updateCarInfo($userId, $brandCar, $modelCar, $yearCar, $energyCar)
    {
        // Vérifie d'abord si une voiture existe déjà pour cet utilisateur
        $sqlCheck = "SELECT id_car FROM car WHERE id_user = :userId";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtCheck->execute();

        $car = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($car) {
            // Une voiture existe → UPDATE
            $sql = "UPDATE car SET brand_car = :brandCar, model_car = :modelCar, year_car = :yearCar, energy_car = :energyCar";


            $sql .= " WHERE id_user = :userId";
            $stmt = $this->pdo->prepare($sql);
        } else {
            // Aucune voiture → INSERT
            $sql = "INSERT INTO car (id_user, brand_car, model_car, year_car, energy_car";
            $values = "VALUES (:userId, :brandCar, :modelCar, :yearCar, :energyCar";


            $sql .= ") " . $values . ")";
            $stmt = $this->pdo->prepare($sql);
        }

        // Paramètres communs
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':brandCar', $brandCar);
        $stmt->bindParam(':modelCar', $modelCar);
        $stmt->bindParam(':yearCar', $yearCar);
        $stmt->bindParam(':energyCar', $energyCar);

        return $stmt->execute();
    }

    public function updateCarImg(int $userId, string $fileName): bool
    {
        $sql = "UPDATE car SET photo_car = :photoCar WHERE id_user = :idUser";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':photoCar' => $fileName,
            ':idUser' => $userId,
        ]);
    }

    // --- DELETE ---

    /* delete user by id*/
    public function deleteUser(int $userId): bool
    {
        $sql = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_user' => $userId]);
    }

    /* delete car by user*/
    public function deleteCar(int $userId): bool
    {
        $sql = "DELETE FROM car WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_user' => $userId]);
    }

    // --- VALIDATION ---

    /* check input*/
    public function verifyUserInput(array $user): array
    {
        $errors = [];

        if (empty($user["name_user"])) {
            $errors["name_user"] = "Le champ Prénom ne doit pas être vide";
        }
        if (empty($user["lastname_user"])) {
            $errors["lastname_user"] = "Le champ Nom ne doit pas être vide";
        }
        if (empty($user["email_user"])) {
            $errors["email_user"] = "Le champ Email ne doit pas être vide";
        }
        if (empty($user["password_user"])) {
            $errors["password_user"] = "Le champ Mot de passe ne doit pas être vide";
        }
        if (empty($user["id_role"])) {
            $errors["id_role"] = "Le champ Rôle ne doit pas être vide";
        }

        return $errors;
    }
}
