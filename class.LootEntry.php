<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class LootEntry
{
    // caching in LootTemplate
    public $ref;

    public function __construct()
    {
        if ($this->mincountOrRef < 0)
            $this->ref = ReferenceLootTemplate::get(-$this->mincountOrRef);
    }

    public function getItem()
    {
        return Item::get($this->item);
    }

    public function __toString()
    {
        return sprintf('%s %d%%', $this->getItem(), $this->ChanceOrQuestChance);
    }
}
