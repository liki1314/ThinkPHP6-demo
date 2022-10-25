<?php
/**
 * Created by PhpStorm.
 * User: tengteng
 * Date: 2021-05-24
 * Time: 14:38
 */

namespace app\common\http\singleton;


use app\common\http\WebApi;

class ThemeSingleton extends WebApi
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

    public function getData()
    {

        return $this->data;
    }

    private function getHttp()
    {

        $res = self::httpGet("/WebAPI/getRoomThemeList");

        foreach ($res['list'] as $v) {
            $this->data[$v['roomthemeid']] = [
                'theme_id' => $v['roomthemeid'],
                'name' => lang($v['name']),
                'imgurl' => $v['imgurl'],
                'icontype' => $v['icontype'],
                'color' => $v['color'],
                'status' => $v['status'],
                'type' => $v['type'],
                'versiontype' => $v['versiontype']
            ];
        }
    }
}
