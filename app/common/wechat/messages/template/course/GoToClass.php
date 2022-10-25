<?php

namespace app\common\wechat\messages\template\course;

use app\admin\model\FrontUser;
use app\common\wechat\messages\template\Driver;
use think\helper\Arr;

class GoToClass extends Driver
{
    protected $name = 'course.go_to_class';

    public function getDataByUser(array $user)
    {
        return [
            'first' => $user['userroleid'] == FrontUser::STUDENT_TYPE ?
                sprintf('Hi~您报名的直播课还有%s就开始啦！', timetostr($this->origin['starttime'] - time())) :
                sprintf('老师您好，%s直播课还有%s就开始啦！', $this->origin['roomname'], timetostr($this->origin['starttime'] - time())),
            'keyword1' => $this->origin['roomname'] ?? null,
            'keyword2' => date('Y-m-d H:i:s', $this->origin['starttime'] ?? time()),
        ];
    }

    public function checkConfig($companyId,$origin): bool
    {
        $result = parent::checkConfig($companyId,$origin);

        return $result &&
            abs($origin['starttime'] - time() - Arr::get($this->config[$companyId], $this->name)['hours'] * 3600) <= 300;
    }
}
