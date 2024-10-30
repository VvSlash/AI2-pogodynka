<?php

namespace App\Controller;

use App\Entity\WeatherMeasurements;
use App\Form\WeatherMeasurementsType;
use App\Repository\WeatherMeasurementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weathermeasurements')]
class WeatherMeasurementsController extends AbstractController
{
    #[Route('/', name: 'app_weather_measurements_index', methods: ['GET'])]
    public function index(WeatherMeasurementsRepository $weatherMeasurementsRepository): Response
    {
        return $this->render('weather_measurements/index.html.twig', [
            'weather_measurements' => $weatherMeasurementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weather_measurements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $weatherMeasurement = new WeatherMeasurements();
        $form = $this->createForm(WeatherMeasurementsType::class, $weatherMeasurement, [
            'validation_groups' => 'create',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weatherMeasurement);
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_measurements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_measurements/new.html.twig', [
            'weather_measurement' => $weatherMeasurement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_measurements_show', methods: ['GET'])]
    public function show(WeatherMeasurements $weatherMeasurement): Response
    {
        return $this->render('weather_measurements/show.html.twig', [
            'weather_measurement' => $weatherMeasurement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weather_measurements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WeatherMeasurements $weatherMeasurement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WeatherMeasurementsType::class, $weatherMeasurement, [
            'validation_groups' => 'edit',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_measurements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_measurements/edit.html.twig', [
            'weather_measurement' => $weatherMeasurement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_measurements_delete', methods: ['POST'])]
    public function delete(Request $request, WeatherMeasurements $weatherMeasurement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weatherMeasurement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($weatherMeasurement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_weather_measurements_index', [], Response::HTTP_SEE_OTHER);
    }
}