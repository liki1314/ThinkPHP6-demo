<?php

namespace app\common\wechat\messages\template;

use think\helper\Arr;
use EasyWeChat\Factory;
use think\facade\Cache;
use think\facade\Db;
use app\admin\model\Company;
use think\facade\Lang;

class Driver
{
    /**
     * 原始消息数据
     *
     * @var array
     */
    public $origin;

    /**
     * 消息接受者
     *
     * @var array
     */
    public $users;

    /**
     * 模板ID
     *
     * @var string
     */
    public $templateId;

    public $app;

    public $apps;
    /**
     * 通知配置信息
     *
     * @var array
     */
    protected $config = [];

    public function __construct()
    {
        Lang::load(app()->getBasePath() . 'common/lang/zh-cn.php');
    }

    /**
     * 创造发送消息需要的数据
     *
     * @param mixed $origin
     * @param int|array $front_user_id 前台账号id
     * @param int $company_id
     * @return $this
     */
    public function makeSendData($origin, $front_user_id, $company_id = 0)
    {
        $this->users = [];
        $this->setOrigin($origin);
        $company_id = $company_id ?: request()->user['company_id'];
        if ($this->checkConfig($company_id, $origin) === false) {
            return $this;
        }

        $users = Db::name('front_user')
            ->alias('a')
            ->join('user_account b', 'b.id=a.user_account_id')
            ->leftJoin('frontuser_group c', 'c.front_user_id=a.id')
            ->leftJoin('student_group d', 'd.id=c.group_id')
            ->whereIn('a.id', $front_user_id)
            ->where('a.company_id', $company_id)
            ->where('userkey', '<>', '')
            ->group('a.id')
            ->column('userkey,a.userroleid,a.nickname,d.typename as group_name,a.id');
        $this->users = [];
        foreach ($users as $user) {
            $this->users[$user['id']] = $user;
        }
        return $this;
    }

    /**
     * 检查是否满足通知条件
     *
     * @param int $company_id 企业id
     * @return boolean
     */
    public function checkConfig($company_id, $origin): bool
    {
        if (!isset($this->config[$company_id])) {
            $this->config[$company_id] = Company::getNoticeConfigByCompanyId($company_id);
        };

        if (empty($this->config[$company_id])) {
            return false;
        }

        if (!empty(Arr::get($this->config[$company_id], $this->name)['switch'])) {
            if (isset($this->apps[$company_id])) {
                $this->app = $this->apps[$company_id];
            } else {
                $this->app = $this->apps[$company_id] = Factory::officialAccount([
                    'app_id' => config('wechat.app_id'),
                    'secret' => config('wechat.secret'),
                    'token' => config('wechat.token'),
                    'response_type' => 'array',
                ]);
            }
            $this->app['cache'] = Cache::store('redis');
            return true;
        }

        return false;
    }

    // 遍历串行发送消息
    public function send()
    {
        if (empty($this->users)) {
            return false;
        }

        foreach ($this->users as $user) {
            $this->app->template_message->send([
                'touser' => $user['userkey'],
                'template_id' => config('wechat.template.' . $this->name),
                'data' => $this->getDataByUser($user),
            ]);
        }
    }

    /**
     * 获取发送消息内容
     *
     * @param array $user 账号信息
     * @return void
     */
    public function getDataByUser(array $user)
    {
        return $this->origin;
    }

    protected function setOrigin($origin)
    {
        $this->origin = $origin;
    }
}
