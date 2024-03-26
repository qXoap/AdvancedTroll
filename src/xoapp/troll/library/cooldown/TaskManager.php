<?php

namespace xoapp\troll\library\cooldown;

use Exception;
use pocketmine\scheduler\Task;
use xoapp\troll\Loader;

class TaskManager
{

    public static TaskManager $instance;

    private Loader $owner;

    private array $tasks = [];

    public function __construct(Loader $owner)
    {
        self::$instance = $this;
        $this->owner = $owner;
    }

    public static function getInstance(): TaskManager
    {
        return self::$instance;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function get($id): ?Task
    {
        return $this->task[$id] ?? null;
    }

    /**
     * @throws Exception
     */
    public function add($task, string $type, int $tick = 20): string
    {
        $id = bin2hex(random_bytes(16));

        while (isset($this->tasks[$id])) {
            $id = bin2hex(random_bytes(16));
        }

        $this->owner->getScheduler()->scheduleRepeatingTask($this->tasks[$id] = $task, $tick);
        return $id;
    }

    public function remove($id): void
    {
        if (!isset($this->tasks[$id])) return;
        unset($this->tasks[$id]);
    }
}