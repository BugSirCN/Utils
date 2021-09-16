<?php

namespace Bugsir\Utils\Connect;

/**
 * redis链接
 */
class Redis
{
    protected \Redis $redisClass;
    protected int $index;
    protected string $host;
    protected int $port;
    protected string $password;
    protected int $timeout;
    protected bool $pConnect;

    const ENUM_INDEX_DEFAULT = 0;
    const ENUM_INDEX_SERVER = 1;//后端服务库（存储各服务运行、鉴权相关参数）
    const ENUM_INDEX_SESSION = 10;//会话库
    const ENUM_INDEX_SMS_AND_VERIFY = 11;//短信与认证库
    const ENUM_INDEX_CACHE = 12;//缓存库
    const ENUM_INDEX_LOCK = 13;//全局锁库
    const ENUM_INDEX_LOG = 15;//日志库

    protected static $instancePool = [];//实例池子

    public function __construct()
    {
        $this->redisClass = new \Redis();
        $this->_initConfig();
    }

    protected function _initConfig()
    {
        $this->index = self::ENUM_INDEX_DEFAULT;
        $this->host = '127.0.0.1';
        $this->port = 6379;
        $this->timeout = 5;
        $this->password = '';
        $this->pConnect = false;
    }

    /**
     * 库
     * @param int $index
     * @return $this
     */
    public function setIndex(int $index): Redis
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): Redis
    {
        $this->host = $host;
        return $this;
    }

    /**
     * 端口
     * @param int $port
     * @return $this
     */
    public function setPort(int $port): Redis
    {
        $this->port = $port;
        return $this;
    }

    /**
     * 密码
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): Redis
    {
        if (!empty($password)){
            $this->password = $password;
        }
        return $this;
    }

    /**
     * 超时时间
     * @param int $timeout
     * @return $this
     */
    public function setTimeout(int $timeout): Redis
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 是否是长连接
     * @param bool $pConnect
     * @return $this
     */
    public function setPConnect(bool $pConnect): Redis
    {
        $this->pConnect = $pConnect;
        return $this;
    }

    /**
     * TODO[T]检查长链接时，向多个库存入数据时，是否会只存到最后一个库
     * TODO[M]增加一个instance的方法，帮助使用者防止重复实例化（同一个IP、port、index视为一个实例）
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


        //恢复默认值
        $this->_initConfig();

        return $this->redisClass;
    }

}