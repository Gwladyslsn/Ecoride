<?php

namespace App\Controller;

use App\Entity\Auth;
use App\Controller\AdminController;
use App\Security\CsrfManager;

$csrf = new CsrfManager();


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

    public function contactUser()
    {
        $this->render('Templates/page/contact', []);
    }

    public function addReviewEcoride()
    {
        $this->render('/Entity/addReviewEcoride', []);
    }

    public function createAdmin()
    {
        $this->render('/Entity/createAdmin', []);
    }
    public function reviewEcoride()
    {
        $this->render('/Templates/page/reviewEcoride', []);
    }
    

    

    

    

    

    
    
    
    
}
