<?php

interface BeverageInterface {
    public function getCost(): float;

    public function getDescription(): string;
}

abstract class Beverage implements BeverageInterface {
    protected string $description;
}

abstract class CondimentDecorator extends Beverage {
    public function __construct(protected Beverage $beverage)
    {
    }
}

class Espresso extends Beverage {

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getCost(): float
    {
        return 1.99;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

class HouseBlend extends Beverage {

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getCost(): float
    {
        return .99;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

class Soy extends CondimentDecorator {

    public function getCost(): float
    {
        return $this->beverage->getCost() + .10;
    }


    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Soy";
    }
}

class Mocka extends CondimentDecorator {

    public function getCost(): float
    {
        return $this->beverage->getCost() + .20;
    }


    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Mocka";
    }
}

class Whip extends CondimentDecorator {

    public function getCost(): float
    {
        return $this->beverage->getCost() + .30;
    }


    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Whip";
    }
}

$coffee = new Espresso("espresso");
print($coffee->getDescription() . ", $" . $coffee->getCost() . "\n");

$coffee1 = new HouseBlend("house blend");
$coffee1 = new Soy($coffee1);
$coffee1 = new Mocka($coffee1);
$coffee1 = new Mocka($coffee1);
$coffee1 = new Whip($coffee1);

print($coffee1->getDescription() . ", $" . $coffee1->getCost() . "\n");