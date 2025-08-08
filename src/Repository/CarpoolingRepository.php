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

    // CREATE
    public function newCarpooling(Carpooling $carpooling): bool
    {
        $sql = "INSERT INTO carpooling (
            departure_city, departure_date, departure_hour,
            arrival_city, arrival_date, arrival_hour,
            nb_place, price_place, info_carpooling, id_car, driver_id
        ) VALUES (
            :departure_city, :departure_date, :departure_hour,
            :arrival_city, :arrival_date, :arrival_hour,
            :nb_place, :price_place, :info_carpooling, :id_car, :driver_id
        )";

        $stmt = $this->pdo->prepare($sql);

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
            'info_carpooling' => $carpooling->getInfoCarpooling(),
            'id_car' => $carpooling->getIdCar(),
            'driver_id' => $carpooling->getDriverId()
        ]);
    }

    public function getAllTrips()
    {
        $sql = "
            SELECT carpooling.*, user.name_user, user.avatar_user, car.brand_car, car.model_car, car.photo_car, car.year_car, car.energy_car
            FROM carpooling
            JOIN car ON carpooling.id_car = car.id_car
            JOIN user ON carpooling.driver_id = user.id_user
            WHERE DATE(carpooling.departure_date) >= CURRENT_DATE
            ORDER BY carpooling.departure_date ASC;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showTripsSearched($departure, $arrival, $date)
    {
        $sql = "
            SELECT carpooling.*, user.name_user, user.avatar_user, car.brand_car, car.model_car, car.photo_car, car.year_car, car.energy_car
            FROM carpooling
            JOIN car ON carpooling.id_car = car.id_car
            JOIN user ON carpooling.driver_id = user.id_user
            WHERE carpooling.departure_date >= :dateSearch
            AND LOWER(carpooling.departure_city) LIKE LOWER(:departureCitySearch)
            AND LOWER(carpooling.arrival_city) LIKE LOWER(:arrivalCitySearch)
            ORDER BY carpooling.departure_date ASC;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'dateSearch' => $date,
            'departureCitySearch' => "%".strtolower($departure)."%",
            'arrivalCitySearch' => "%".strtolower($arrival)."%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTripById(int $id)
    {
        $sql = "
            SELECT carpooling.*, user.name_user, user.avatar_user, car.brand_car, car.model_car, car.photo_car, car.year_car, car.energy_car
            FROM carpooling
            JOIN car ON carpooling.id_car = car.id_car
            JOIN user ON carpooling.driver_id = user.id_user
            WHERE carpooling.id_carpooling = :id
            LIMIT 1;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasAvailableSeats(int $carpoolingId): bool
{
    $query = "SELECT nb_place FROM carpooling WHERE id_carpooling = :id_carpooling";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':id_carpooling', $carpoolingId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result && (int)$result['nb_place'] > 0;
}
}

