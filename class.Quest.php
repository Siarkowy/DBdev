<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Quest extends Factory
{
    static $table = 'quest_template';
    static $cache = array();

    public function __toString()
    {
        return "<a href='" . Config::dbUrl . "?quest={$this->entry}'>[{$this->Name}]</a>";
    }
}
