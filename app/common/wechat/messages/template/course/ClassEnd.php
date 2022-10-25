<?php

namespace app\common\wechat\messages\template\course;

use app\admin\model\FrontUser;
use think\facade\Db;
use app\common\wechat\messages\template\Driver;
use think\helper\Arr;

class ClassEnd extends Driver
{
    public $courseModel;

    protected $name = 'course.class_end';

    public function checkConfig($companyId,$origin): bool
    {
        $result = parent::checkConfig($companyId,$origin) && $origin['endtime'] < time();

        if ($result) {
            $this->origin['course']['end_lesson_num'] = Db::table(['room' => 'a', 'saas_course_lesson' => 'b'])
                ->where('b.course_id', $origin['course']['id'])
                ->whereColumn('a.serial', 'b.serial')
                ->where('endtime', '<', time())
                ->count();
        }

        return $result && $this->origin['course']['end_lesson_num'] <= Arr::get($this->config[$companyId], $this->name)['lesson_num'];
    }

    public function getDataByUser(array $user)
    {
        return [
            'first' => sprintf('您好，%s%s你所学课程即将期满（%s）。', $user['nickname'], $user['userroleid'] == FrontUser::STUDENT_TYPE ? '同学' : '老师', $this->origin['course_model']['end_lesson_num']),
            'keyword1' => $this->origin['course_model']['name'] ?? '***',
            'keyword2' => date('Y-m-d H:i:s', $this->origin['course_model']['latest_end_time'] ?? time()),
            'remark' => '您已成功完成本课程，后续课程请联系教务老师。',
        ];
    }
}
