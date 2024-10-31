<?php

namespace App\Tests\Entity;

use App\Entity\WeatherMeasurements;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        // Encję pomiarów
        $measurement = new WeatherMeasurements();

        // Ustawienie wartości Celsjusza
        $measurement->setCelsius($celsius);

        // Sprawdzenie wartości w Fahrenheitach
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit(), "{$celsius}oC should be {$expectedFahrenheit}oF");
    }

    public function dataGetFahrenheit(): array
    {
        return [
            [0, 32.0],
            [-100, -148.0],
            [100, 212.0],
            [0.5, 32.9],
            [-40, -40.0],
            [37, 98.6],
            [25.5, 77.9],
            [10, 50.0],
            [15.15, 59.27],
            [20.6, 69.08],
        ];
    }
}
