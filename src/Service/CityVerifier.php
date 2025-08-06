<?php

namespace App\Service;

class CityVerifier
{

    private static array $cache = [];
    public function cityExists(string $cityName): bool
    {

        $cityName = strtolower(trim($cityName));

        if (isset(self::$cache[$cityName])) {
            return self::$cache[$cityName]; // ✅ réponse directe depuis le cache
        }

        $url = "https://api-adresse.data.gouv.fr/search/?q=" . urlencode($cityName) . "&limit=1";

        $options = [
            "http" => [
                "header" => "User-Agent: EcorideBackend/1.0"
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $isValid = false;

        if ($response !== false) {
            $data = json_decode($response, true);

            // ✅ Vérifie s’il y a au moins un résultat et que c’est bien une commune
            if (!empty($data['features'][0])) {
                $properties = $data['features'][0]['properties'] ?? [];

                if (isset($properties['type']) && $properties['type'] === 'municipality') {
                    $isValid = true;
                } elseif (isset($properties['city'])) {
                    $isValid = true;
                }
            }
        }

        // 🧠 Mise en cache du résultat
        self::$cache[$cityName] = $isValid;

        return $isValid;
    }

public function getCoordinates(string $cityName): ?array
{
    // On garde le nom exact de la ville, pas de strtolower pour ne pas perdre les accents
    $cityName = trim($cityName);
    $url = "https://api-adresse.data.gouv.fr/search/?q=" . urlencode($cityName) . "&limit=1";

    $options = [
        "http" => [
            "header" => "User-Agent: EcoRideBot/1.0\r\n"
        ]
    ];
    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        // Échec de la requête API
        error_log("CityVerifier: Impossible de contacter l'API pour $cityName");
        return null;
    }

    $data = json_decode($response, true);

    if (empty($data['features'])) {
        // Ville non trouvée
        error_log("CityVerifier: Ville introuvable : $cityName");
        return null;
    }

    $coords = $data['features'][0]['geometry']['coordinates']; // [lon, lat]

    if (!isset($coords[0], $coords[1])) {
        return null;
    }

    return [
        'lat' => $coords[1],
        'lon' => $coords[0]
    ];
}


}
