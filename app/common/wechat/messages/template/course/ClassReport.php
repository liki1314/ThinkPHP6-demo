<?php

namespace app\common\wechat\messages\template\course;

use app\admin\model\FrontUser;
use app\common\wechat\messages\template\Driver;

class ClassReport extends Driver
{
    protected $name = 'course.class_report';

    public function checkConfig($companyId,$origin): bool
    {
        $result = parent::checkConfig($companyId,$origin);

        return $result && $origin['endtime'] < time();
    }

    public function getDataByUser(array $user)
    {
        return [
            'first' => sprintf('Hi，%s%s', $user['nickname'], $user['userroleid'] == FrontUser::STUDENT_TYPE ? '同学' : '老师'),
            'keyword1' => $this->origin['course_model']['name'] ?? '***',
            'keyword2' => $this->origin['roomname'] ?? '***',
            'keyword3' => $this->origin['teacher_model']['nickname'] ?? '***',
            'keyword4' => $this->origin['start_lesson_time'] ?? '***',
            'keyword5' => timetostr($this->origin['endtime'] - $this->origin['starttime']),
            'remark' => '课堂表现已生成报告，点击我查看报告详情。',
        ];
    }
}
