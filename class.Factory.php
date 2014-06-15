<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

abstract class Factory
{
    static $pdo;
    static $cache = array();

    public static function init()
    {
        if (self::$pdo)
            return;

        self::$pdo = new PDO('mysql:host=' . Config::dbHost .
            ';dbname=' . Config::dbName, Config::dbUser, Config::dbPass);

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function get($id)
    {
        $id = (int) $id;

        if ($id <= 0 && !isset(static::$negativeEntries))
            return NULL;

        if ($o = @static::$cache[$id])
            return $o;

        $table = static::$table;
        $stmt = self::$pdo->query("SELECT * FROM `{$table}` WHERE `entry` = {$id}");
        return $stmt->fetchObject(get_called_class());
    }

    public function validate()
    {
        foreach (static::$meta as $k => $v)
            echo "{$k} = {$v},";
    }
}
