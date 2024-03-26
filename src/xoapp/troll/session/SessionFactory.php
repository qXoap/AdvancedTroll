<?php

namespace xoapp\troll\session;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class SessionFactory
{
    use SingletonTrait;

    private array $inventory = [];

    public function __construct()
    {
        self::setInstance($this);
    }

    public function register(Player $player): ?Session
    {
        return $this->inventory[$player->getName()] = new Session($player);
    }

    public function isRegistered(Player $player): bool
    {
        return isset($this->inventory[$player->getName()]);
    }

    public function unregister(Player $player): void
    {
        unset($this->inventory[$player->getName()]);
    }
}