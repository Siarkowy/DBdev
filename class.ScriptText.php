<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class ScriptText extends Factory
{
    static $table = 'creature_ai_texts';
    static $cache = array();
    static $negativeEntries = true;

    public function __toString()
    {
        return "&ldquo;{$this->content_default}&rdquo;";
    }
}
