<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class ScriptRegistry extends Factory
{
    static $cache = array();
    static $table = 'creature_ai_scripts';

    public $data = array();

    public static function get($id)
    {
        $id = (int) $id;

        if ($id <= 0)
            return NULL;

        if ($o = @static::$cache[$id])
            return $o;

        $ai = new ScriptRegistry;
        $table = static::$table;
        $stmt = self::$pdo->query("SELECT * FROM `creature_ai_scripts` WHERE `entryOrGUID` = {$id}");
        $ai->data = $stmt->fetchAll(PDO::FETCH_CLASS, 'Event');
        static::$cache[$id] = $ai;

        return $ai;
    }
}
