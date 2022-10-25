<?php

namespace app\common\http\log;

use GuzzleHttp\MessageFormatter as GuzzleHttpMessageFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MessageFormatter extends GuzzleHttpMessageFormatter
{
    public function format(
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $error = null
    ) {
        if (isset($request->getHeader('Content-Type')[0]) && strpos($request->getHeader('Content-Type')[0], 'multipart/form-data') !== false) {
            return $request->getMethod() . ' ' . $request->getUri() . ' (binary) ' . ($response ? $response->getBody() : 'NULL') . ' ' . ($response ? $response->getStatusCode() : 'NULL');
        }
        return parent::format($request, $response, $error);
    }
}
