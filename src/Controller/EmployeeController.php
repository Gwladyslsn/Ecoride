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

        $name_employee     = $data['name_employee'] ?? null;
        $lastname_employee = $data['lastname_employee'] ?? null;
        $email_employee    = $data['email_employee'] ?? null;
        $tel_employee      = $data['tel_employee'] ?? null;
        $password_employee = $data['password_employee'] ?? null;
        $dateHire_employee = $data['dateHire_employee'] ?? null;
        $id_role           = 5; // Rôle par défaut pour un employé

        $dataEmployee = [
            'name_employee'     => $name_employee,
            'lastname_employee' => $lastname_employee,
            'email_employee'    => $email_employee,
            'tel_employee'    => $tel_employee,
            'password_employee' => $password_employee,
            'dateHire_employee' => new \DateTime($dateHire_employee),
            'id_role'           => $id_role
        ];

        try {
            $success = $this->employeeRepository->newEmployee($dataEmployee);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Employé ajouté avec succès']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'employé']);
            }
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Exception : ' . $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString()
            ]);
        }
    }

    public function dashboardEmployees():void
    {
        $pdo = (new Database())->getConnection();
        $tripReviewRepo = new \App\Repository\TripReviewRepository($pdo);

        $reviewsPending = $tripReviewRepo->getTripsPending();
        $nbTripsPending = count($reviewsPending);
        $noteAverage = $tripReviewRepo->getNoteAverage();
        $reviews = $tripReviewRepo->getDataNewReviews();
        $totalReviews = count($reviews);

        require_once ROOTPATH . '/src/Templates/page/employee/dashboardEmployee.php';
    }
}
