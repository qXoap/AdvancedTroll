<?php

namespace xoapp\troll\forms;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\PotionType;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use xoapp\troll\library\muqsit\invmenu\InvMenu;
use xoapp\troll\library\muqsit\invmenu\type\InvMenuTypeIds;

class TrollInventory
{

    public static function send(Player $player, Player $iplayer): void
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);

        $inventory = $menu->getInventory();

        /*
         * base option ideas By https://github.com/nxpinhum5326
         */

        $menu->setName($iplayer->getName() . " Troll Menu");

        $fake_damage = VanillaItems::REDSTONE_DUST();
        $fake_damage->setCustomName("§cFake Damage");

        $fake_explode = VanillaBlocks::TNT()->asItem();
        $fake_explode->setCustomName("§cFake TNT Explode");

        $crash = VanillaBlocks::BARRIER()->asItem();
        $crash->setCustomName("§cCrash");

        $fake_ban = VanillaItems::SPLASH_POTION()->setType(PotionType::POISON);
        $fake_ban->setCustomName("§cFake Ban");

        $flip = VanillaItems::STICK();
        $flip->setCustomName("§cFlip");

        $block_inventory = VanillaBlocks::CHEST()->asItem();
        $block_inventory->setCustomName("§cBlock Inventory §7(10 Seconds)");

        $levitation = VanillaItems::FEATHER();
        $levitation->setCustomName("§cLevitation §7(5 Seconds)");



    }
}