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
            'departureCitySearch' => "%" . strtolower($departure) . "%",
            'arrivalCitySearch' => "%" . strtolower($arrival) . "%"
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

    public function nextCarpooling(int $idUser): array
    {
        $sql = " SELECT 
        c.id_carpooling,
        c.departure_city,
        c.arrival_city,
        c.departure_date,
        c.departure_hour,
        (c.nb_place - COALESCE(passenger_count.nb_passengers, 0)) AS places_restantes,
        COALESCE(passenger_count.nb_passengers, 0) AS nb_passagers,
        c.price_place,
        CONCAT(driver.name_user, ' ', driver.lastname_user) AS conducteur,
        'passager' AS role_utilisateur
        FROM carpooling c
        INNER JOIN Participer p ON c.id_carpooling = p.id_carpooling
        INNER JOIN user u ON p.id_user = u.id_user
        INNER JOIN user driver ON c.driver_id = driver.id_user
        LEFT JOIN (
        SELECT id_carpooling, COUNT(*) AS nb_passengers
        FROM Participer
        GROUP BY id_carpooling
        ) AS passenger_count ON c.id_carpooling = passenger_count.id_carpooling
        WHERE u.id_user = :idUser1
        AND CONCAT(c.departure_date, ' ', c.departure_hour) > NOW()
        
            UNION
        
        SELECT 
        c.id_carpooling,
        c.departure_city,
        c.arrival_city,
        c.departure_date,
        c.departure_hour,
        (c.nb_place - COALESCE(passenger_count.nb_passengers, 0)) AS places_restantes,
        COALESCE(passenger_count.nb_passengers, 0) AS nb_passagers,
        c.price_place,
        CONCAT(driver.name_user, ' ', driver.lastname_user) AS conducteur,
        'conducteur' AS role_utilisateur
        FROM carpooling c
        INNER JOIN user driver ON c.driver_id = driver.id_user
        LEFT JOIN (
        SELECT id_carpooling, COUNT(*) AS nb_passengers
        FROM Participer
        GROUP BY id_carpooling
        ) AS passenger_count ON c.id_carpooling = passenger_count.id_carpooling
        WHERE c.driver_id = :idUser2
        AND CONCAT(c.departure_date, ' ', c.departure_hour) > NOW()
        
        ORDER BY departure_date ASC, departure_hour ASC;
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'idUser1' => $idUser,
            'idUser2' => $idUser,
        ]);
        $nextTrips =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $nextTrips;
    }

    public function oldCarpooling(int $idUser): array
    {
        $sql = " SELECT 
        c.id_carpooling,
        c.departure_city,
        c.arrival_city,
        c.departure_date,
        c.departure_hour,
        (c.nb_place - COALESCE(passenger_count.nb_passengers, 0)) AS places_restantes,
        COALESCE(passenger_count.nb_passengers, 0) AS nb_passagers,
        c.price_place,
        CONCAT(driver.name_user, ' ', driver.lastname_user) AS conducteur,
        'passager' AS role_utilisateur
        FROM carpooling c
        INNER JOIN Participer p ON c.id_carpooling = p.id_carpooling
        INNER JOIN user u ON p.id_user = u.id_user
        INNER JOIN user driver ON c.driver_id = driver.id_user
        LEFT JOIN (
        SELECT id_carpooling, COUNT(*) AS nb_passengers
        FROM Participer
        GROUP BY id_carpooling
        ) AS passenger_count ON c.id_carpooling = passenger_count.id_carpooling
        WHERE u.id_user = :idUser1
        AND CONCAT(c.departure_date, ' ', c.departure_hour) < NOW()
        
            UNION
        
        SELECT 
        c.id_carpooling,
        c.departure_city,
        c.arrival_city,
        c.departure_date,
        c.departure_hour,
        (c.nb_place - COALESCE(passenger_count.nb_passengers, 0)) AS places_restantes,
        COALESCE(passenger_count.nb_passengers, 0) AS nb_passagers,
        c.price_place,
        CONCAT(driver.name_user, ' ', driver.lastname_user) AS conducteur,
        'conducteur' AS role_utilisateur
        FROM carpooling c
        INNER JOIN user driver ON c.driver_id = driver.id_user
        LEFT JOIN (
        SELECT id_carpooling, COUNT(*) AS nb_passengers
        FROM Participer
        GROUP BY id_carpooling
        ) AS passenger_count ON c.id_carpooling = passenger_count.id_carpooling
        WHERE c.driver_id = :idUser2
        AND CONCAT(c.departure_date, ' ', c.departure_hour) < NOW()
        
        ORDER BY departure_date ASC;
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'idUser1' => $idUser,
            'idUser2' => $idUser,
        ]);
        $oldTrips =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $oldTrips;
    }

    public function getPassengersByTripId(int $carpoolingId): array
{
    $sql = "
        SELECT u.name_user, u.lastname_user
        FROM Participer p
        INNER JOIN user u ON p.id_user = u.id_user
        WHERE p.id_carpooling = :carpoolingId
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['carpoolingId' => $carpoolingId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /* DELETE */
    public function deleteCarpooling(int $id): bool
    {
        $sql = "DELETE FROM carpooling WHERE id_carpooling = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
