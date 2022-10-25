<?php

// +----------------------------------------------------------------------
// | 日志设置
// +----------------------------------------------------------------------
return [
    // 默认日志记录通道
    'default'      => env('log.channel', 'file'),
    // 日志记录级别
    'level'        => [],
    // 日志类型记录的通道 ['error'=>'email',...]
    /* 'type_channel' => [
        'aliyun' => 'aliyun',
    ], */
    // 关闭全局日志写入
    'close'        => false,
    // 全局日志处理 支持闭包
    'processor'    => null,

    // 日志通道列表
    'channels'     => [
        'file' => [
            // 日志记录方式
            'type'           => 'File',
            // 日志保存目录
            'path'           => '',
            // 单文件日志写入
            'single'         => false,
            // 独立日志级别
            'apart_level'    => ['sql', 'error', 'rpc'],
            // 最大日志文件数量
            'max_files'      => 0,
            // 使用JSON格式记录
            'json'           => false,
            // 日志处理
            'processor'      => null,
            // 关闭通道日志写入
            'close'          => false,
            // 日志输出格式化
            'format'         => '[%s][%s] %s',
            // 是否实时写入
            'realtime_write' => false,
        ],

        // vod点播日志
        'vod' => [
            'type' => \app\common\log\Aliyun::class,
            'endpoint' => env('aliyunlog.endpoint', 'cn-beijing.log.aliyuncs.com'),
            'access_key_id' => env('aliyunlog.access_key_id', 'LTAI4G1Ea5zJS7t4z8hDFHGS'),
            'access_key_secret' => env('aliyunlog.access_key_secret', 'UhfClFgdSu4RLL8rS7j4XeLkm8CxPu'),
            'project' => env('aliyunlog.vod_project', 'tk-vod-log-test'),
            'logstore' => env('aliyunlog.vod_logstore', 'tk-vod-log-test'),
        ],

        //队列消费失败日志
        'failed_jobs' => [
            'type' => \app\common\log\Aliyun::class,
            'endpoint' => env('aliyunlog.endpoint_huanan3', 'cn-guangzhou.log.aliyuncs.com'),
            'access_key_id' => env('aliyunlog.access_key_id', 'LTAI4G1Ea5zJS7t4z8hDFHGS'),
            'access_key_secret' => env('aliyunlog.access_key_secret', 'UhfClFgdSu4RLL8rS7j4XeLkm8CxPu'),
            'project' => env('aliyunlog.school_failed_jobs_project', 'school-failed-jobs'),
            'logstore' => env('aliyunlog.school_failed_jobs_logstore', 'school-failed-jobs'),
        ],

        // 意见箱日志
        'suggestion' => [
            'type' => \app\common\log\Aliyun::class,
            'endpoint' => env('aliyunlog.endpoint_huanan3', ''),
            'access_key_id' => env('aliyunlog.access_key_id', ''),
            'access_key_secret' => env('aliyunlog.access_key_secret', ''),
            'project' => env('aliyunlog.school_suggestion_project', ''),
            'logstore' => env('aliyunlog.school_suggestion_logstore', ''),
        ],

        //腾讯异常日志
        'tx_exception_log' => [
            'type' => \app\common\log\Tencent::class,
            'secret_id' => env('tx_config.secret_id', ''),
            'secret_key' => env('tx_config.secret_key', ''),
            'topic_id' => env('tx_exception_log_topic_id.topic_id', ''),
        ],
        //腾讯定时任务日志
        'tx_crontab_log' => [
            'type' => \app\common\log\Tencent::class,
            'secret_id' => env('tx_config.secret_id', ''),
            'secret_key' => env('tx_config.secret_key', ''),
            'topic_id' => env('tx_crontab_log_topic_id.topic_id', ''),
        ]
    ],

];
