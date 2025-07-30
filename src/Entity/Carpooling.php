<?php

namespace App\Entity;

class Carpooling
{
    private ?int $id_carpooling = null;
    private \DateTime $departure_date;
    private \DateTime $arrival_date;
    private string $departure_hour;
    private string $arrival_hour;
    private string $departure_city;
    private string $arrival_city;
    private int $nb_place;
    private float $price_place;
    private int $id_car;

    public function __construct(
        string $departure_city,
        \DateTime $departure_date,
        string $departure_hour,
        string $arrival_city,
        \DateTime $arrival_date,
        string $arrival_hour,
        int $nb_place,
        float $price_place,
        int $id_car
    ) {
        $this->departure_city = $departure_city;
        $this->departure_date = $departure_date;
        $this->departure_hour = $departure_hour;
        $this->arrival_city = $arrival_city;
        $this->arrival_date = $arrival_date;
        $this->arrival_hour = $arrival_hour;
        $this->nb_place = $nb_place;
        $this->price_place = $price_place;
        $this->id_car = $id_car;
    }

    public function getIdCarpooling(): ?int
    {
        return $this->id_carpooling;
    }

    public function setIdCarpooling(int $id_carpooling): self
    {
        $this->id_carpooling = $id_carpooling;
        return $this;
    }

    public function getDepartureDate(): \DateTime
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTime $departure_date): self
    {
        $this->departure_date = $departure_date;
        return $this;
    }

    public function getArrivalDate(): \DateTime
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTime $arrival_date): self
    {
        $this->arrival_date = $arrival_date;
        return $this;
    }

    public function getDepartureHour(): string
    {
        return $this->departure_hour;
    }

    public function setDepartureHour(string $departure_hour): self
    {
        $this->departure_hour = $departure_hour;
        return $this;
    }

    public function getArrivalHour(): string
    {
        return $this->arrival_hour;
    }

    public function setArrivalHour(string $arrival_hour): self
    {
        $this->arrival_hour = $arrival_hour;
        return $this;
    }

    public function getDepartureCity(): string
    {
        return $this->departure_city;
    }

    public function setDepartureCity(string $departure_city): self
    {
        $this->departure_city = $departure_city;
        return $this;
    }

    public function getArrivalCity(): string
    {
        return $this->arrival_city;
    }

    public function setArrivalCity(string $arrival_city): self
    {
        $this->arrival_city = $arrival_city;
        return $this;
    }

    public function getNbPlace(): int
    {
        return $this->nb_place;
    }

    public function setNbPlace(int $nb_place): self
    {
        $this->nb_place = $nb_place;
        return $this;
    }

    public function getPricePlace(): float
    {
        return $this->price_place;
    }

    public function setPricePlace(float $price_place): self
    {
        $this->price_place = $price_place;
        return $this;
    }

    public function getIdCar(): int
    {
        return $this->id_car;
    }

    public function setIdCar(int $id_car): self
    {
        $this->id_car = $id_car;
        return $this;
    }
}
