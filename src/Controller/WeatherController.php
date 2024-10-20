<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\WeatherMeasurementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{countryCode?}', name: 'app_weather')]
    public function city(string $city, ?string $countryCode, LocationRepository $locationRepository, WeatherMeasurementsRepository $repository): Response
    {
        // Znajdź lokalizację na podstawie nazwy miasta i opcjonalnie kodu państwa
        $location = $locationRepository->findOneByCityAndCountry($city, $countryCode);

        if (!$location) {
            throw $this->createNotFoundException('Location not found.');
        }

        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}