<?php

namespace Bugsir\Utils\Log;

class EnumParams
{
    const ENUM_ALL = [
        'm' => self::MSG,
        'c' => self::CODE,
        'f' => self::FILENAME,
        'l' => self::LINE,
        'ls' => self::LAST_SQL,
        'd' => self::DATA,
        'id' => self::ID,
        'it' => self::ID_TYPE,
        't' => self::TRACE,
        'am' => self::ALERT_MODE,
    ];//防止重复

    //尽可能短，节约空间
    const MSG = 'm';
    const CODE = 'c';
    const FILENAME = 'f';
    const LINE = 'l';
    const LAST_SQL = 'lq';
    const DATA = 'd';
    const ID = 'i';
    const ID_TYPE = 'it';
    const TRACE = 't';
    const ALERT_MODE = 'am';
}