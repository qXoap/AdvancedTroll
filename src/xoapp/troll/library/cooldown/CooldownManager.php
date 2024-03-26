<?php

namespace xoapp\troll\library\cooldown;

use Exception;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class CooldownManager
{
    use SingletonTrait;

    private array $cooldowns = [];

    public function __construct()
    {
        self::setInstance($this);
    }

    public function getCooldowns(): array
    {
        return $this->cooldowns;
    }

    /**
     * @throws Exception
     */
    public function add(Player $player, string $name, int $duration, $args, \Closure $onTick, \Closure $onClose): void
    {
        if (isset($this->cooldowns[$player->getName() . $name])) return;

        $this->cooldowns[$player->getName() . $name] = new Cooldown($this, $player->getName() . $name, $duration, $args, $onTick, $onClose);
    }

    public function get(Player $player, string $name): ?Cooldown
    {
        return $this->cooldowns[$player->getName() . $name] ?? null;
    }

    public function hasCooldown(Player $player, string $name): bool
    {
        return isset($this->cooldowns[$player->getName() . $name]);
    }

    public function remove(string $name): void
    {
        unset($this->cooldowns[$name]);
    }
}