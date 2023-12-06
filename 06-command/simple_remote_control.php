<?php

declare(strict_types=1);

interface Command {
    public function execute(): void;
}

class Light {
    public function on(): void {
        print("light is on\n");
    }

    public function off(): void {
        print("light is off\n");
    }
}

class LightOnCommand implements Command {
    public function __construct(private readonly Light $light)
    {
    }

    public function execute(): void
    {
        $this->light->on();
    }
}

class LightOffCommand implements Command {
    public function __construct(private readonly Light $light)
    {
    }

    public function execute(): void
    {
        $this->light->off();
    }
}

class SimpleRemoteControl {
    private Command $command;

    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }

    public function buttonWasPressed(): void
    {
        $this->command->execute();
    }
}

$remote = new SimpleRemoteControl();
$light = new Light();
$command = new LightOnCommand($light);

$remote->setCommand($command);
$remote->buttonWasPressed();