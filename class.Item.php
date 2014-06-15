<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Item extends Factory
{
    static $table = 'item_template';
    static $cache = array();

    public function __toString()
    {
        return "<a href='" . Config::dbUrl . "?item={$this->entry}'>[{$this->name}]</a>";
    }
}
