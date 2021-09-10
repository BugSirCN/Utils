<?php

namespace Bugsir\Utils\Log;

use Bugsir\Utils\BugSirUtils;
use Bugsir\Utils\Connect\Redis;

/**
 * 日志生产方
 */
class Product
{
    const ALERT_NO = 0;//不报警
    const ALERT_CALL = 1;//电话报警
    const ALERT_SMS = 2;//短信报警
    const ALERT_DING_TALK = 11;//钉钉报警
    const ALERT_WORK_WECHAT = 12;//企业微信报警
    const ALERT_TELEGRAM = 13;//电报报警

    protected string $errorLevel = 'error';
    protected array $param = [];

    /**
     * 设置-错误信息
     * @param string $msg 错误信息
     * @return $this
     */
    public function setErrorMsg($msg): Product
    {
        $this->param['msg'] = $msg;
        return $this;
    }

    /**
     * 设置-错误代码
     * @param int $code 错误码
     * @return $this
     */
    public function setErrorCode($code): Product
    {
        $this->param['code'] = $code;
        return $this;
    }

    /**
     * 设置-错误位置
     * @param string $filename 文件名
     * @param int|null $line 行号
     * @return $this
     */
    public function setPosition($filename, $line = null): Product
    {
        $this->param['filename'] = $filename;
        if (!is_null($line)) {
            $this->param['line'] = $line;
        }
        return $this;
    }

    /**
     * 设置-最后SQL语句
     * @param string $sql
     * @return $this
     */
    public function setLastSql($sql): Product
    {
        $this->param['lsatSql'] = $sql;
        return $this;
    }

    /**
     * 设置-添加数据（ARRAY）
     * @param array|object $data
     * @return $this
     */
    public function setData($data): Product
    {
        $this->param['data'] = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * 设置-相关ID
     * @param int|string $id
     * @param null|int|string $idType ID类型名称
     * @return $this
     */
    public function setId($id, $idType = null): Product
    {
        $this->param['id'] = $id;
        if (!is_null($idType)) {
            $this->param['idType'] = $idType;
        }
        return $this;
    }

    /**
     * 设置-追踪
     * @param array|object $trace
     * @return $this
     */
    public function setTrace($trace): Product
    {
        $this->param['trace'] = json_encode($trace, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * 设置报警模式（可以同时多个）
     * @param int|array $mode
     */
    public function setAlert($mode = self::ALERT_NO): Product
    {
        $this->param['alert'] = $mode;
        return $this;
    }

    /**
     * 错误级别-fatal
     * @return $this
     */
    public function levelFatal(): Product
    {
        $this->errorLevel = 'fatal';
        return $this;
    }

    /**
     * 错误级别-error
     * @return $this
     */
    public function error(): Product
    {
        $this->errorLevel = 'error';
        return $this;
    }

    /**
     * 错误级别-warm
     * @return $this
     */
    public function warn(): Product
    {
        $this->errorLevel = 'warn';
        return $this;
    }

    /**
     * 错误级别-info
     * @return $this
     */
    public function info(): Product
    {
        $this->errorLevel = 'info';
        return $this;
    }

    /**
     * 错误级别-debug
     * @return $this
     */
    public function debug(): Product
    {
        $this->errorLevel = 'debug';
        return $this;
    }

    /**
     * TODO[L]写入目标-kafka
     */
    public function toKafka()
    {
        $this->unsetParam();
        die('暂未完善');
    }

    /**
     * 写入目标-redis
     */
    public function toRedis($queueName = 'ErrorLog', Redis $redisConnect = null)
    {
        if (is_null($redisConnect)) {
            $redisConnect = BugSirUtils::connect()::redis()->setIndex(Redis::ENUM_DB_LOG)->startConnect();
        }
        $res = $redisConnect->lPush($queueName . '::' . $this->errorLevel);
        $this->unsetParam();
        return $res;
    }

    /**
     * TODO[L]写入文件
     */
    public function toFile()
    {
        $this->unsetParam();
        die('暂未完善');
    }

    /**
     * TODO[L]写入目标-mysql
     */
    public function toMysql()
    {
        $this->unsetParam();
        die('暂未完善');

    }

    /**
     * TODO[L]写入目标-api
     */
    public function toApi()
    {
        $this->unsetParam();
        die('暂未完善');

    }

    protected function unsetParam()
    {
        unset($this->errorLevel);
        unset($this->param);
    }

}