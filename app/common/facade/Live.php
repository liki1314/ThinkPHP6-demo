<?php

declare(strict_types=1);

namespace app\common\facade;

use think\Facade;
use app\Request;

/**
 * @see \app\common\Live
 * @package app\common\facade
 * @mixin \app\common\Live
 * @method static array send(string $server,array $data) 
 * @method static void createRoom(array $id, int $company_id)
 * @method static void updateRoom(int $id, int $company_id)
 * @method static void createCompany($id, int $company_id, int $source)
 */
class Live extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\Live';
    }
}
