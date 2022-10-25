<?php

declare(strict_types=1);

namespace app\common\facade;


use think\Facade;

/**
 * @see \app\common\app_terminal\messages\Template
 * @package app\common\facade
 * @mixin \app\common\app_terminal\messages\Template
 * @method static \app\common\app_terminal\messages\template\Driver store()
 */
class AppTemplate extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\app_terminal\messages\Template';
    }
}
