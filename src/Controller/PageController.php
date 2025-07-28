<?php

namespace App\Controller;

class PageController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action']) ?? 'home') {
                switch ($_GET['action']) {
                    case 'home':
                        $this->home();
                        break;
                    case 'register':
                        $this->register();
                        break;
                    case 'contact':
                        $this->contact();
                        break;
                    case 'about':
                        $this->about();
                        break;
                    case 'mentions':
                        $this->mentions();
                        break;
                    case 'dashboardUser':
                        $this->dashboardUser();
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                    case 'history':
                        $this->history();
                        break;
                    case 'updateUser':
                        $this->updateUser();
                        break;
                    case 'updateCar':
                        $this->updateCar();
                        break;
                    case 'addCarpooling':
                        $this->addCarpooling();
                        break;
                    case 'searchCarpooling':
                        $this->searchCarpooling();
                        break;
                    case 'newCarpooling':
                        $this->newCarpooling();
                        break;
                    case 'searchTripAPI':
                        $this->searchTripAPI();
                        break;
                    case 'contactUser':
                        $this->contactUser();
                        break;
                    case 'reviewEcoride':
                        $this->reviewEcoride();
                        break;
                    case 'addReviewEcoride':
                        $this->addReviewEcoride();
                        break;
                    case 'createAdmin':
                        $this->createAdmin();
                        break;
                    case 'homeAdmin':
                        $this->homeAdmin();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : ".$_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action detectée");
            }
        } catch (\Exception $e) {
            $this->render('/errors/default', [
            'error' => $e->getMessage()
        ]);
        }
    }

    protected function home()
    {
        require_once ROOTPATH . 'vendor/autoload.php';

    $repo = new \Entity\ReviewRepository();
    $reviews = $repo->getAllReviews();

    $this->render('Templates/page/home', [
        'reviews' => $reviews
    ]);
    }

    protected function register()
    {
        $this->render('Templates/page/register', []);
    }

    protected function contact()
    {
        $this->render('/Templates/page/contact', []);
    }

    protected function about()
    {
        $this->render('/Templates/page/about', []);
    }

    protected function mentions()
    {
        $this->render('/Templates/page/mentions', []);
    }

    protected function dashboardUser()
    {
        $this->render('/Templates/page/dashboardUser', []);
    }

    protected function logout()
    {
        $this->render('/Templates/logout', []);
    }

    protected function history()
    {
        $this->render('/Templates/page/history', []);
    }

    protected function updateUser()
    {
        $this->render('/Entity/updateUser', []);
    }

    protected function updateCar()
    {
        $this->render('/Entity/updateCar', []);
    }

    protected function addCarpooling()
    {
        $this->render('/Templates/page/addCarpooling', []);
    }

    protected function searchCarpooling()
    {
        $this->render('/Templates/page/searchCarpooling', []);
    }

    protected function newCarpooling()
    {
        $this->render('/Entity/newCarpooling', []);
    }

    protected function searchTripAPI()
    {
        $this->render('/Entity/searchTripAPI', []);
    }

    protected function contactUser()
    {
        $this->render('/Entity/contactUser', []);
    }

    protected function reviewEcoride()
    {
        $this->render('/Templates/page/reviewEcoride', []);
    }

    protected function addReviewEcoride()
    {
        $this->render('/Entity/addReviewEcoride', []);
    }

    protected function createAdmin()
    {
        $this->render('/Entity/createAdmin', []);
    }

    protected function homeAdmin()
    {
        $this->render('/Templates/page/admin/homeAdmin', []);
    }
}





