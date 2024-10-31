<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Displays weather forecast for a specific location based on country code and city name',
)]
class WeatherCountryCityCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private LocationRepository $locationRepository;
    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
        $this->locationRepository = $locationRepository;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('city', InputArgument::REQUIRED, 'The name of the city')
            ->addArgument('countryCode', InputArgument::OPTIONAL, 'The country code (optional)');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city = $input->getArgument('city');
        $countryCode = $input->getArgument('countryCode');
        $location = $this->locationRepository->findOneByCityAndCountry($city, $countryCode);
        if (!$location) {
            $io->error(sprintf('Location for city "%s" with country code "%s" not found.', $city, $countryCode ?? 'N/A'));
            return Command::FAILURE;
        }
        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Weather forecast for location: %s, %s', $location->getCity(), $location->getCountry()));
        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\tDate: %s - Temperature: %s°C",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }
        return Command::SUCCESS;
    }
}
