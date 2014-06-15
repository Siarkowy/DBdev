<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Spell extends Factory
{
    static $table = 'dbc_spell';
    static $cache = array();

    public function __toString()
    {
        $name = $this->{"SpellName[0]"};
        return "<a href='" . Config::dbUrl . "?spell={$this->entry}'>{$name}</a> <sup>{$this->entry}</sup>";
    }
}
