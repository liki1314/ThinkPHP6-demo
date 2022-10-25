<?php

declare(strict_types=1);

namespace app\common;

use think\Manager;

class WechatMessageTemplate extends Manager
{
    protected $namespace;

    public function getDefaultDriver()
    {
        return 'null_message';
    }

    /**
     * 获取消息模板对象
     *
     * @param string $name
     * @return \app\common\wechat\messages\template\Driver
     */
    public function store(string $name = null)
    {
        $namespace = '\\app\\common\\wechat\\messages\\template\\';
        [$type, $name] = explode('.', $name, 2);
        $this->namespace = $namespace . $type . '\\';

        return $this->driver($name);
    }
}
