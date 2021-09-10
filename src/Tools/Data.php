<?php

namespace Bugsir\Utils\Tools;

class Data
{
    /**
     * 判断是否为json
     * @param $string
     * @return bool
     */
    public function isJson($string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 标准化输出数据
     * @param int $code
     * @param string $msg
     * @param array $data
     * @param bool $echoJson
     * @return array
     */
    public function returnMsg(int $code, string $msg = '', array $data = [], $echoJson = false)
    {
        $ret = ['code' => $code, 'msg' => $msg, 'data' => $data];

        if ($echoJson) {
            header('content-type:application/json');
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            return $ret;
        }
    }
}