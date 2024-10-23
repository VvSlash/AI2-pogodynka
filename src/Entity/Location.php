<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 2)]
    private ?string $Country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Longitude = null;

    #[ORM\OneToMany(targetEntity: WeatherMeasurements::class, mappedBy: 'Location')]
    private Collection $weatherMeasurements;

    public function __construct()
    {
        $this->weatherMeasurements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    /**
     * @return Collection<int, WeatherMeasurements>
     */
    public function getWeatherMeasurements(): Collection
    {
        return $this->weatherMeasurements;
    }

    public function addWeatherMeasurement(WeatherMeasurements $weatherMeasurement): static
    {
        if (!$this->weatherMeasurements->contains($weatherMeasurement)) {
            $this->weatherMeasurements->add($weatherMeasurement);
            $weatherMeasurement->setLocation($this);
        }

        return $this;
    }

    public function removeWeatherMeasurement(WeatherMeasurements $weatherMeasurement): static
    {
        if ($this->weatherMeasurements->removeElement($weatherMeasurement)) {
            // set the owning side to null (unless already changed)
            if ($weatherMeasurement->getLocation() === $this) {
                $weatherMeasurement->setLocation(null);
            }
        }

        return $this;
    }
}
