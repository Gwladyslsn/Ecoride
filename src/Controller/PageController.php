<?php

namespace App\Controller;

use App\Entity\Auth;
use App\Controller\AdminController;


class PageController extends Controller
{
    public function home()
    {
        $this->render('Templates/page/home', []);
    }

    public function register()
    {
        $this->render('Templates/page/register', []);
    }

    public function contact()
    {
        $this->render('/Templates/page/contact', []);
    }

    public function about()
    {
        $this->render('/Templates/page/about', []);
    }

    public function mentions()
    {
        $this->render('Templates/page/mentions', []);
    }

    public function dashboardUser()
    {
        $this->render('/Templates/page/dashboardUser', []);
    }

    public function logout()
    {
        Auth::logout('/'); // appeler la fonction
    }

    public function history()
    {
        $this->render('/Templates/page/history', []);
    }

    public function updateUser()
    {
        $this->render('/Entity/updateUser', []);
    }

    public function updateCar()
    {
        $this->render('/Entity/updateCar', []);
    }

    public function addCarpooling()
    {
        $this->render('/Templates/page/addCarpooling', []);
    }

    public function Carpoolings()
    {
        $this->render('Templates/page/Carpoolings', []);
    }

    public function newCarpooling()
    {
        $controller = new CarpoolingController();
        $controller->newCarpooling();
    }

    public function contactUser()
    {
        $this->render('Templates/page/contact', []);
    }

    public function reviewEcoride()
    {
        $this->render('/Templates/page/reviewEcoride', []);
    }

    public function addReviewEcoride()
    {
        $this->render('/Entity/addReviewEcoride', []);
    }


    public function tripDetails()
    {
        $this->render('Templates/page/tripDetails', []);
    }

    public function bookTrip()
    {
        $this->render('Templates/page/tripDetails', []);
    }

    public function createAdmin()
    {
        $this->render('/Entity/createAdmin', []);
    }

    public function homeAdmin()
    {
        $this->render('/Templates/page/admin/homeAdmin', []);
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
        $this->render('Templates/page/admin/employeAdmin', []);
    }

    public function addEmployee()
    {
        $this->render('Templates/page/admin/addEmployee', []);
    }
    public function addNewEmployee()
    {
        $this->render('Templates/page/admin/addEmployee', []);
    }
    public function dashboardEmployee()
    {
        $this->render('Templates/page/employee/dashboardEmployee', []);
    }
    public function acceptReview()
    {
        $reviewController = new ReviewController();
        $reviewController->acceptReview();
        $this->render(
            template: 'Templates/page/employee/dashboardEmployee'
        );
    }
}
