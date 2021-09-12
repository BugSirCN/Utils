<?php

namespace Bugsir\Utils\Tools;

/**
 * 时间工具
 */
class Time
{
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
}