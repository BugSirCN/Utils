<?php

namespace Bugsir\Utils;

use Bugsir\Utils\Connect\Redis;
use Bugsir\Utils\Log\Product;
use Bugsir\Utils\Tools\Common;
use Bugsir\Utils\Tools\Data;
use Bugsir\Utils\Tools\File;
use Bugsir\Utils\Tools\Url;

class BugSirUtils
{
    /**
     * 连接到内部的中间件或数据库
     * @return Connect
     */
    public static function connect(): Connect
    {
        return new Connect();
    }

    /**
     * 日志
     */
    public static function logSave(): Product
    {
        return new Product();
    }

    /**
     * 工具
     */
    public static function tools()
    {

    }
}


/**
 * 连接
 */
class Connect
{
    public static function redis(): Redis
    {
        return new Redis();
    }
}

/**
 * 工具
 */
class Tools
{
    public static function common()
    {
        return new Common();
    }

    public static function data()
    {
        return new Data();
    }

    public static function file()
    {
        return new File();
    }

    public static function url()
    {
        return new Url();
    }
}