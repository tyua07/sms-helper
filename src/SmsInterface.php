<?php

// +----------------------------------------------------------------------
// | date: 2016-03-11
// +----------------------------------------------------------------------
// | SmsInterface.php: 短信接口
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Sms;

use Yangyifan\Exception\InvalidArgumentException;

interface SmsInterface
{
    /**
     *  设置手机号码
     *
     * @param string $mobile 手机号码
     * @return $this
     */
    public function setMobile($mobile);

    /**
     * 获得手机号码
     *
     * @return string
     */
    public function getMobile();

    /**
     * 设置短信的内容
     *
     * @param  string $content 短信内容
     * @return $this
     */
    public function setContents($content);

    /**
     * 获得短信的内容
     *
     * @return string
     */
    public function getContents();

    /**
     * 发送单条短信
     *
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function sendSmsForOnce();

}