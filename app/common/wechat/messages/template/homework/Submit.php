<?php

namespace app\common\wechat\messages\template\homework;

use app\common\wechat\messages\template\Driver;

/**
 * 作业提交通知
 */
class Submit extends Driver
{
    protected $name = 'homework.submit';

    public function makeSendData($origin, $front_user_id, $company_id = 0)
    {
        $this->users = [];
        return $this;
    }
}
