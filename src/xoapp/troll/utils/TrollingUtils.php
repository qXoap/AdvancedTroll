<?php

namespace xoapp\troll\utils;

use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;

class TrollingUtils
{

    public static function flip(Player $player): void
    {
        $destination = new Position($player->getPosition()->getX(), $player->getPosition()->getY() + 200, $player->getPosition()->getX(), $player->getWorld());
        $player->teleport($destination);
    }

    public static function anvil(Player $player): void
    {
        $position = new Vector3($player->getPosition()->getX(), $player->getPosition()->getY() + 70, $player->getPosition()->getZ());

        $player->getPosition()->getWorld()->setBlock($position, VanillaBlocks::ANVIL());
    }

    public static function equals($data1, $data2): bool
    {
        return $data1 === $data2;
    }

    public static function getPlayerByPrefix(string $name): ?Player
    {
        $found = null;
        $name = strtolower($name);
        $delta = PHP_INT_MAX;
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (stripos($player->getName(), $name) === 0) {
                $curDelta = strlen($player->getName()) - strlen($name);
                if ($curDelta < $delta) {
                    $found = $player;
                    $delta = $curDelta;
                }
                if ($curDelta === 0) {
                    break;
                }
            }
        }
        return $found;
    }


}