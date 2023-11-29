<?php

declare(strict_types=1);

namespace abstract_factory;

interface Dough {}
class ThinCrustDough implements Dough {}
class ThickCrustDough implements Dough {}

interface Sauce {}
class MarinaraSauce implements Sauce {}
class PlumTomatoSauce implements Sauce {}

interface Cheese {}
class ReggianoCheese implements Cheese {}
class MozzarellaCheese implements Cheese {}

interface Veggies {}
class Garlic implements Veggies {}
class Onion implements Veggies {}
class Mushroom implements Veggies {}
class RedPepper implements Veggies {}
class Spinach implements Veggies {}
class BlackOlives implements Veggies {}
class EggPlant implements Veggies {}

interface Pepperoni {}
class SlicedPepperoni implements Pepperoni {}

interface Clams {}
class FreshClams implements Clams {}
class FrozenClams implements Clams {}


interface PizzaIngredientFactory {
    public function createDough(): Dough;
    public function createSauce(): Sauce;
    public function createCheese(): Cheese;

    /**
     * @return Veggies[]
     */
    public function createVeggies(): array;
    public function createPepperoni(): Pepperoni;
    public function createClam(): Clams;
}

class NYPizzaIngredientFactory implements PizzaIngredientFactory {

    public function createDough(): Dough
    {
        return new ThinCrustDough();
    }

    public function createSauce(): Sauce
    {
        return new MarinaraSauce();
    }

    public function createCheese(): Cheese
    {
        return new ReggianoCheese();
    }

    /**
     * @return Veggies[]
     */
    public function createVeggies(): array
    {
        /**
         * @var $veggies Veggies[]
         */
        $veggies = [new Garlic(), new Onion(), new Mushroom(), new RedPepper()];
        return $veggies;
    }

    public function createPepperoni(): Pepperoni
    {
        return new SlicedPepperoni();
    }

    public function createClam(): Clams
    {
        return new FreshClams();
    }
}

class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory {

    public function createDough(): Dough
    {
        return new ThickCrustDough();
    }

    public function createSauce(): Sauce
    {
        return new PlumTomatoSauce();
    }

    public function createCheese(): Cheese
    {
        return new MozzarellaCheese();
    }

    /**
     * @return Veggies[]
     */
    public function createVeggies(): array
    {
        /**
         * @var $veggies Veggies[]
         */
        $veggies = [new Spinach(), new BlackOlives(), new EggPlant()];
        return $veggies;
    }

    public function createPepperoni(): Pepperoni
    {
        return new SlicedPepperoni();
    }

    public function createClam(): Clams
    {
        return new FrozenClams();
    }
}

enum PizzaType {
    case CHEESE;
    case PEPPERONI;
    case CLAM;
}

/**
 * @property Veggies[] $veggies
 */
abstract class Pizza
{
    protected string $name = "Pizza";
    protected Dough $dough;
    protected Sauce $sauce;
    protected array $veggies;
    protected Cheese $cheese;
    protected Pepperoni $pepperoni;
    protected Clams $clams;

    abstract public function prepare(): void;

    public function bake(): void {
        print("baking {$this->getName()} \n");
    }

    public function cut(): void {
        print("cutting {$this->getName()} \n");
    }

    public function box(): void {
        print("boxing {$this->getName()} \n");
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function toString(): string {
        return "Pizza: {$this->name}";
    }

}

class CheesePizza extends Pizza {

    public function __construct(protected PizzaIngredientFactory $ingredientFactory)
    {
    }

    public function prepare(): void
    {
        print("Preparing {$this->name}\n");
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
    }
}

class ClamPizza extends Pizza {

    public function __construct(protected PizzaIngredientFactory $ingredientFactory)
    {
    }

    public function prepare(): void
    {
        print("Preparing {$this->name}\n");
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
        $this->clams = $this->ingredientFactory->createClam();
    }
}

class PepperoniPizza extends Pizza {

    public function __construct(protected PizzaIngredientFactory $ingredientFactory)
    {
        $this->name = "Pepperoni pizza";
    }

    public function prepare(): void
    {
        print("Preparing {$this->name}\n");
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
        $this->pepperoni = $this->ingredientFactory->createPepperoni();
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
        /**
         * @var $ingredientFactory PizzaIngredientFactory
         */
        $ingredientFactory = new NYPizzaIngredientFactory();
        $pizza = null;

        switch ($type) {
            case PizzaType::CHEESE:
                $pizza = new CheesePizza($ingredientFactory);
                $pizza->setName("NY style cheese pizza");
                break;
            case PizzaType::CLAM:
                $pizza = new ClamPizza($ingredientFactory);
                $pizza->setName("NY style clam pizza");
                break;
            case PizzaType::PEPPERONI:
                $pizza = new PepperoniPizza($ingredientFactory);
                $pizza->setName("NY style pepperoni pizza");
                break;
        }

        return $pizza;
    }
}

class ChicagoPizzaStore extends PizzaStore {

    public function createPizza(PizzaType $type): Pizza
    {
        /**
         * @var $ingredientFactory PizzaIngredientFactory
         */
        $ingredientFactory = new ChicagoPizzaIngredientFactory();
        $pizza = null;

        switch ($type) {
            case PizzaType::CHEESE:
                $pizza = new CheesePizza($ingredientFactory);
                $pizza->setName("Chicago style cheese pizza");
                break;
            case PizzaType::CLAM:
                $pizza = new ClamPizza($ingredientFactory);
                $pizza->setName("Chicago style clam pizza");
                break;
            case PizzaType::PEPPERONI:
                $pizza = new PepperoniPizza($ingredientFactory);
                $pizza->setName("Chicago style pepperoni pizza");
                break;
        }

        return $pizza;
    }
}

$store = new NYPizzaStore();
$store->orderPizza(PizzaType::CHEESE);