<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\WeatherMeasurements;
use App\Repository\LocationRepository;
use App\Repository\WeatherMeasurementsRepository;

class WeatherUtil
{
    private WeatherMeasurementsRepository $weatherMeasurementsRepository;
    private LocationRepository $locationRepository;

    public function __construct(
        WeatherMeasurementsRepository $weatherMeasurementsRepository,
        LocationRepository $locationRepository
    ) {
        $this->weatherMeasurementsRepository = $weatherMeasurementsRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return WeatherMeasurements[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->weatherMeasurementsRepository->findByLocation($location);
    }

    /**
     * @return WeatherMeasurements[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneByCityAndCountry($city, $countryCode);

        if ($location) {
            $measurements = $this->weatherMeasurementsRepository->findByLocation($location);
            return [
                'location' => $location,
                'measurements' => $measurements,
            ];
        }

        return [];
    }
}
