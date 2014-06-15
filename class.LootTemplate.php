<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class LootTemplate extends Factory
{
    static $cache = array();
    public $data = array();

    public static function get($id)
    {
        $id = (int) $id;

        if ($id <= 0)
            return NULL;

        if ($o = @static::$cache[$id])
            return $o;

        $loot = new LootTemplate;
        $table = static::$table;
        $stmt = self::$pdo->query("SELECT * FROM `{$table}` WHERE `entry` = {$id} ORDER BY `mincountOrRef` DESC, `groupid` ASC, `entry` ASC");
        $loot->data = $stmt->fetchAll(PDO::FETCH_CLASS, 'LootEntry');
        static::$cache[$id] = $loot;

        return $loot;
    }

    public function asTableRows()
    {
        $ret = '';

        foreach ($this->data as $entry)
            if ($entry->ref)
            {
                $id = abs($entry->mincountOrRef);
                $ret .= <<<END
    <tr>
        <th colspan="2"><span class="glyphicon glyphicon-chevron-down"></span> Reference to {$id}</th>
        <th>{$entry->groupid}</th>
        <th>{$entry->ChanceOrQuestChance}</th>
    </tr>
{$entry->ref->asTableRows()}
END;
            }
            else
            {
                $count = $entry->mincountOrRef;
                if ($entry->maxcount != $entry->mincountOrRef)
                    $count .= '&mdash;' . $entry->maxcount;
                $cond = Utils::getLootCondition($entry->lootcondition, $entry->condition_value1, $entry->condition_value2);
                $chance = sprintf(Config::lootChance, abs($entry->ChanceOrQuestChance), $entry->ChanceOrQuestChance < 0 ? ' quest' : '');
                $ret .= <<<END
    <tr>
        <td>{$entry->getItem()} x{$count}</td>
        <td>{$cond}</td>
        <td>{$entry->groupid}</td>
        <td>{$chance}</td>
    </tr>\n
END;
            }

        return $ret;
    }

    public function __toString()
    {
        return <<<END
<table class="table table-condensed table-striped">
    <tr>
        <th>Item</th>
        <th>Cond.</th>
        <th>Grp.</th>
        <th>%</th>
    </tr>
{$this->asTableRows()}
</table>\n
END;
    }
}
