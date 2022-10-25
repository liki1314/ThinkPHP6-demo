<?php

namespace app\common\wechat\messages\template\homework;

use app\common\wechat\messages\template\Driver;
use app\admin\model\Homework;

/**
 * 作业布置通知
 */
class Assign extends Driver
{
    protected $name = 'homework.assign';

    public function getDataByUser($user)
    {
        return [
            'first' => '您有新的作业了，请查收。',
            'keyword1' => $user['group_name'],
            'keyword2' => $this->origin['title'],
            'keyword3' => sprintf('%s（共有%s个文件）', html_entity_decode(strip_tags($this->origin['content'])), $this->origin['resources_num']),
            'remark' => '叮，请查收今天的作业，要及时完成哦～',
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
