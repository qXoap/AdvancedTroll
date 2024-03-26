<?php

namespace xoapp\troll\session;

use pocketmine\player\Player;

class Session
{

    public function __construct(public Player $player) {}

}