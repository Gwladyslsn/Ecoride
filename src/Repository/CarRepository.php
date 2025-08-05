<?php

namespace App\Repository;

use PDO;

class CarRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUserId(int $userId): ?array
    {
        $sql = "SELECT * FROM car WHERE id_user = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        return $car ?: null;
    }

    /* Check if user -> car*/
        public function hasCar(int $userId): bool
    {
        $sql = "SELECT COUNT(*) FROM car WHERE id_user = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return (bool) $stmt->fetchColumn();
    }

    public function getCarById(int $carId): ?array {
    $stmt = $this->pdo->prepare("SELECT * FROM car WHERE id_car = :id");
    $stmt->execute(['id' => $carId]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    return $car ?: null;
}
}
