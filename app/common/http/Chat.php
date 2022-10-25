<?php

/**
 * Created by PhpStorm.
 * User: tengteng
 * Date: 2021-06-01
 * Time: 14:15
 */

namespace app\common\http;


use app\admin\model\FrontUser;
use app\admin\model\Room;
use app\common\model\Company;
use app\gateway\model\UserAccount;
use think\Exception;
use think\Paginator;
use app\common\exception\LiveException;

class Chat extends WebApi
{
    const NO_ERROR = true;

    const RoleVK = [
        98 => 2
    ];

    /**
     * @param $id
     * @param $page
     * @param int $limit
     * @return mixed
     * @throws Exception
     */
    public function getList($id, $page, $limit = 50)
    {
        $room = Room::field(['live_serial', 'company_id'])->find($id);

        $serial = $room['live_serial'];

        $params = [
            'serial' => $serial,
            'version' => 1
        ];
        if ($page !== false) {
            $params['page'] = $page;
            $params['limit'] = $limit;
            $url = '/WebAPI/getchatlist';
        } else {
            $url = sprintf('/WebAPI/getchatlist?key=%s', Company::cache(true)->find($room['company_id'])['authkey']);
        }
        $res = self::httpPost($url, $params);

        if (isset($res['result']) && $res['result'] > 0 && $res['result'] != 4007) {
            throw new LiveException(lang(config('live.lives.talk.error_code')[$res['result']] ?? $res['msg'] ?? '服务异常'), $res['result']);
        }
        if ($res['result'] < 0 || $res['result'] == 4007) {
            $res['data'] = [];
            $res['pageList']['total'] = 0;
        }


        if ($page === false) {

            return self::getLogs($res['data'], $page);
        } else {
            return Paginator::make(self::getLogs($res['data'], true), $limit, $page, $res['pageList']['total']);
        }
    }

    /**
     * @param $obj
     * @param bool $isImage //是否分页
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getLogs($obj, $isImage = false)
    {
        $liveUserid = [];

        foreach ($obj as $k => $v) {
            $obj[$k]['icon'] = '';
            $liveUserid[] = $v['fromID'];
        }

        $userIds = UserAccount::whereIn('live_userid', $liveUserid)->column('live_userid', 'id');

        $userImages = [];
        //去获取图像
        $userImages = [];
        if (!empty($userIds)) {

            FrontUser::field(['user_account_id', 'username', 'avatar', 'userroleid', 'sex'])
                ->whereIn('user_account_id', array_values(array_flip($userIds)))
                ->append(['http_avatar'])
                ->select()
                ->each(function ($value) use (&$userImages, $userIds) {
                    if (isset(FrontUser::RoleVK[$value->userroleid])) {
                        $key = sprintf("%s-%s", $userIds[$value->user_account_id], FrontUser::RoleVK[$value->userroleid]);
                    } else {
                        $key = sprintf("%s", $userIds[$value->user_account_id]);
                    }
                    $userImages[$key]['userico'] = $value->http_avatar;
                    $userImages[$key]['nickname'] = $value->username;
                });
        }

        foreach ($obj as $kk => $value) {

            $msg = '';

            if (is_array($value['msg'])) {

                if (!isset($value['msg'][0])) {
                    $value['msg'] = [$value['msg']];
                }
                foreach ($value['msg'] as $vvv) {

                    if ($isImage === false) {

                        if ($vvv['type'] == 'text') {
                            $msg .= $vvv['context'];
                        }
                        if ($vvv['type'] == 'img') {
                            $msg .= sprintf("%s;", $vvv['context']);
                        }
                        if ($vvv['type'] == 'em') {
                            $msg .= sprintf("%s;", $vvv['context']);
                        }
                    } else {

                        if ($vvv['type'] == 'text') {
                            $msg .= $vvv['context'];
                        }
                        if ($vvv['type'] == 'img') {
                            $msg .= sprintf("<img class='user_images'  src='%s'>", $vvv['context']);
                        }
                        if ($vvv['type'] == 'em') {
                            $msg .= sprintf("<img class='user_eem'  src='%s'>", $vvv['context']);
                        }
                    }
                }

                $obj[$kk]['msg'] = $msg;
            }


            $role = self::RoleVK[$value['role']] ?? $value['role'];
            if (in_array($role, FrontUser::RoleVK)) {
                $key = sprintf("%s-%s", $value['fromID'], $role);
            } else {
                $key = sprintf("%s", $value['fromID']);
            }
            $obj[$kk]['icon'] = isset($userImages[$key]) ? $userImages[$key]['userico'] : '';
            $obj[$kk]['role_name'] = get_role_name($value['role']);
            $obj[$kk]['ts'] = date('Y-m-d H:i:s', intval(ceil(intval($value['ts']) / 1000)));
        }

        return $obj;
    }
}
