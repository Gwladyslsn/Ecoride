<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Database\Database;
use App\Repository\TripReviewRepository;
use App\Repository\EmployeeRepository;

class AdminController extends Controller
{
    private AdminRepository $adminRepository;
    private TripReviewRepository $tripReviewRepo;
    private EmployeeRepository $employeeRepo;

    public function __construct()
    {
        $db = new Database();
        $this->adminRepository = new AdminRepository($db->getConnection());
        $this->tripReviewRepo = new TripReviewRepository($db->getConnection());
        $this->employeeRepo = new EmployeeRepository($db->getConnection());
    }


    public function dashboardAdmin(): void
    {
        $adminController = new AdminController();
        $data = $adminController->getDashboardData();

        $this->render("Templates/page/admin/dashboardAdmin", $data);
    }

    public function userAdmin()
    {
        $this->render('Templates/page/admin/userAdmin', []);
    }

    public function carpoolingAdmin()
    {
        $this->render('Templates/page/admin/carpoolingAdmin', []);
    }
    public function employeAdmin()
    {
        $adminController = new AdminController();
        $data = $adminController->EmployeeAdminDashboard();

        $this->render('Templates/page/admin/employeAdmin', [$data]);
    }
    public function getDashboardData(): array
    {
        $totalUsers = $this->adminRepository->countUsers();
        $totalCarpoolings = $this->adminRepository->countCarpoolings();
        $allReviewProcessed = $this->tripReviewRepo->getReviewsProcessed();
        $nbReviewProcessed = count($allReviewProcessed);

        return [
            'totalUsers' => $totalUsers,
            'totalCarpoolings' => $totalCarpoolings,
            'nbReviewProcessed' => $nbReviewProcessed
        ];
    }

    public function employeeAdminDashboard()
    {
        $pdo = (new Database())->getConnection();
        $tripReviewRepo = new TripReviewRepository($pdo);

        $reviewsPending = $tripReviewRepo->getReviewsPending();
        $nbReviewPending = count($reviewsPending);
        $reviewsAccept = $tripReviewRepo->getReviewsAccept();
        $nbTripsAccept = count($reviewsAccept);
        $newReviews = $tripReviewRepo->getDataNewReviews();
        $allReviews = $tripReviewRepo->getAllTripReviews();
        $totalReviews = count($allReviews);
        $allReviewProcessed = $tripReviewRepo->getReviewsProcessed();
        $nbReviewProcessed = count($allReviewProcessed);
        $processedReviews = $tripReviewRepo->getDataOldReviews();
        $employeeRepo = new EmployeeRepository($pdo);
        $employees = $employeeRepo->getAllEmployees();
        $totalEmployees = count($employees);

        require_once ROOTPATH . 'src/Templates/page/admin/employeAdmin.php';
    }

    public function addEmployee()
    {
        $this->render('Templates/page/admin/addEmployee', []);
    }

    public function addNewEmployee()
    {
        $this->render('Templates/page/admin/addEmployee', []);
    }
}
