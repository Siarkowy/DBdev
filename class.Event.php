<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Event extends Factory
{
    public static function get($id = 0)
    {
        $id = (int) $id;

        if ($id <= 0)
            return NULL;

        $stmt = self::$pdo->query("SELECT * FROM `creature_ai_scripts` WHERE `id` = {$id}");
        return $stmt->fetchObject(get_class());
    }

    public function __construct($data = null)
    {
        if (is_null($data))
            return;

        $this->id               = (int) $data['id'];
        $this->entryOrGUID      = (int) $data['guid'];  // unused
        $this->event_type       = (int) $data['type'];
        $this->event_inverse_phase_mask = (int) $data['invphase'];
        $this->event_chance     = (int) $data['chance'];
        $this->event_flags      = (int) @array_sum($data['flags']);
        $this->event_param1     = (int) $data['par1'];
        $this->event_param2     = (int) $data['par2'];
        $this->event_param3     = (int) $data['par3'];
        $this->event_param4     = (int) $data['par4'];
        $this->action1_type     = (int) $data['a1_type'];
        $this->action1_param1   = (int) $data['a1_par1'];
        $this->action1_param2   = (int) $data['a1_par2'];
        $this->action1_param3   = (int) $data['a1_par3'];
        $this->action2_type     = (int) $data['a2_type'];
        $this->action2_param1   = (int) $data['a2_par1'];
        $this->action2_param2   = (int) $data['a2_par2'];
        $this->action2_param3   = (int) $data['a2_par3'];
        $this->action3_type     = (int) $data['a3_type'];
        $this->action3_param1   = (int) $data['a3_par1'];
        $this->action3_param2   = (int) $data['a3_par2'];
        $this->action3_param3   = (int) $data['a3_par3'];
        $this->comment          = htmlspecialchars($data['comment']);
    }

    function save()
    {
        if ($this->id <= 0)
            $this->id = $this->getNextId();

        $stmt = self::$pdo->prepare('REPLACE INTO creature_ai_scripts ' .
            'VALUES (:id, :entryOrGUID, :event_type, '.
            ':event_inverse_phase_mask, :event_chance, :event_flags, ' .
            ':event_param1, :event_param2, :event_param3, :event_param4, ' .
            ':action1_type, :action1_param1, :action1_param2, :action1_param3, ' .
            ':action2_type, :action2_param1, :action2_param2, :action2_param3, ' .
            ':action3_type, :action3_param1, :action3_param2, :action3_param3, ' .
            ':comment)');

        return $stmt->execute((array) $this);
    }

    function getNextId()
    {
        $stmt = self::$pdo->prepare('SELECT MAX(id) AS prev FROM creature_ai_scripts WHERE entryOrGUID = :entry');
        $stmt->execute(array(':entry' => $this->entryOrGUID));
        $prev = $stmt->fetch(PDO::FETCH_OBJ)->prev;

        if (!is_null($prev))
            return ++$prev;
        else
            return $this->entryOrGUID * 100 + 1;
    }

    function getType()
    {
        return self::$events[(int) $this->event_type][0];
    }

    function getParams()
    {
        $par = self::$events[(int) $this->event_type];
        $result = array();

        for ($i = 1; $i <= 4; ++$i)
            if (@$par[$i])
                $result[] = sprintf("%s %s", $par[$i],
                    self::format($par[$i], $this->{"event_param{$i}"}));

        return implode(' &bull; ', $result);
    }

    function getActionType($id)
    {
        return self::$actions[(int) $this->{"action{$id}_type"}][0];
    }

    function getActionString($id)
    {
        $ret = array();
        $action = self::$actions[(int) $this->{"action{$id}_type"}];

        for ($i = 1; $i <= 3; ++$i)
            if (@$action[$i])
                $ret[] = /* $action[$i] . ': ' . */ self::format($action[$i], $this->{"action{$id}_param{$i}"});

        if (empty($ret))
            $ret[] = 'none';

        return implode('<br> ', $ret);
    }

    function getFlagsString()
    {
        $flags = array();

        foreach (Event::$flags as $flag => $name)
            if ($this->event_flags & $flag)
                $flags[] = $name;

        return implode(' &bull; ', $flags);
    }

    static function getNumEventActions(Event $row)
    {
        $count = 0;

        for ($id = 1; $id <= 3; ++$id)
            if ((int) $row->{"action{$id}_type"})
                ++$count;

        return $count;
    }

    public function getRaw()
    {
        ob_start();
        var_export($this);
        $raw = htmlspecialchars(ob_get_contents());
        ob_end_clean();

        return $raw;
    }

    public function getActions()
    {
        $actions = '';

        for ($id = 1; $id <= 3; ++$id)
            if ($this->{"action{$id}_type"})
                $actions .= '<dt>' . $this->getActionType($id) . '</dt>' .
                    '<dd>' . $this->getActionString($id) . '</dd>';

        return $actions !== '' ? '<dl class="dl-horizontal">' . $actions . '</dl>' : '';
    }

    static function format($type, $val)
    {
        switch ($type)
        {
            case 'CastFlags':
                $str = '';

                foreach (Utils::$CastFlags as $flag => $name)
                    if ($val & $flag)
                        $str .= $name . ' ';

                return $str;

            case 'UnitFlags':
                $str = '';

                foreach (Utils::$UnitFlags as $flag => $name)
                    if ($val & $flag)
                        $str .= $name . ' ';

                return $str;

            case 'InitMin':
            case 'InitMax':
            case 'RepMin':
            case 'RepMax':
                return $val/1000 . ' s';

            case 'Creature':
                return (string) Creature::get($val);

            case 'Spell':
                return (string) Spell::get($val);

            case 'Target':
                return Utils::$Target[$val];

            case 'Text':
                return (string) ScriptText::get($val);

            default:
                return $val;
        }
    }

    static $events = array(
        -1 => array('Unknown'),
        0 => array('Timer', 'InitMin', 'InitMax', 'RepMin', 'RepMax'),
        1 => array('Timer (OOC)', 'InitMin', 'InitMax', 'RepMin', 'RepMax'),
        2 => array('Health', 'HpMax%', 'HpMin%', 'RepMin', 'RepMax'),
        3 => array('Mana', 'MpMax%', 'MpMin%', 'RepMin', 'RepMax'),
        4 => array('Aggro'),
        5 => array('Player kill', 'RepMin', 'RepMax'),
        6 => array('Death'),
        7 => array('Evade'),
        8 => array('Spell hit', 'Spell', 'School', 'RepMin', 'RepMax'),
        9 => array('Range', 'MinDist', 'MaxDist', 'RepMin', 'RepMax'),
        10 => array('OOC LoS', 'NoHostile', 'MaxRange', 'RepMin', 'RepMax'),
        11 => array('Spawned', 'Condition', 'Value'),
        12 => array('Target health', 'HpMax%', 'HpMin%', 'RepMin', 'RepMax'),
        13 => array('Target casting', 'RepMin', 'RepMax'),
        14 => array('Friendly health', 'HpDeficit', 'Radius', 'RepMin', 'RepMax'),
        15 => array('Friendly is CC', 'DispType', 'Radius', 'RepMin', 'RepMax'),
        16 => array('Friendly missing buff', 'Spell', 'Radius', 'RepMin', 'RepMax'),
        17 => array('Summoned unit', 'Creature', 'RepMin', 'RepMax'),
        18 => array('Target mana', 'ManaMax%', 'ManaMin%', 'RepMin', 'RepMax'),
        19 => array('Quest accept', 'Quest'),
        20 => array('Quest complete', 'Quest'),
        21 => array('Reached home',),
        22 => array('Receive emote', 'EmoteId', 'Condition', 'CondVal1', 'CondVal2'),
        23 => array('Buffed', 'Spell', 'Stacks', 'RepMin', 'RepMax'),
        24 => array('Target buffed', 'Spell', 'Stacks', 'RepMin', 'RepMax'),
    );

    static $actions = array(
        0 => array('None'),
        1 => array('Text', 'Text', 'Text', 'Text'),
        2 => array('Set faction', 'FactionId'),
        3 => array('Morph', 'Entry', 'Model'),
        4 => array('Sound', 'SoundId'),
        5 => array('Emote', 'EmoteId'),
        6 => array('Random say UNUSED'),
        7 => array('Random yell UNUSED'),
        8 => array('Random textemote UNUSED'),
        9 => array('Random sound', 'Sound1', 'Sound2', 'Sound3'),
        10 => array('Random emote', 'Emote1', 'Emote2', 'Emote3'),
        11 => array('Cast', 'Spell', 'Target', 'CastFlags'),
        12 => array('Summon', 'Creature', 'Target', 'Duration'),
        13 => array('Threat single PCT', 'Threat%', 'Target'),
        14 => array('Threat all PCT', 'Threat%'),
        15 => array('Quest event', 'Quest', 'Target'),
        16 => array('Cast event', 'Quest', 'Spell', 'Target'),
        17 => array('Set field', 'FieldNum', 'Value', 'Target'),
        18 => array('Set flag', 'UnitFlags', 'Target'),
        19 => array('Remove unit flag', 'UnitFlags', 'Target'),
        20 => array('Auto attack', 'Allow'),
        21 => array('Combat movement', 'Allow'),
        22 => array('Set phase', 'PhaseId'),
        23 => array('Inc phase', 'IncValue'),
        24 => array('Evade'),
        25 => array('Flee for assist'),
        26 => array('Quest event all', 'Quest'),
        27 => array('Cast event all', 'Creature', 'Spell'),
        28 => array('Remove auras', 'Target', 'Spell'),
        29 => array('Ranged movement', 'Distance', 'Angle'),
        30 => array('Random phase', 'PhaseId1', 'PhaseId2', 'PhaseId3'),
        31 => array('Random phase range', 'PhaseMin', 'PhaseMax'),
        32 => array('Summon ID', 'Creature', 'Target', 'SpawnId'),
        33 => array('Killed monster', 'Creature', 'Target'),
        34 => array('Set inst data', 'Field', 'Data'),
        35 => array('Set inst data 64', 'Field', 'Target'),
        36 => array('Update template', 'Creature', 'Team'),
        37 => array('Die'),
        38 => array('Zone combat pulse'),
        39 => array('Call for help', 'Radius'),
        40 => array('Set sheath', 'SheathId'),
        41 => array('Force despawn'),
        42 => array('Set invincibility HP level', 'MinHpVal', 'Format'),
        43 => array('Remove corpse'),
        44 => array('Cast GUID', 'Spell', 'TargetGuid', 'CastFlags'),
        45 => array('Combat stop'),
        46 => array('Check out of threat'),

        97 => array('Set phase mask UNUSED', 'Mask'),
        98 => array('Set stand state', 'StandId'),
        99 => array('Move random point', 'Distance2d'),
        100 => array('Set visibility', 'VisiblityId'),
        101 => array('Set active', 'Toggle'),
        102 => array('Set aggressive', 'ReactId'),
        103 => array('Attack start pulse', 'Distance'),
        104 => array('Summon GO', 'Entry', 'RespawnTime'),
    );

    static $flags = array(
        0x01 => 'Repeatable',
        0x02 => 'Normal',
        0x04 => 'Heroic',
        0x08 => 'Reserved 3',
        0x10 => 'Reserved 4',
        0x20 => 'Reserved 5',
        0x40 => 'Reserved 6',
        0x80 => 'Debug',
    );
}
