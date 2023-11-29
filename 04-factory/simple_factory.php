<?php

declare(strict_types=1);

namespace simple_factory;

enum PizzaType {
    case CHEESE;
    case VEGGIE;
    case CLAM;
    case PEPPERONI;
}

interface Pizza
{
    public function prepare(): void;

    public function bake(): void;

    public function cut(): void;

    public function box(): void;

}

class CheesePizza implements Pizza {

    public function prepare(): void
    {
        print("preparing cheese pizza \n");
    }

    public function bake(): void
    {
        print("baking cheese pizza \n");
    }

    public function cut(): void
    {
        print("cutting cheese pizza \n");
    }

    public function box(): void
    {
        print("boxing cheese pizza \n");
    }
}

class VeggiePizza implements Pizza {

    public function prepare(): void
    {
        print("preparing veggie pizza \n");
    }

    public function bake(): void
    {
        print("baking veggie pizza \n");
    }

    public function cut(): void
    {
        print("cutting veggie pizza \n");
    }

    public function box(): void
    {
        print("boxing veggie pizza \n");
    }
}

class ClamPizza implements Pizza {

    public function prepare(): void
    {
        print("preparing clam pizza \n");
    }

    public function bake(): void
    {
        print("baking clam pizza \n");
    }

    public function cut(): void
    {
        print("cutting clam pizza \n");
    }

    public function box(): void
    {
        print("boxing clam pizza \n");
    }
}

class PepperoniPizza implements Pizza {

    public function prepare(): void
    {
        print("preparing pepperoni pizza \n");
    }

    public function bake(): void
    {
        print("baking pepperoni pizza \n");
    }

    public function cut(): void
    {
        print("cutting pepperoni pizza \n");
    }

    public function box(): void
    {
        print("boxing pepperoni pizza \n");
    }
}


class SimplePizzaFactory
{
    public function createPizza(PizzaType $type): Pizza
    {
        return match($type) {
            PizzaType::CHEESE => new CheesePizza(),
            PizzaType::VEGGIE => new VeggiePizza(),
            PizzaType::CLAM => new ClamPizza(),
            PizzaType::PEPPERONI => new PepperoniPizza()

        };
    }
}

class PizzaStore
{
    public function __construct(private readonly SimplePizzaFactory $factory)
    {
    }

    public function orderPizza(PizzaType $type): Pizza
    {
        $pizza = $this->factory->createPizza($type);

        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }
}


$store = new PizzaStore(new SimplePizzaFactory());

$store->orderPizza(PizzaType::PEPPERONI);