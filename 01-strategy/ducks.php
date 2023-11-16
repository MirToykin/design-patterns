<?php

abstract class Duck
{
    protected FlyBehavior $flyBehavior;
    protected QuackBehavior $quackBehavior;

    abstract public function display(): void;

    public function performFly(): void
    {
        $this->flyBehavior->fly();
    }

    public function performQuack(): void
    {
        $this->quackBehavior->quack();
    }

    public function swim(): void {
        print("All the ducks can swim");
    }

    public function setFlyBehavior(FlyBehavior $fb): void {
        $this->flyBehavior = $fb;
    }

    public function setQuackBehavior(QuackBehavior $qb): void
    {
        $this->quackBehavior = $qb;
    }
}

interface FlyBehavior
{
    public function fly(): void;
}

class FlyWithWings implements FlyBehavior {
    public function fly(): void
    {
        print("I'm flying" . "\n");
    }
}

class FlyNoWay implements FlyBehavior {
    public function fly(): void
    {
        print("I can't fly" . "\n");
    }
}

class FlyRockedPowered implements FlyBehavior {

    public function fly(): void
    {
        print("I'm flying with a rocket" . "\n");
    }
}

interface QuackBehavior
{
    public function quack(): void;
}

class Quack implements QuackBehavior {
    public function quack(): void
    {
        print("Quack" . "\n");
    }
}

class QuackMute implements QuackBehavior {
    public function quack(): void
    {
        print("Silence" . "\n");
    }
}

class Squeak implements QuackBehavior {
    public function quack(): void
    {
        print("Squeak" . "\n");
    }
}

class MallardDuck extends Duck {
    public function __construct()
    {
        $this->flyBehavior = new FlyWithWings();
        $this->quackBehavior = new Quack();
    }

    public function display(): void
    {
        print("I'm a real mallard duck" . "\n");
    }
}

class ModelDuck extends Duck {
    public function __construct()
    {
        $this->quackBehavior = new Quack();
        $this->flyBehavior = new FlyNoWay();
    }

    public function display(): void
    {
        print("I'm a model duck" . "\n");
    }
}

$mallard = new MallardDuck();
$mallard->performQuack();
$mallard->performFly();

$model = new ModelDuck();
$model->performFly();
$model->performQuack();
$model->setFlyBehavior(new FlyRockedPowered());
$model->performFly();
