<?php

namespace xoapp\troll;

use pocketmine\plugin\PluginBase;
use xoapp\troll\library\muqsit\invmenu\InvMenuHandler;
use xoapp\troll\scheduler\InventoryTask;

class Loader extends PluginBase
{

    protected function onEnable(): void
    {
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        $this->getScheduler()->scheduleRepeatingTask(new InventoryTask(), 20);
    }

    public static function equals($data1, $data2): bool
    {
        return $data1 === $data2;
    }
}