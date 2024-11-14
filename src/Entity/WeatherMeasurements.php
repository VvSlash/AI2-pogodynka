<?php

namespace App\Entity;

use App\Repository\WeatherMeasurementsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherMeasurementsRepository::class)]
class WeatherMeasurements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'weatherMeasurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $celsius = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $fahrenheit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $kelvin = null;

    #[ORM\Column]
    private ?bool $rainPrediction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?float $windSpeed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?float $humidity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $visibility = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 1)]
    private ?string $airPressure = null;

    #[ORM\Column]
    private ?int $uvIndex = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $weatherDescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCelsius(): ?string
    {
        return $this->celsius;
    }

    public function setCelsius(string $celsius): static
    {
        $this->celsius = $celsius;

        return $this;
    }

    public function getFahrenheit(): ?float /*?string*/
    {
//        return $this->fahrenheit;
        return round(($this->getCelsius() * 9 / 5) + 32, 2);
    }

    public function setFahrenheit(string $fahrenheit): static
    {
        $this->fahrenheit = $fahrenheit;

        return $this;
    }

    public function getKelvin(): ?string
    {
        return $this->kelvin;
    }

    public function setKelvin(string $kelvin): static
    {
        $this->kelvin = $kelvin;

        return $this;
    }

    public function isRainPrediction(): ?bool
    {
        return $this->rainPrediction;
    }

    public function setRainPrediction(bool $rainPrediction): static
    {
        $this->rainPrediction = $rainPrediction;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): static
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getAirPressure(): ?string
    {
        return $this->airPressure;
    }

    public function setAirPressure(string $airPressure): static
    {
        $this->airPressure = $airPressure;

        return $this;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getUvIndex(): ?int
    {
        return $this->uvIndex;
    }

    public function setUvIndex(int $uvIndex): static
    {
        $this->uvIndex = $uvIndex;

        return $this;
    }

    public function getWeatherDescription(): ?string
    {
        return $this->weatherDescription;
    }

    public function setWeatherDescription(string $weatherDescription): static
    {
        $this->weatherDescription = $weatherDescription;

        return $this;
    }
}
