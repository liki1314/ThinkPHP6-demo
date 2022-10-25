<?php

namespace app\common\wechat\messages;

use think\facade\Db;
use app\common\model\Company;
use think\facade\Log;

class BindAccountHandler implements \EasyWeChat\Kernel\Contracts\EventHandlerInterface
{
    public function handle($payload = null)
    {
        Log::write($payload);
        if (!empty($payload)) {
            if ($payload['Event'] == 'subscribe' && !empty($payload['EventKey'])) {
                $arr = explode('-', substr($payload['EventKey'], 8), 2);
                Db::name('user_account')
                    ->where('id', $arr[0])
                    ->update(['userkey' => $payload['FromUserName']]);

                if (isset($arr[1])) {
                    $welcome = Company::getDetailById($arr[1])['extra_info']['wechat']['welcome'] ?? null;
                }
            } elseif ($payload['Event'] == 'unsubscribe' && !empty($payload['FromUserName'])) {
                Db::name('user_account')
                    ->where('userkey', $payload['FromUserName'])
                    ->update(['userkey' => '']);
            }
        }

        return $welcome ?? env('wechat.welcome', '您好！欢迎关注拓课云！');
    }
}
