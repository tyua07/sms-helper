<?php

// +----------------------------------------------------------------------
// | date: 2016-03-11
// +----------------------------------------------------------------------
// | Sms.php: Sms
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Sms;

use Yangyifan\Exception\InvalidArgumentException;
use Yangyifan\Library\UtilityLibrary;
use Yangyifan\Library\LogLibrary;

trait Sms
{
    /**
     * 手机号码
     *
     * @var string
     */
    protected $mobile;

    /**
     * 短信内容
     *
     * @var string
     */
    protected $contents;

    /**
     *  设置手机号码
     *
     * @param string $mobile 手机号码
     *
     * @return $this
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * 获得手机号码
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 设置短信的内容
     *
     * @param  string $content 短信内容
     * @return $this
     */
    public function setContents($content)
    {
        $this->contents = $content;

        return $this;
    }

    /**
     * 获得短信的内容
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * 发送短信之前执行的事件
     *
     * @return boolean
     * @throws InvalidArgumentException
     */
    protected function beforeEvent()
    {
        // 如果当前环境不是生成环境，则发送的手机号码都是测试的手机号码
        if ( $this->app['config']['sms.debug'] === true ) {

            // 获取属于测试的手机号码
            $testMobile = $this->app['config']['sms.test_mobile_list'];

            if ( !UtilityLibrary::isArray($testMobile) ) {
                throw new InvalidArgumentException('测试的手机号码为空！');
            }

            // 随机获取一个测试的手机号码
            $this->setMobile($testMobile[mt_rand(0, count($testMobile) - 1)]);
        }

        if ( empty($this->getMobile()) ) {
            throw new InvalidArgumentException('手机号码不能为空！');
        }

        if ( empty($this->getContents()) ) {
            throw new InvalidArgumentException('短信内容不能为空！');
        }

        return true;
    }

    /**
     * 发送短信之后执行的事件
     *
     * @param $response
     * @return boolean
     */
    protected function afterEvent($response)
    {
        // 记录日志
        LogLibrary::debug(LogLibrary::SMS_LOG, $response);

        return true;
    }
}