<?php

declare(strict_types=1);

namespace xoapp\troll\library\muqsit\invmenu\type\util\builder;

use xoapp\troll\library\muqsit\invmenu\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}