<?php

namespace xoapp\troll\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use xoapp\troll\forms\TrollInventory;
use xoapp\troll\utils\TrollingUtils;

class TrollCommand extends Command
{

    public function __construct()
    {
        parent::__construct("troll");
        $this->setPermission("troll.cmd");
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if (!$player instanceof Player) return;

        if (!$this->testPermissionSilent($player)) return;

        if (!isset($args[0])) {
            $player->sendMessage("§cUsage /troll (player)");
            return;
        }

        $iplayer = TrollingUtils::getPlayerByPrefix($args[0]);

        if (is_null($iplayer)) {
            $player->sendMessage("§cThis player is not online");
            return;
        }
        
        TrollInventory::send($player, $iplayer);
    }
}