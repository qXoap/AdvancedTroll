<?php

declare(strict_types=1);

namespace xoapp\troll\library\muqsit\invmenu\type\graphic\network;

use pocketmine\network\mcpe\protocol\ContainerOpenPacket;
use xoapp\troll\library\muqsit\invmenu\session\InvMenuInfo;
use xoapp\troll\library\muqsit\invmenu\session\PlayerSession;

final class WindowTypeInvMenuGraphicNetworkTranslator implements InvMenuGraphicNetworkTranslator{

	public function __construct(
		readonly private int $window_type
	){}

	public function translate(PlayerSession $session, InvMenuInfo $current, ContainerOpenPacket $packet) : void{
		$packet->windowType = $this->window_type;
	}
}