<?php

namespace xoapp\troll;

use pocketmine\plugin\PluginBase;
use xoapp\troll\commands\TrollCommand;
use xoapp\troll\library\muqsit\invmenu\InvMenuHandler;
use xoapp\troll\scheduler\InventoryTask;

class Loader extends PluginBase
{

    protected function onEnable(): void
    {
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        $this->getServer()->getCommandMap()->register("troll", new TrollCommand());
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
        $this->getScheduler()->scheduleRepeatingTask(new InventoryTask(), 20);
    }
}