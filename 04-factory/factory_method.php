<?php

declare(strict_types=1);

namespace factory_method;

enum PizzaType {
    case CHEESE;
    case PEPPERONI;
}

abstract class Pizza
{
    protected string $name;

    public function prepare(): void {
        print("preparing {$this->getName()} \n");
    }

    public function bake(): void {
        print("baking {$this->getName()} \n");
    }

    public function cut(): void {
        print("cutting {$this->getName()} \n");
    }

    public function box(): void {
        print("boxing {$this->getName()} \n");
    }

    public function getName(): string {
        return $this->name;
    }

}

class NYStyleCheesePizza extends Pizza {

    public function __construct()
    {
        $this->name = "NY style cheese pizza";
    }
}

class NYStylePepperoniPizza extends Pizza {

    public function __construct()
    {
        $this->name = "NY style pepperoni pizza"; 
    }
}

class ChicagoStyleCheesePizza extends Pizza {

    public function __construct()
    {
        $this->name = "Chicago style cheese pizza";
    }
}

class ChicagoStylePepperoniPizza extends Pizza {

    public function __construct()
    {
        $this->name = "Chicago style pepperoni pizza";
    }
}

abstract class PizzaStore
{

    public function orderPizza(PizzaType $type): Pizza
    {
        $pizza = $this->createPizza($type);

        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }

    abstract public function createPizza(PizzaType $type): Pizza;
}

class NYPizzaStore extends PizzaStore {

    public function createPizza(PizzaType $type): Pizza
    {
        return match($type) {
            PizzaType::CHEESE => new NYStyleCheesePizza(),
            PizzaType::PEPPERONI => new NYStylePepperoniPizza()

        };
    }
}

class ChicagoPizzaStore extends PizzaStore {

    public function createPizza(PizzaType $type): Pizza
    {
        return match($type) {
            PizzaType::CHEESE => new ChicagoStyleCheesePizza(),
            PizzaType::PEPPERONI => new ChicagoStylePepperoniPizza()

        };
    }
}

$store = new NYPizzaStore();
$store->orderPizza(PizzaType::CHEESE);