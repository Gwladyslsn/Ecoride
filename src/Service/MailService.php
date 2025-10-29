<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'contact2ecoride@gmail.com';
        $this->mail->Password   = 'xqopughorogfulvq';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
    }

    public function sendContactMail(array $data): bool|string
    {
        try {
            $lastname = htmlspecialchars(trim($data['lastnameContact'] ?? ''));
            $name = htmlspecialchars(trim($data['nameContact'] ?? ''));
            $email = filter_var(trim($data['emailContact'] ?? ''), FILTER_SANITIZE_EMAIL);
            $phone = htmlspecialchars(trim($data['phoneContact'] ?? ''));
            $subject = htmlspecialchars(trim($data['subjectContact'] ?? ''));
            $message = nl2br(htmlspecialchars(trim($data['messageContact'] ?? '')));

            if (!$lastname || !$name || !$email || !$phone || !$subject || !$message) {
                return "Certains champs sont manquants ou invalides.";
            }

            // Envoi vers Ecoride
            $this->mail->setFrom('contact2ecoride@gmail.com', 'Formulaire Ecoride');
            $this->mail->addAddress('contact2ecoride@gmail.com', 'Support Ecoride');
            $this->mail->isHTML(true);
            $this->mail->Subject = "Nouveau message de contact : {$subject}";
            $this->mail->Body = "
                <h2>Nouveau message via le formulaire Ecoride</h2>
                <p><strong>Nom :</strong> {$lastname}</p>
                <p><strong>Prénom :</strong> {$name}</p>
                <p><strong>Email :</strong> {$email}</p>
                <p><strong>Téléphone :</strong> {$phone}</p>
                <p><strong>Sujet :</strong> {$subject}</p>
                <p><strong>Message :</strong><br>{$message}</p>
            ";
            $this->mail->send();

            // Mail de confirmation
            $this->mail->clearAddresses();
            $this->mail->addAddress($email);
            $this->mail->Subject = "Votre message à Ecoride a bien été reçu";
            $this->mail->Body = "
                <p>Bonjour {$name},</p>
                <p>Merci pour votre message. Nous vous répondrons dès que possible.</p>
                <hr>
                <p><strong>Résumé :</strong></p>
                <ul>
                    <li><strong>Nom :</strong> {$lastname}</li>
                    <li><strong>Prénom :</strong> {$name}</li>
                    <li><strong>Sujet :</strong> {$subject}</li>
                </ul>
                <p><strong>Message :</strong><br>{$message}</p>
                <br>
                <p>À bientôt,<br>L'équipe Ecoride</p>
            ";
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            return "Erreur lors de l'envoi du mail : {$this->mail->ErrorInfo}";
        }
    }
}
