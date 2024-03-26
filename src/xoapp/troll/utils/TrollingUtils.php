<?php

namespace xoapp\troll\utils;

use pocketmine\block\Anvil;
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\format\io\region\PMAnvil;
use pocketmine\world\Position;

class TrollingUtils
{

    public static function flip(Player $player): void
    {
        $startPosition = $player->getPosition();
        $destination = new Position($player->getPosition()->getX(), $player->getPosition()->getY() + 200, $player->getPosition()->getX(), $player->getWorld());
        $distance = $destination->distance($startPosition);
        $direction = $destination->subtract($startPosition->x, $startPosition->y, $startPosition->z)->normalize();

        for ($i = 1; $i <= 10; $i++) {
            $offset = $direction->multiply($distance * ($i / 10));
            $position = $startPosition->add($offset->x, $offset->y, $offset->z);

            $packet = new MovePlayerPacket();
            $packet->actorRuntimeId = $player->getId();
            $packet->position = $position;
            $packet->yaw = $player->getLocation()->getYaw();
            $packet->pitch = $player->getLocation()->getPitch();
            $packet->headYaw = 0.0;
            $packet->onGround = $player->isOnGround();
            $player->getNetworkSession()->sendDataPacket($packet);

            usleep(100000);
        }

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