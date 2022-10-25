<?php

namespace app\common\wechat\messages\template\homework;

use app\common\wechat\messages\template\Driver;
use app\admin\model\Homework;

/**
 * 作业提醒通知
 */
class Remind extends Driver
{
    protected $name = 'homework.remind';

    public function getDataByUser($user)
    {
        return [
            'first' => sprintf('%s同学有作业未完成', $user['nickname']),
            'keyword1' => $user['group_name'],
            'keyword2' => $this->origin['title'],
            'keyword3' => sprintf('%s（共有%s个文件）', html_entity_decode(strip_tags($this->origin['content'])), $this->origin['resources_num']),
            'remark' => '作业还没有完成，要抓紧时间哦。',
        ];
    }

    protected function setOrigin($origin)
    {
        $this->origin = Homework::field('title,content,resources')
            ->find($origin['homework_id'])
            ->withAttr('resources_num', function ($value, $data) {
                return count($data['resources']);
            })
            ->append(['resources_num'])
            ->toArray();
    }
}
