<?php

namespace App\Controller;

use App\Entity\ReviewRepository;

class PageController extends Controller
{
    public function home()
    {
        $reviewRepository = new ReviewRepository();
        $reviews = $reviewRepository->getAllReviews();
        $groupedReviews = array_chunk($reviews, 2);

        $this->render('src/Templates/page/home', [
            'groupedReviews' => $groupedReviews
        ]);
    }

    public function register()
    {
        $this->render('src/Templates/page/register', []);
    }

    public function contact()
    {
        $this->render('src/Templates/page/contact', []);
    }

    public function about()
    {
        $this->render('src/Templates/page/about', []);
    }

    public function mentions()
    {
        $this->render('src/Templates/page/mentions', []);
    }

    public function dashboardUser()
    {
        $this->render('src/Templates/page/dashboardUser', []);
    }

    public function logout()
    {
        $this->render('src/Templates/logout', []);
    }

    public function history()
    {
        $this->render('src/Templates/page/history', []);
    }

    public function updateUser()
    {
        $this->render('src/Entity/updateUser', []);
    }

    public function updateCar()
    {
        $this->render('src/Entity/updateCar', []);
    }

    public function addCarpooling()
    {
        $this->render('src/Templates/page/addCarpooling', []);
    }

    public function searchCarpooling()
    {
        $this->render('src/Templates/page/searchCarpooling', []);
    }

    public function newCarpooling()
    {
        $this->render('src/Entity/newCarpooling', []);
    }

    public function searchTripAPI()
    {
        $this->render('src/Entity/searchTripAPI', []);
    }

    public function contactUser()
    {
        $this->render('src/Entity/contactUser', []);
    }

    public function reviewEcoride()
    {
        $this->render('src/Templates/page/reviewEcoride', []);
    }

    public function addReviewEcoride()
    {
        $this->render('src/Entity/addReviewEcoride', []);
    }

    public function createAdmin()
    {
        $this->render('src/Entity/createAdmin', []);
    }

    public function homeAdmin()
    {
        $this->render('src/Templates/page/admin/homeAdmin', []);
    }
}
