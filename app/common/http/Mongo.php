<?php

declare(strict_types=1);

namespace app\common\http;

class Mongo extends Base
{
    protected $name = 'app.mongo_host';

    public static function httpGet($url, $query = [])
    {

        //mongo_secret
        $query['stamp'] = time();
        $query['token'] = self::getToken($query['stamp']);
        return self::httpGet($url, $query);
    }

    public static function httpJson(string $url, array $data = [], array $query = [], $method = 'POST')
    {
        $data['stamp'] = time();
        $data['token'] = self::getToken($data['stamp']);
        return self::httpJson($url, $data, $query, $method);
    }

    public static function getToken($stamp)
    {
        return md5(sprintf("%s-%s", config("app.mongo_secret"), $stamp));
    }
}
