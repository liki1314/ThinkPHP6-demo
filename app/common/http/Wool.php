<?php

namespace app\common\http;

/**
 * 创蓝智能检测接口
 */
class Wool extends Base
{

    private $_params = [];
    protected $error = '';
    protected $config = [];
    const url = 'https://api.253.com/open/wool/yzm';

    public function __construct($options = [])
    {

        $this->config = config("sdk.captcha");
    }

    /**
     * 单例
     * @param array $options 参数
     * @return Wool
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }

    /**
     * 图文验证码验证
     *
     * @return boolean
     */
    public function yzm()
    {
        $this->error = '';
        $postArr = array(
            'appId' => $this->config['appId'],
            'appKey' => $this->config['appKey'],
            'AppSecretKey' => $this->config['AppSecretKey'],
            'CaptchaAppId' => $this->config['CaptchaAppId'],
            'RendStr' => $this->_params['RendStr'],
            'Ticket' => $this->_params['Ticket'],
            'IP' => $this->_params['IP'],
        );
        $result = self::httpPost(self::url, $postArr);
        if (isset($result['code'])) {
            if ($result['code'] == "200000") {
                if ($result['data']['CaptchaCode'] == 1) {
                    return TRUE;
                } else {
                    if($result['data']['CaptchaCode'] == 8){
                        $this->error = lang("verify timeout");
                    }else{
                        $this->error = $result['data']['CaptchaMsg'];
                    }

                }

            } else {
                $this->error = $result['message'];
            }

        } else {
            $this->error = "请求异常";
        }
        return FALSE;
    }


    /**
     * 获取错误信息
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * RendStr
     * @param   string $rs 验证票据需要的随机字符串
     * @return Wool
     */
    public function randstr($rs = '')
    {
        $this->_params['RendStr'] = $rs;
        return $this;
    }

    /**
     * Ticket
     * @param   string $tk 验证票据需要的随机字符串
     * @return Wool
     */
    public function ticket($tk = '')
    {
        $this->_params['Ticket'] = $tk;
        return $this;
    }

    /**
     * IP
     * @param   string $ip 用户操作来源的外网 IP
     * @return Wool
     */
    public function ip($ip = '')
    {
        $this->_params['IP'] = $ip;
        return $this;
    }

}
