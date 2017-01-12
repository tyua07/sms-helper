<?php

// +----------------------------------------------------------------------
// | date: 2016-12-09
// +----------------------------------------------------------------------
// | YunpianSms.php: 云片发送短信库
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Sms;

use Yangyifan\Exception\InvalidArgumentException;

class YunpianSms implements SmsInterface
{
    use Sms;

    const SIGNLE_URL = 'https://sms.yunpian.com/v2/sms/single_send.json'; // 单条发送接口 url

    /**
     * 配置信息
     *
     * @var  array
     */
    protected $config;

    /**
     * app 实例
     *
     * @var
     */
    protected $app;

    /**
     * YunpianSms constructor.
     *
     * @param array $config 配置信息
     * @param \Illuminate\Foundation\Application $app app 实例
     */
    public function __construct(\Illuminate\Foundation\Application $app, array $config)
    {
        $this->config   = $config;
        $this->app      = $app;
    }

    /**
     * 发送单条短信
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function sendSmsForOnce()
    {
        // 发送短信之前执行的方法
        if ($this->beforeEvent() === false) {
            return false;
        }

        $ch = curl_init();

        curl_setopt ($ch, CURLOPT_URL, self::SIGNLE_URL);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'text'      => $this->getContents(),
            'apikey'    => $this->config['apikey'],
            'mobile'    => $this->getMobile(),
        ]));

        $json_data = curl_exec($ch);

        curl_close($ch);

        // 返回响应
        return $this->parseResponse(json_decode($json_data, true));
    }

    /**
     * 解析响应
     *
     * @param $response
     * @return boolean
     * @throws InvalidArgumentException
     */
    protected function parseResponse($response)
    {
        // 发送短信之后执行的事件
        if ( $this->afterEvent($response) === false ) {
            return false;
        }

        if ( !empty($response) && isset($response['code']) ) {

            switch ( $response['code'] ) {
                case 0:
                    return true;
                case 8 :
                case 9 :
                case 22 :
                case -5 :
                case -51 :
                case 33:
                    throw new InvalidArgumentException('发送短信太频繁，请稍后再试！');
            }
        }
        return false;
    }
}