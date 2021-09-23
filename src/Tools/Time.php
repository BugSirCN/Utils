<?php

namespace Bugsir\Utils\Tools;

use Exception;

/**
 * 时间工具
 */
class Time
{
    const ENUM_TIMESTAMP_TYPE_LAST_MONTH = 'LAST_MONTH';//上月时间戳
    const ENUM_TIMESTAMP_TYPE_THIS_MONTH = 'THIS_MONTH';//本月时间戳
    const ENUM_TIMESTAMP_TYPE_NEXT_MONTH = 'NEXT_MONTH';//下月时间戳

    const ENUM_TIMESTAMP_TYPE_LAST_YEAR = 'LAST_YEAR';//去年时间戳
    const ENUM_TIMESTAMP_TYPE_THIS_YEAR = 'THIS_YEAR';//今年时间戳
    const ENUM_TIMESTAMP_TYPE_NEXT_YEAR = 'NEXT_YEAR';//明年时间戳

    const ENUM_TIMESTAMP_TYPE_LAST_WEEK = 'LAST_WEEK';//上周时间戳
    const ENUM_TIMESTAMP_TYPE_THIS_WEEK = 'THIS_WEEK';//本周时间戳
    const ENUM_TIMESTAMP_TYPE_NEXT_WEEK = 'NEXT_WEEK';//下周时间戳

    /**
     * 近期时间改为"人话"，比如X秒前、X天后
     * @param int $unixTime 需要转义的时间
     * @param null|int $nowTime 当前时间（转义时间会和当前时间比较，决定如何描述）
     * @param false $needSecond 是否需要秒字段，例如：true时展示"昨天17:00:01"，false时展示"昨天17:00"
     * @return false|string
     */
    public function humanText($unixTime, $nowTime = null, $needSecond = false)
    {
        if (is_null($nowTime)) {
            $nowTime = time();
        }

        $tempDay = 'Y-m-d';
        if (date('Y', $unixTime) === date('Y', $nowTime)) {
            $tempDay = 'm-d';
        }
        $tempTime = 'H:i';
        if ($needSecond) {
            $tempTime = 'H:i:s';
        }

        if ($unixTime < strtotime('today') && $unixTime >= (strtotime('today') - 86400 * 1)) {
            return '昨天 ' . date($tempTime, $unixTime);
        } else if ($unixTime < (strtotime('today') - 86400 * 1) && $unixTime >= (strtotime('today') - 86400 * 2)) {
            return '前天 ' . date($tempTime, $unixTime);
        } else if ($unixTime >= (strtotime('today') + 86400 * 1) && $unixTime < (strtotime('today') + 86400 * 2)) {
            return '明天 ' . date($tempTime, $unixTime);
        } else if ($unixTime >= (strtotime('today') + 86400 * 2) && $unixTime < (strtotime('today') + 86400 * 3)) {
            return '后天 ' . date($tempTime, $unixTime);
        }
        //是过去的时间，还是未来的时间
        $isPast = true;
        if (($nowTime - $unixTime) < 0) {
            $isPast = false;
        }
        if (abs(($nowTime - $unixTime)) <= 60) {
            return (int)abs(($nowTime - $unixTime)) . '秒' . ($isPast ? '前' : '后');
        } else if (abs($nowTime - $unixTime) < 3600) {
            return (int)(abs($nowTime - $unixTime) / 60) . '分钟' . ($isPast ? '前' : '后');
        } else if (abs($nowTime - $unixTime) < 86400) {
            $hour = (int)(abs($nowTime - $unixTime) / 3600);
            $minute = (int)((abs($nowTime - $unixTime) - $hour * 3600) / 60);
            return $hour . '小时' . $minute . '分' . ($isPast ? '前' : '后');
        }
        return date($tempDay . ' ' . $tempTime, $unixTime);
    }

    /**
     * 获取特定时间戳
     * @throws Exception
     */
    public function getTimestamp($type, $nowTime = null)
    {
        if (is_null($nowTime)) {
            $nowTime = time();
        }

        switch ($type) {
            case static::ENUM_TIMESTAMP_TYPE_LAST_MONTH://上月
                return mktime(0, 0, 0, date('m', $nowTime) - 1, 1, date('Y', $nowTime));

            case static::ENUM_TIMESTAMP_TYPE_THIS_MONTH://本月
                return strtotime(date('Y-m', $nowTime));

            case static::ENUM_TIMESTAMP_TYPE_NEXT_MONTH://下月
                return mktime(0, 0, 0, date('m', $nowTime) + 1, 1, date('Y', $nowTime));

            case static::ENUM_TIMESTAMP_TYPE_LAST_YEAR://去年
                return mktime(0, 0, 0, 1, 1, date('Y', $nowTime) - 1);

            case static::ENUM_TIMESTAMP_TYPE_THIS_YEAR://今年
                return mktime(0, 0, 0, 1, 1, date('Y', $nowTime));

            case static::ENUM_TIMESTAMP_TYPE_NEXT_YEAR://明年
                return mktime(0, 0, 0, 1, 1, date('Y', $nowTime) + 1);

            case static::ENUM_TIMESTAMP_TYPE_LAST_WEEK://上周（周一是第一天）
                return strtotime('today', $nowTime) - 86400 * (date('N', $nowTime) + 6);

            case static::ENUM_TIMESTAMP_TYPE_THIS_WEEK://本周（周一是第一天）
                return strtotime('today', $nowTime) - 86400 * (date('N', $nowTime) - 1);

            case static::ENUM_TIMESTAMP_TYPE_NEXT_WEEK://下周（周一是第一天）
                return strtotime('today', $nowTime) - 86400 * (date('N', $nowTime) - 8);
            default:
                throw new Exception('未定义的时间类型');
        }

    }


}