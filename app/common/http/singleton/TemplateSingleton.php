<?php
/**
 * Created by PhpStorm.
 * User: tengteng
 * Date: 2021-05-24
 * Time: 14:39
 */

namespace app\common\http\singleton;


use app\common\http\WebApi;
use think\facade\Config;
use think\facade\Lang;

class TemplateSingleton extends WebApi
{
    //创建静态私有的变量保存该类对象
    static private $instance;

    private $data;


    //防止使用clone克隆对象
    private function __clone()
    {
    }

    static public function getInstance()
    {
        //判断$instance是否是Singleton的对象，不是则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
            self::getInstance()->getHttp();
        }
        return self::$instance;
    }

    public function getLayout()
    {

        return $this->data['layout'];
    }

    public function getLayoutName()
    {

        return $this->data['layout_name'];
    }

    public function getVideo()
    {

        return $this->data['video'];
    }

    public function getLogo()
    {

        return $this->data['logo'];
    }

    public function getSetting()
    {

        return $this->data['setting'];
    }

    private function getHttp()
    {
        $res = self::httpGet("/WebAPI/getRoomSetting");
        $this->data['layout_name'] = $res['data']['layout'][1];
        $this->data['layout'] = $res['data']['layout'][2];
        $this->data['video'] = $res['data']['videotype'];
        $this->data['logo'] = $res['data']['classroomlogo'];
        $this->data['setting'] = $res['data']['functionitem'];
    }

    /**
     * 分辨率排序
     * @param $data
     */
    public function getVideoList($data)
    {
        if (!$data) {
            return $data;
        }

        $res = [];
        foreach ($data as $k => $v) {
            $res[] = ['id' => $k, 'name' => $v];
        }

        return $res;
    }

}
