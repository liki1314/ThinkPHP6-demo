<?php

declare(strict_types=1);

namespace app\common\http;

use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use think\Exception;

class HwCloud extends Base
{
    protected $name = 'filesystem.disks.hwcloud_video.endpoint';

    public function initialize()
    {
        $this->middlewares['auth'] = Middleware::mapRequest(function (RequestInterface $request) {
            date_default_timezone_set('UTC');
            $x_sdk_date = date('Ymd\THis\Z');
            $request = $request->withHeader('X-Sdk-Date', $x_sdk_date);
            $result = $this->getCanonicalRequest($request);
            $signature = hash_hmac("sha256", "SDK-HMAC-SHA256\n$x_sdk_date\n" . hash('sha256', $result['str']), config('filesystem.disks.hwcloud_video.secret'));
            $request = $request->withHeader('Authorization', 'SDK-HMAC-SHA256 Access=' . config('filesystem.disks.hwcloud_video.key') . ', SignedHeaders=' . $result['signed_headers'] . ', Signature=' . $signature);
            return $request;
        });
    }

    private function getCanonicalRequest(RequestInterface $request)
    {
        $uri = parse_url((string) $request->getUri());
        $str = $request->getMethod() . "\n" . rtrim($uri['path'], '/') . '/' . "\n" . ($uri['query'] ?? '') . "\n";

        $header = array_change_key_case($request->getHeaders());
        ksort($header);

        foreach ($header as $key => $value) {
            $str .= "$key:" . $value[0] . "\n";
        }
        $str .= "\n";
        $str .= implode(';', array_keys($header)) . "\n";
        $str .= hash('sha256', (string)$request->getBody());

        return [
            'str' => $str,
            'signed_headers' => implode(';', array_keys($header)),
        ];
    }

    protected function catchGuzzleException($e)
    {
        if ($e instanceof \GuzzleHttp\Exception\ClientException) {
            $result = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new Exception($result['error_msg'] ?? lang('unknow_error'));
        }
    }
}
