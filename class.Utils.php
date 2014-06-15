<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

abstract class Utils
{
    static $CastFlags = array(
        0x01 => 'Interrupt previous',
        0x02 => 'Triggered',
        0x04 => 'Forced',
        0x08 => 'No flee when OOM',
        0x10 => 'Target self',
        0x20 => 'Missing aura',
    );

    static $SpawnMode = array(
        0 => 'SPAWNED_EVENT_ALWAY',
        1 => 'SPAWNED_EVENT_MAP',
        2 => 'SPAWNED_EVENT_ZONE',
    );

    static $Target = array(
        0 => 'Self',
        1 => 'Highest aggro',
        2 => 'Second aggro',
        3 => 'Last aggro',
        4 => 'Random',
        5 => 'Random not top',
        6 => 'Invoker',
        7 => 'Highest aggro w/pets',
        8 => 'Second aggro w/pets',
        9 => 'Last aggro w/pets',
        10 => 'Random w/pets',
        11 => 'Random not top w/pets',
        12 => 'Invoker not player',
        13 => 'Null',
    );

    static $UnitFlags = array(
        0x00000001 => 'UNIT_FLAG_UNKNOWN7',
        0x00000002 => 'UNIT_FLAG_NON_ATTACKABLE',
        0x00000004 => 'UNIT_FLAG_DISABLE_MOVE',
        0x00000008 => 'UNIT_FLAG_PVP_ATTACKABLE',
        0x00000010 => 'UNIT_FLAG_RENAME',
        0x00000020 => 'UNIT_FLAG_PREPARATION',
        0x00000040 => 'UNIT_FLAG_UNKNOWN9',
        0x00000080 => 'UNIT_FLAG_NOT_ATTACKABLE_1',
        0x00000100 => 'UNIT_FLAG_NOT_ATTACKABLE_2',
        0x00000200 => 'UNIT_FLAG_PASSIVE',
        0x00000400 => 'UNIT_FLAG_LOOTING',
        0x00000800 => 'UNIT_FLAG_PET_IN_COMBAT',
        0x00001000 => 'UNIT_FLAG_PVP',
        0x00002000 => 'UNIT_FLAG_SILENCED',
        0x00004000 => 'UNIT_FLAG_UNKNOWN4',
        0x00008000 => 'UNIT_FLAG_UNKNOWN13',
        0x00010000 => 'UNIT_FLAG_NOT_PL_SPELL_TARGET',
        0x00020000 => 'UNIT_FLAG_PACIFIED',
        0x00040000 => 'UNIT_FLAG_DISABLE_ROTATE',
        0x00080000 => 'UNIT_FLAG_IN_COMBAT',
        0x00100000 => 'UNIT_FLAG_TAXI_FLIGHT',
        0x00200000 => 'UNIT_FLAG_DISARMED',
        0x00400000 => 'UNIT_FLAG_CONFUSED',
        0x00800000 => 'UNIT_FLAG_FLEEING',
        0x01000000 => 'UNIT_FLAG_PLAYER_CONTROLLED',
        0x02000000 => 'UNIT_FLAG_NOT_SELECTABLE',
        0x04000000 => 'UNIT_FLAG_SKINNABLE',
        0x08000000 => 'UNIT_FLAG_MOUNT',
        0x10000000 => 'UNIT_FLAG_UNKNOWN17',
        0x20000000 => 'UNIT_FLAG_UNKNOWN6',
        0x40000000 => 'UNIT_FLAG_SHEATHE',
    );

    static function getLootCondition($type, $a, $b)
    {
        switch ((int) $type)
        {
            case 0:     return ''; // None
            case 1:     return sprintf('Aura %s %d', Spell::get($a), $b);
            case 2:     return sprintf('Item %s %d', Item::get($a), $b);
            case 3:     return sprintf('Equipped %s', Item::get($a));
            case 4:     return sprintf('Zone %d', $a);
            case 5:     return sprintf('Reputation rank %d/%d', $a, $b);
            case 6:     return sprintf('Team %d', $a);
            case 7:     return sprintf('Skill %d/%d', $a, $b);
            case 8:     return sprintf('Quest rewarded %s', Quest::get($a));
            case 9:     return sprintf('Quest taken %s', Quest::get($a));
            case 10:    return 'Argent Dawn commission';
            case 11:    return sprintf('No aura %s %d', Spell::get($a), $b);
            case 12:    return sprintf('Active event %s', GameEvent::get($a));
            case 13:    return sprintf('Instance data %d/%d', $a, $b);
        }
    }
}
