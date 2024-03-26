<?php

namespace xoapp\troll\forms;

use pocketmine\block\VanillaBlocks;
use pocketmine\entity\animation\HurtAnimation;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\item\PotionType;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\player\Player;
use xoapp\troll\entity\ExplodeTNT;
use xoapp\troll\library\muqsit\invmenu\InvMenu;
use xoapp\troll\library\muqsit\invmenu\transaction\InvMenuTransaction;
use xoapp\troll\library\muqsit\invmenu\transaction\InvMenuTransactionResult;
use xoapp\troll\library\muqsit\invmenu\type\InvMenuTypeIds;
use xoapp\troll\session\SessionFactory;
use xoapp\troll\utils\TrollingUtils;

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
        $nbt = $fake_damage->getNamedTag()->setString("option", "fake_damage");
        $fake_damage->setNamedTag($nbt);

        $fake_explode = VanillaBlocks::TNT()->asItem();
        $fake_explode->setCustomName("§cFake TNT Explode");
        $nbt = $fake_explode->getNamedTag()->setString("option", "fake_explode");
        $fake_explode->setNamedTag($nbt);

        $crash = VanillaBlocks::BARRIER()->asItem();
        $crash->setCustomName("§cCrash");
        $nbt = $crash->getNamedTag()->setString("option", "crash");
        $crash->setNamedTag($nbt);

        $flip = VanillaItems::STICK();
        $flip->setCustomName("§cFlip");
        $nbt = $flip->getNamedTag()->setString("option", "flip");
        $flip->setNamedTag($nbt);

        $block_inventory = VanillaBlocks::CHEST()->asItem();
        $block_inventory->setCustomName("§cBlock Inventory §7(10 Seconds)");
        $nbt = $block_inventory->getNamedTag()->setString("option", "block_inventory");
        $block_inventory->setNamedTag($nbt);

        $levitation = VanillaItems::FEATHER();
        $levitation->setCustomName("§cLevitation §7(5 Seconds)");
        $nbt = $levitation->getNamedTag()->setString("option", "levitation");
        $levitation->setNamedTag($nbt);

        $anvil = VanillaBlocks::ANVIL()->asItem();
        $anvil->setCustomName("§cSpawn Anvil In Head");
        $nbt = $anvil->getNamedTag()->setString("option", "anvil");
        $anvil->setNamedTag($nbt);

        $inventory->setContents([
            13 => $fake_damage,
            21 => $fake_explode,
            22 => $crash,
            23 => $flip,
            30 => $block_inventory,
            31 => $levitation,
            32 => $anvil
        ]);

        $menu->setListener(function (InvMenuTransaction $transaction) use ($player, $iplayer) : InvMenuTransactionResult {
            $item = $transaction->getItemClicked()->getNamedTag()->getString("option");

            if (TrollingUtils::equals($item, "fake_damage")) {
                if (!$iplayer instanceof Player) {
                    $player->sendMessage("§cThis Player is not connected");
                    $player->removeCurrentWindow();
                    return $transaction->discard();
                }

                for ($i = 0; $i < 13; $i++) {
                    $iplayer->broadcastAnimation(new HurtAnimation($iplayer), [$iplayer]);
                }

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "fake_explode")) {
                $entity = new ExplodeTNT($iplayer->getLocation());
                $entity->spawnToAll();

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "crash")) {
                $packet = RemoveActorPacket::create($iplayer->getId());
                $iplayer->getNetworkSession()->sendDataPacket($packet);

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "flip")) {
                TrollingUtils::flip($iplayer);

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "block_inventory")) {
                if (SessionFactory::getInstance()->isRegistered($iplayer)) {
                    $player->sendMessage("This player already have blocked inventory");
                    $player->removeCurrentWindow();
                    return $transaction->discard();
                }

                SessionFactory::getInstance()->register($iplayer);

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "levitation")) {
                $iplayer->getEffects()->add(new EffectInstance(VanillaEffects::LEVITATION(), 10 * 20, 2));

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            if (TrollingUtils::equals($item, "anvil")) {
                TrollingUtils::anvil($iplayer);

                $player->sendMessage("§aTrolled Successfully");
                $player->removeCurrentWindow();
                return $transaction->discard();
            }

            return $transaction->continue();
        });
        $menu->send($player);
    }
}