<?php

namespace xoapp\troll;

use pocketmine\plugin\PluginBase;
use xoapp\troll\commands\TrollCommand;
use xoapp\troll\library\cooldown\Manager;
use xoapp\troll\library\muqsit\invmenu\InvMenuHandler;

class Loader extends PluginBase
{

    protected function onEnable(): void
    {
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        new Manager($this);

        $this->getServer()->getCommandMap()->register("troll", new TrollCommand());
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
    }
}