<?php

declare(strict_types=1);

interface Observer {
    public function update(float $temperature, float $humidity, float $pressure): void;
}

interface DisplayElement {
    public function display(): void;
}

interface Subject {
    public function registerObserver(Observer $o): void;
    public function removeObserver(Observer $o): void;
    public function notifyObservers(): void;
}

/**
 * @property Observer[] $observers
 */
class WeatherData implements Subject {
    private SplObjectStorage $observers;
    private float $temperature;
    private float $humidity;
    private float $pressure;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function registerObserver(Observer $o): void
    {
        $this->observers->attach($o);
    }

    public function removeObserver(Observer $o): void
    {
        $this->observers->detach($o);
    }

    public function notifyObservers(): void
    {
        /**
         * @var Observer $observer
         */
        foreach ($this->observers as $observer) {
            $observer->update($this->temperature, $this->humidity, $this->pressure);
        }
    }

    private function measurementsChanged(): void {
        $this->notifyObservers();
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure): void {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
        $this->measurementsChanged();
    }
}

class CurrentConditionsDisplay implements Observer, DisplayElement {
    private float $temperature;
    private float $humidity;

    public function __construct(private readonly Subject $weatherData)
    {
        $this->weatherData->registerObserver($this);
    }

    public function update(float $temperature, float $humidity, float $pressure): void
    {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->display();
    }

    public function display(): void
    {
        print("Current temperature is {$this->temperature}, humidity is {$this->humidity}\n");
    }
}

class StatisticsDisplay implements Observer, DisplayElement {
    private float $maxTemp = 0.0;
	private float $minTemp = 200;
	private float $tempSum= 0.0;
	private int $numReadings = 0;

    public function __construct(private readonly WeatherData $weatherData) {
		$this->weatherData->registerObserver($this);
	}

    public function update(float $temperature, float $humidity, float $pressure): void {
        $this->tempSum += $temperature;
        $this->numReadings++;

        if ($temperature > $this->maxTemp) {
            $this->maxTemp = $temperature;
        }

        if ($temperature < $this->minTemp) {
            $this->minTemp = $temperature;
        }

        $this->display();
    }

	public function display(): void {
        print("Avg/Max/Min temperature = " . ($this->tempSum / $this->numReadings) . "/" . $this->maxTemp . "/" . $this->minTemp . "\n");
    }
}

class ForecastDisplay implements Observer, DisplayElement {
    private float $currentPressure = 29.9;
    private float $lastPressure;

    public function __construct(private readonly Subject $weatherData)
    {
        $this->weatherData->registerObserver($this);
    }

    public function update(float $temperature, float $humidity, float $pressure): void
    {
        $this->lastPressure = $this->currentPressure;
        $this->currentPressure = $pressure;
        $this->display();
    }

    public function display(): void
    {
        print("Forecast: ");
		if ($this->currentPressure > $this->lastPressure) {
            print("Improving weather on the way!");
        } else if ($this->currentPressure === $this->lastPressure) {
            print("More of the same");
        } else if ($this->currentPressure < $this->lastPressure) {
            print("Watch out for cooler, rainy weather");
        }
        print("\n");
    }
}

$weatherData = new WeatherData();
$displayCurrent = new CurrentConditionsDisplay($weatherData);
$displayStatistics = new StatisticsDisplay($weatherData);
$displayForecast = new ForecastDisplay($weatherData);

$weatherData->setMeasurements(80, 65, 30.4);
$weatherData->setMeasurements(82, 70, 29.2);
$weatherData->setMeasurements(78, 90, 29.2);

$weatherData->removeObserver($displayForecast);
$weatherData->setMeasurements(79, 89, 28.2);