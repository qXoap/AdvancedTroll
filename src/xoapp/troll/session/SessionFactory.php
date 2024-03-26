<?php

namespace xoapp\troll\session;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class SessionFactory
{
    use SingletonTrait;

    private array $inventory = [];

    private array $time = [];

    public function __construct()
    {
        self::setInstance($this);
    }

    public function register(Player $player): void
    {
        $this->time[$player->getName()] = 10;
        $this->inventory[$player->getName()] = new Session($player);
    }

    public function isRegistered(Player $player): bool
    {
        return isset($this->inventory[$player->getName()]);
    }

    public function getTime(Player $player): int
    {
        return $this->time[$player->getName()];
    }

    public function unregister(Player $player): void
    {
        unset($this->time[$player->getName()]);
        unset($this->inventory[$player->getName()]);
    }
}