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
    name: 'weather:location',
    description: 'Displays weather forecast for a specific location',
)]
class WeatherLocationCommand extends Command
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
            ->addArgument('id', InputArgument::REQUIRED, 'The ID of the location');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $locationId = $input->getArgument('id');

        $location = $this->locationRepository->find($locationId);
        if (!$location) {
            $io->error(sprintf('Location with ID %s not found.', $locationId));
            return Command::FAILURE;
        }
        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Location: %s', $location->getCity()));
        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }
        return Command::SUCCESS;
    }
}
