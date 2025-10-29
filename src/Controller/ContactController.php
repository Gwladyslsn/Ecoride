<?php

namespace App\Controller;

use App\Services\MailService;

class ContactController extends Controller
{
    public function send()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $mailService = new MailService();
        $result = $mailService->sendContactMail($data);

        if ($result === true) {
            http_response_code(200);
            echo "Votre message a bien été envoyé. Merci !";
        } else {
            http_response_code(400);
            echo $result;
        }
    }
}
