<?php 

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Database\Database;

class AdminController
{
    private AdminRepository $adminRepository;

    public function __construct()
    {
        $db = new Database();
        $this->adminRepository = new AdminRepository($db->getConnection());
    }

    public function getDashboardData(): array
    {
        $totalUsers = $this->adminRepository->countUsers();
        $totalCarpoolings = $this->adminRepository->countCarpoolings();

        return [
            'totalUsers' => $totalUsers,
            'totalCarpoolings' => $totalCarpoolings
        ];
    }
}