<?php
/**
 * Created by PhpStorm.
 * User: tengteng
 * Date: 2021-05-21
 * Time: 16:42
 */

namespace app\common\http;


class CompanyHttp extends WebApi
{
    /**
     * 获取教室模板配置
     * @return mixed
     */
    public function getConfig()
    {

        $res = self::httpGet("/WebAPI/getCompanyConfig");

        return $res['data'];
    }

    /**
     * 设置教室模板
     * @param $key
     * @param $value
     */
    public function setConfig($key, $value, $extra = [])
    {

        self::httpPost("/WebAPI/updateCompanyConfig",
            ['config' => json_encode([$key => $value]), 'configItem' => json_encode($extra)]);
    }

    /**
     * 更新企业
     * @param $data
     */
    public function update($data)
    {
        self::httpPost("/WebAPI/updateCompanyFields", $data);
    }


}
