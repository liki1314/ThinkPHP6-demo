<?php

namespace app\common\wechat\messages\template\homework;

use app\common\wechat\messages\template\Driver;
use app\admin\model\Homework;
use app\admin\model\HomeworkRecord;

/**
 * 作业点评通知
 */
class Remark extends Driver
{
    protected $name = 'homework.remark';

    public function getDataByUser($user)
    {
        return [
            'first' => sprintf('%s点评了%s的作品', $this->origin['username'], $user['nickname']),
            'keyword1' => $this->origin['roomname'] ?? '无',
            'keyword2' => $this->origin['title'],
            'keyword3' => $this->origin['username'],
            'keyword4' => sprintf('%s（共有%s个文件）', $user['remark_content'], $user['remark_files_num']),
            'remark' => '作业点评已经完成，快去看看吧',
        ];
    }

    protected function setOrigin($origin)
    {
        $this->origin = Homework::field('h.title,k.roomname,m.username')->alias("h")
            ->leftJoin(['saas_company_user' => 'm'], 'h.company_id=m.company_id and h.create_by=m.user_account_id')
            ->leftJoin('room k', 'h.room_id=k.id')
            ->where('h.id', $origin['homework_id'])
            ->find();
    }

    public function makeSendData($origin, $front_user_id, $company_id = 0)
    {
        parent::makeSendData($origin, $front_user_id, $company_id);

        if (!empty($this->users)) {
            HomeworkRecord::where('homework_id', $origin['homework_id'])
                ->whereIn('student_id', array_keys($this->users))
                ->select()
                ->each(function ($item) {
                    $this->users[$item['student_id']]['remark_content'] = $item['remark_content'];
                    $this->users[$item['student_id']]['remark_files_num'] = is_array($item['remark_files']) ? count($item['remark_files']) : 0;
                });
        }
        return $this;
    }
}
