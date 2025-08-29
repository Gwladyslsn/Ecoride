<?php

namespace App\Controller;


use App\Repository\EmployeeRepository;
use App\Database\Database;

class EmployeeController
{
    private EmployeeRepository $employeeRepository;

    public function __construct()
    {
        $pdo = (new Database())->getConnection();
        $this->employeeRepository = new  EmployeeRepository($pdo);
    }

    public function addNewEmployee()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            echo json_encode(['status' => 'error', 'message' => 'administrateur non connecté']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
            exit;
        }
    }
}
