<?php

namespace xoapp\troll\library\cooldown;

use pocketmine\scheduler\Task;

class CooldownTask extends Task
{

    private Cooldown $controller;

    public function __construct(Cooldown $controller)
    {
        $this->controller = $controller;
    }

    public function onRun(): void
    {
        if ($this->controller->getTime() < 1) {
            $this->controller->onClose();
            $this->getHandler()->cancel();
        } else {
            $this->controller->onTick();
        }
    }
}