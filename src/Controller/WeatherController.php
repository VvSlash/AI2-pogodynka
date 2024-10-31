<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{countryCode?}', name: 'app_weather')]
    public function city(
        #[MapEntity(mapping: ['countryCode' => 'country', 'city' => 'city'])] ?Location $location,
        WeatherUtil $util,
        string $city,
        ?string $countryCode = null
    ): Response
    {
        if ($location) {
            $measurements = $util->getWeatherForLocation($location);
        } else {
            $result = $util->getWeatherForCountryAndCity($countryCode ?? '', $city);
            $location = $result['location'];
            $measurements = $result['measurements'];

            if (!$location) {
                throw $this->createNotFoundException('Location not found.');
            }
        }

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
