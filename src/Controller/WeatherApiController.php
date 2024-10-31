<?php
namespace App\Controller;

use App\Entity\WeatherMeasurements;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil $weatherUtil,
        #[MapQueryParameter('city')] ?string $city = null,
        #[MapQueryParameter('country')] ?string $country = null,
        #[MapQueryParameter('format')] ?string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        if (!$city) {
            return $this->json(['error' => 'City parameter is required'], Response::HTTP_BAD_REQUEST);
        }

        $result = $weatherUtil->getWeatherForCountryAndCity($country ?? '', $city);
        $location = $result['location'];
        $measurements = array_map(
            fn(WeatherMeasurements $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
                'kelvin' => $m->getKelvin(),
                'rain_prediction' => $m->isRainPrediction(),
                'wind_speed' => $m->getWindSpeed(),
                'humidity' => $m->getHumidity(),
                'air_pressure' => $m->getAirPressure(),
                'visibility' => $m->getVisibility(),
                'uv_index' => $m->getUvIndex(),
                'weather_description' => $m->getWeatherDescription(),
            ],
            (array)$result['measurements']
        );

        if ($format === 'csv') {
            if ($twig) {
                return new Response($this->renderView('weather_api/index.csv.twig', [
                    'city' => $location->getCity(),
                    'country' => $location->getCountry(),
                    'measurements' => $measurements,
                ]), Response::HTTP_OK, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'inline',
                ]);
            } else {
                $csvData = ["city,country,date,celsius,fahrenheit,kelvin,rain_prediction,wind_speed,humidity,air_pressure,visibility,uv_index,weather_description"];
                foreach ($measurements as $measurement) {
                    $csvData[] = sprintf(
                        '%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                        $location->getCity(),
                        $location->getCountry(),
                        $measurement['date'],
                        $measurement['celsius'],
                        $measurement['fahrenheit'],
                        $measurement['kelvin'],
                        $measurement['rain_prediction'] ? 'true' : 'false',
                        $measurement['wind_speed'],
                        $measurement['humidity'],
                        $measurement['air_pressure'],
                        $measurement['visibility'],
                        $measurement['uv_index'],
                        $measurement['weather_description']
                    );
                }
                return new Response(implode("\n", $csvData), Response::HTTP_OK, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if ($format === 'json' && $twig) {
            return new Response($this->renderView('weather_api/index.json.twig', [
                'city' => $location->getCity(),
                'country' => $location->getCountry(),
                'measurements' => $measurements,
            ]), Response::HTTP_OK, [
                'Content-Type' => 'application/json',
            ]);
        }


        return $this->json([
            'city' => $location->getCity(),
            'country' => $location->getCountry(),
            'measurements' => $measurements,
        ]);
    }
}
