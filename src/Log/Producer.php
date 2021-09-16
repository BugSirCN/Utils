<?php

namespace Bugsir\Utils\Log;

use Bugsir\Utils\BugSirUtils;
use Bugsir\Utils\Connect\Redis;

/**
 * 日志生产方
 */
class Producer
{


    protected string $errorLevel = 'error';
    protected array $param = [];

    public function __construct()
    {

    }

    /**
     * 设置-错误信息
     * @param string $msg 错误信息
     * @return $this
     */
    public function setErrorMsg(string $msg): Producer
    {
        $this->param[EnumParams::MSG] = $msg;
        return $this;
    }

    /**
     * 设置-错误代码
     * @param int $code 错误码
     * @return $this
     */
    public function setErrorCode(int $code): Producer
    {
        $this->param[EnumParams::CODE] = $code;
        return $this;
    }

    /**
     * 设置-错误位置
     * @param string $filename 文件名
     * @param int|null $line 行号
     * @return $this
     */
    public function setPosition(string $filename, ?int $line = null): Producer
    {
        $this->param[EnumParams::FILENAME] = $filename;
        if (!is_null($line)) {
            $this->param[EnumParams::LINE] = $line;
        }
        return $this;
    }

    /**
     * 设置-最后SQL语句
     * @param string $sql
     * @return $this
     */
    public function setLastSql(string $sql): Producer
    {
        $this->param[EnumParams::LAST_SQL] = $sql;
        return $this;
    }

    /**
     * 设置-添加数据（ARRAY）
     * @param array|object $data
     * @return $this
     */
    public function setData($data): Producer
    {
        $this->param[EnumParams::DATA] = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * 设置-相关ID
     * @param int|string $id
     * @param null|int|string $idType ID类型名称
     * @return $this
     */
    public function setId($id, $idType = null): Producer
    {
        $this->param[EnumParams::ID] = $id;
        if (!is_null($idType)) {
            $this->param[EnumParams::ID_TYPE] = $idType;
        }
        return $this;
    }

    /**
     * 设置-追踪
     * @param array|object $trace
     * @return $this
     */
    public function setTrace($trace): Producer
    {
        $this->param[EnumParams::TRACE] = json_encode($trace, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * 设置报警模式（可以同时多个）
     * @param int|array $mode
     */
    public function setAlert($mode = EnumAlertType::ALERT_NO): Producer
    {
        $this->param[EnumParams::ALERT_MODE] = $mode;
        return $this;
    }

    /**
     * 错误级别-fatal
     * @return $this
     */
    public function levelFatal(): Producer
    {
        $this->errorLevel = EnumLevel::FATAL;
        return $this;
    }

    /**
     * 错误级别-error
     * @return $this
     */
    public function levelError(): Producer
    {
        $this->errorLevel = EnumLevel::ERROR;
        return $this;
    }

    /**
     * 错误级别-warm
     * @return $this
     */
    public function levelWarn(): Producer
    {
        $this->errorLevel = EnumLevel::WARN;
        return $this;
    }

    /**
     * 错误级别-info
     * @return $this
     */
    public function levelInfo(): Producer
    {
        $this->errorLevel = EnumLevel::INFO;
        return $this;
    }

    /**
     * 错误级别-debug
     * @return $this
     */
    public function levelDebug(): Producer
    {
        $this->errorLevel = EnumLevel::DEBUG;
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
        //如果没有指定redis连接，使用默认值
        if (is_null($redisConnect)) {
            $redisConnect = BugSirUtils::connect()::redis()->setIndex(Redis::ENUM_INDEX_LOG)->startConnect();
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