<?php

declare(strict_types=1);

namespace xoapp\troll\library\muqsit\invmenu\session\network\handler;

use Closure;
use xoapp\troll\library\muqsit\invmenu\session\network\NetworkStackLatencyEntry;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}