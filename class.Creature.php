<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Creature extends Factory
{
    static $table = 'creature_template';
    static $cache = array();

    public $ai;
    public $loot;

    public function __construct()
    {
        $this->ai = ScriptRegistry::get($this->entry);
        $this->loot = CreatureLootTemplate::get($this->lootid);
    }

    public function getShortUrl()
    {
        return "<a href='" . Config::dbUrl . "?npc={$this->entry}'>{$this->name}</a>";
    }

    public function hasAI()
    {
        return isset($this->ai) && !empty($this->ai->data);
    }

    public function __toString()
    {
        return "<a href='" . Config::dbUrl . "?npc={$this->entry}'>{$this->name}</a> <sup>{$this->entry}</sup>";
    }
}
