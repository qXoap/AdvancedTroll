<?php

namespace xoapp\troll\library\cooldown;

use xoapp\troll\Loader;

class Manager
{

    public function __construct(Loader $main)
    {
        new TaskManager($main);
    }
}