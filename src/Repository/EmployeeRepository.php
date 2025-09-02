<?php

namespace App\Repository;

use PDO;

class EmployeeRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // CREATE
    public function newEmployee(array $employeeData): bool
    {
        try {
            $sql = "INSERT INTO employee (name_employee, lastname_employee, email_employee, tel_employee, password_employee, dateHire_employee, id_role) 
        VALUES (:name_employee, :lastname_employee, :email_employee, :tel_employee, :password_employee, :dateHire_employee, :id_role)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'name_employee'     => $employeeData['name_employee'],
                'lastname_employee' => $employeeData['lastname_employee'],
                'email_employee'    => $employeeData['email_employee'],
                'tel_employee'      => $employeeData['tel_employee'],
                'password_employee' => password_hash($employeeData['password_employee'], PASSWORD_BCRYPT),
                'dateHire_employee' => $employeeData['dateHire_employee']->format('Y-m-d'),
                'id_role'           => $employeeData['id_role']
            ]);
        } catch (\Throwable $e) {
            // Log ou rethrow pour que ton contrôleur capture l'erreur
            throw $e;
        }
    }

    public function getAllEmployees():array
    {
        $sql = "SELECT * FROM employee ORDER BY id_employee";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
