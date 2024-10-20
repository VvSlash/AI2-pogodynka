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
    private ?Location $Location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $Celsius = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $Fahrenheit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $Kelvin = null;

    #[ORM\Column]
    private ?bool $Rain_Prediction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $Wind_Speed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $Humidity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 1)]
    private ?string $Air_Pressure = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $Visibility = null;

    #[ORM\Column]
    private ?int $UV_Index = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Weather_Description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    public function setLocation(?Location $Location): static
    {
        $this->Location = $Location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getCelsius(): ?string
    {
        return $this->Celsius;
    }

    public function setCelsius(string $Celsius): static
    {
        $this->Celsius = $Celsius;

        return $this;
    }

    public function getFahrenheit(): ?string
    {
        return $this->Fahrenheit;
    }

    public function setFahrenheit(string $Fahrenheit): static
    {
        $this->Fahrenheit = $Fahrenheit;

        return $this;
    }

    public function getKelvin(): ?string
    {
        return $this->Kelvin;
    }

    public function setKelvin(string $Kelvin): static
    {
        $this->Kelvin = $Kelvin;

        return $this;
    }

    public function isRainPrediction(): ?bool
    {
        return $this->Rain_Prediction;
    }

    public function setRainPrediction(bool $Rain_Prediction): static
    {
        $this->Rain_Prediction = $Rain_Prediction;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->Wind_Speed;
    }

    public function setWindSpeed(string $Wind_Speed): static
    {
        $this->Wind_Speed = $Wind_Speed;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->Humidity;
    }

    public function setHumidity(string $Humidity): static
    {
        $this->Humidity = $Humidity;

        return $this;
    }

    public function getAirPressure(): ?string
    {
        return $this->Air_Pressure;
    }

    public function setAirPressure(string $Air_Pressure): static
    {
        $this->Air_Pressure = $Air_Pressure;

        return $this;
    }

    public function getVisibility(): ?string
    {
        return $this->Visibility;
    }

    public function setVisibility(string $Visibility): static
    {
        $this->Visibility = $Visibility;

        return $this;
    }

    public function getUVIndex(): ?int
    {
        return $this->UV_Index;
    }

    public function setUVIndex(int $UV_Index): static
    {
        $this->UV_Index = $UV_Index;

        return $this;
    }

    public function getWeatherDescription(): ?string
    {
        return $this->Weather_Description;
    }

    public function setWeatherDescription(string $Weather_Description): static
    {
        $this->Weather_Description = $Weather_Description;

        return $this;
    }
}
