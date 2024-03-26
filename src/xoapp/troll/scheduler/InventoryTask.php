<?php

namespace xoapp\troll\scheduler;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use xoapp\troll\session\SessionFactory;

class InventoryTask extends Task
{

    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (!SessionFactory::getInstance()->isRegistered($player)) return;

            $time = SessionFactory::getInstance()->getTime($player);

            $time--;

            if ($time <= 0) {
                SessionFactory::getInstance()->unregister($player);
            }
        }
    }
}