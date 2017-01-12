<?php

return [

    /**
     * 默认的短信引擎
     */
    'default' => env('SMS_DRIVE', 'yunpian'),

    /**
     * 是否开启 debug，如果开启 debug ，则随机取 test_mobile_list 的一个手机号码最为发送对象。
     */
    'debug' => env('SMS_DEBUG', true),

    /**
     * 如果 debug 是 true，如果执行发送短信操作的时候，会随机取当前数组的一个手机号码。
     */
    'test_mobile_list' => [],

    /**
     * 是否记录 log
     */
    'log' => env('SMS_LOG', true),

    /**
     * 短信平台设置
     */
    'sms'    => [
        'yunpian' => [
            'drive'             => 'yunpian',
            'apikey'            => env('YUNPIAN_API_KEY', ''),
        ],
    ],
];