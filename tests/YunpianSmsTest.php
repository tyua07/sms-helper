<?php

// +----------------------------------------------------------------------
// | date: 2016-11-13
// +----------------------------------------------------------------------
// | YunpianSmsTest.php: 云片短信测试测试
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

use PHPUnit\Framework\TestCase;
use Yangyifan\Sms\YunpianSms;

class YunpianSmsTest extends TestCase
{

    /**
     * 短信 对象
     *
     * @var YunpianSms
     */
    protected static $sms    ;

    public static function setUpBeforeClass()
    {
        $config                 = require dirname(__DIR__) . '/src/config.php';
        $config                 = $config['sms']['yunpian'];
        $config['apikey']       = file_get_contents(__DIR__ . '/.yunpian_api_key');
        static::$sms            = new YunpianSms($config);
    }

    public static function tearDownAfterClass()
    {
        static::$sms = NULL;
    }

    public function testSigleSend()
    {
       $this->assertTrue( static::$sms->sendSmsForOnce('', ''));
    }

}