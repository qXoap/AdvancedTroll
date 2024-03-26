<?php

namespace xoapp\troll\entity;

use pocketmine\entity\object\PrimedTNT;
use pocketmine\event\entity\EntityPreExplodeEvent;
use pocketmine\world\Explosion;
use pocketmine\world\Position;
use pocketmine\world\sound\FizzSound;

class ExplodeTNT extends PrimedTNT
{
    /*
     * Code from https://github.com/nxpinhum5326
     */

    public function explode(): void
    {
        $ev = new EntityPreExplodeEvent($this, 4);
        $ev->call();
        if (!$ev->isCancelled()) {
            $explosion = new Explosion(Position::fromObject($this->location->add(0, $this->size->getHeight() / 2, 0), $this->getWorld()), $ev->getRadius(), $this);
            $explosion->explodeB();
            $this->getWorld()->addSound($this->getPosition()->asVector3(), new FizzSound());
        }
    }
}