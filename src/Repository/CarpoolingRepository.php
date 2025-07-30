<?php

namespace App\Repository;

use App\Entity\Carpooling;
use PDO;


class CarpoolingRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //Check


    // CREATE
    public function newCarpooling(Carpooling $carpooling): bool
{
    $sql = "INSERT INTO carpooling (
        departure_city, departure_date, departure_hour,
        arrival_city, arrival_date, arrival_hour,
        nb_place, price_place, id_car
    ) VALUES (
        :departure_city, :departure_date, :departure_hour,
        :arrival_city, :arrival_date, :arrival_hour,
        :nb_place, :price_place, :id_car
    )";

    $stmt = $this->pdo->prepare($sql);

    // Protection contre les appels à ->format() sur null
    $departureDate = $carpooling->getDepartureDate();
    $arrivalDate = $carpooling->getArrivalDate();

    return $stmt->execute([
        'departure_city' => $carpooling->getDepartureCity(),
        'departure_date' => $departureDate ? $departureDate->format('Y-m-d') : null,
        'departure_hour' => $carpooling->getDepartureHour(),
        'arrival_city' => $carpooling->getArrivalCity(),
        'arrival_date' => $arrivalDate ? $arrivalDate->format('Y-m-d') : null,
        'arrival_hour' => $carpooling->getArrivalHour(),
        'nb_place' => $carpooling->getNbPlace(),
        'price_place' => $carpooling->getPricePlace(),
        'id_car' => $carpooling->getIdCar()
    ]);
}

}
