<?php

namespace xoapp\troll\scheduler;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use xoapp\troll\session\SessionFactory;

class InventoryTask extends Task
{

    private int $time = 10;

    public function onRun(): void
    {
        $this->time--;

        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (!SessionFactory::getInstance()->isRegistered($player)) return;

            if ($this->time <= 0) {
                SessionFactory::getInstance()->unregister($player);
            }
        }
    }
}