<?php

namespace xoapp\troll\library\cooldown;

use Exception;

class Cooldown {

    private CooldownManager $manager;
    private string $name;
    private int $duration = 1;
    private \Closure $onTick;
    private \Closure $onClose;
    private mixed $args;

    private string $taskId;

    /**
     * @throws Exception
     */
    public function __construct(CooldownManager $manager, string $name, int $duration, mixed $args, \Closure $onTick, \Closure $onClose) {
        $this->manager = $manager;
        $this->name = $name;
        $this->duration = $duration;
        $this->onTick = $onTick;
        $this->onClose = $onClose;
        $this->args = $args;
        $this->taskId = TaskManager::getInstance()->add(new CooldownTask($this), "cooldown");
    }

    public function getTime(): int
    {
        return $this->duration;
    }

    public function onTick(): void {
        $this->duration--;
        ($this->onTick)($this->duration, $this->args);
    }

    public function onClose(): void {
        ($this->onClose)($this->duration, $this->args);
        TaskManager::getInstance()->remove($this->taskId);
        $this->manager->remove($this->name);
    }
}