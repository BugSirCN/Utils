<?php

namespace Bugsir\Utils\Tools;

class Request
{
    /**
     * 获取协议类型
     */
    public function getProtocol(): string
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }

    /**
     * 获取域名
     */
    public function getHost(): string
    {
        return $_SERVER["HTTP_HOST"];
    }

    /**
     * 获取参数
     */
    public function getParams(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * 获取完整URL
     */
    public function getFullUrl(): string
    {
        return $this->getProtocol() . $this->getHost() . $this->getParams();
    }

}