<?php

namespace Bugsir\Utils\Log;

class EnumAlertType
{
    const ALERT_NO = 0;//不报警
    const ALERT_CALL = 1;//电话报警
    const ALERT_SMS = 2;//短信报警
    const ALERT_DING_TALK = 11;//钉钉报警
    const ALERT_WORK_WECHAT = 12;//企业微信报警
    const ALERT_TELEGRAM = 13;//电报报警
}