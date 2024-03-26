<?php

namespace xoapp\troll;

use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use xoapp\troll\session\SessionFactory;

class EventHandler implements Listener
{

    public function onInventoryTransaction(InventoryTransactionEvent $event): void
    {
        $player = $event->getTransaction()->getSource();

        if (!SessionFactory::getInstance()->isRegistered($player)) return;

        $event->cancel();
    }
}