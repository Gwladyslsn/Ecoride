<?php 

namespace App\Security;

class CsrfManager
{
    private const SESSION_KEY = '_csrf_tokens';
    private int $ttl;

    public function __construct(int $ttl = 3600)
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
        $this->ttl = $ttl;
        $this->cleanup();
    }

    // Génère ou récupère un token unique par formId
    public function getToken(string $formId = ''): string
    {
        // Si un token existe déjà pour ce formId, on le renvoie
        foreach ($_SESSION[self::SESSION_KEY] as $token => $meta) {
            if ($meta['form'] === $formId && (time() - $meta['created']) <= $this->ttl) {
                return $token;
            }
        }

        // Sinon, on en crée un nouveau
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_KEY][$token] = [
            'form' => $formId,
            'created' => time()
        ];
        return $token;
    }

    // Retourne le champ HTML à insérer dans le formulaire
    public function getField(string $formId = ''): string
    {
        $token = $this->getToken($formId);
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    // Valide le token
    public function validate(?string $token): bool
    {
        if (!$token || !isset($_SESSION[self::SESSION_KEY][$token])) {
            return false;
        }

        $meta = $_SESSION[self::SESSION_KEY][$token];
        if (time() - $meta['created'] > $this->ttl) {
            unset($_SESSION[self::SESSION_KEY][$token]);
            return false;
        }

        unset($_SESSION[self::SESSION_KEY][$token]); // usage unique
        return true;
    }

    private function cleanup(): void
    {
        foreach ($_SESSION[self::SESSION_KEY] as $token => $meta) {
            if (time() - $meta['created'] > $this->ttl) {
                unset($_SESSION[self::SESSION_KEY][$token]);
            }
        }
    }
}

