<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class GameEvent extends Factory
{
    static $table = 'game_event';
    static $cache = array();

    public function __toString()
    {
        return $this->description;
    }
}
