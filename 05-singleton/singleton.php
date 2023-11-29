<?php

declare(strict_types=1);

namespace singleton;

class Singleton {
    private static self|null $instance = null;
    public int $counter = 0;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new Singleton();
        }

        return self::$instance;
    }
}

$obj1 = Singleton::getInstance();
++$obj1->counter;
$obj2 = Singleton::getInstance();
print("obj2 counter: " . $obj2->counter . "\n");
