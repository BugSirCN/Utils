<?php

namespace Bugsir\Utils\Connect;


class Redis
{
    protected \Redis $redisClass;
    protected int $index;
    protected string $host;
    protected int $port;
    protected string $password;
    protected int $timeout;
    protected bool $pConnect;

    const ENUM_DB_DEFAULT = 0;
    const ENUM_DB_SERVER = 1;//后端服务库（存储各服务运行、鉴权相关参数）
    const ENUM_DB_CACHE = 10;//缓存库
    const ENUM_DB_LOCK = 13;//全局锁库
    const ENUM_DB_SMS_AND_VERIFY = 14;//短信与认证库
    const ENUM_DB_LOG = 15;//日志库

    public function __construct()
    {
        $this->redisClass = new \Redis();
        $this->_initConfig();
    }

    protected function _initConfig()
    {
        $this->index = self::ENUM_DB_DEFAULT;
        $this->host = '127.0.0.1';
        $this->port = 6379;
        $this->timeout = 5;
        $this->password = '';
        $this->pConnect = false;
    }

    public function setIndex($index): Redis
    {
        $this->index = $index;
        return $this;
    }

    public function setHost($host): Redis
    {
        $this->host = $host;
        return $this;
    }

    public function setPort($port): Redis
    {
        $this->port = $port;
        return $this;
    }

    public function setPassword($password): Redis
    {
        $this->password = $password;
        return $this;
    }

    public function setTimeout($timeout): Redis
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function setPConnect(bool $pConnect): Redis
    {
        $this->pConnect = $pConnect;
        return $this;
    }

    /**
     * TODO[T]检查长链接时，向多个库存入数据时，是否会只存到最后一个库
     * @link https://blog.csdn.net/fenglailea/article/details/78685965
     */
    public function startConnect(): \Redis
    {
        if ($this->pConnect) {
            $this->redisClass->pconnect($this->host, $this->port, $this->timeout);
        } else {
            $this->redisClass->connect($this->host, $this->port, $this->timeout);
        }
        if (!empty($this->password)) {
            $this->redisClass->auth($this->password);
        }
        $this->redisClass->select($this->index);
        //$redis->setOption($redis::OPT_SERIALIZER, $redis::SERIALIZER_IGBINARY);

        $this->_initConfig();

        return $this->redisClass;
    }

}