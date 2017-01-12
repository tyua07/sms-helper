<?php

// +----------------------------------------------------------------------
// | date: 2016-03-11
// +----------------------------------------------------------------------
// | OAuthAdapter.php: OAuth适配器
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Sms;

use Yangyifan\Exception\InvalidArgumentException;

class SmsAdapter
{
    /**
     * sms对象
     *
     * @var SmsInterface
     */
    protected $sms;

    /**
     * 构造方法
     *
     * SmsAdapter constructor.
     * @param SmsInterface $sms
     * @author yangyifan <yangyifanphp@gmail.com>
     */
    public function __construct(SmsInterface $sms)
    {
        $this->sms = $sms;
    }

    /**
     *  设置手机号码
     *
     * @param string $mobile 手机号码
     * @return SmsInterface
     */
    public function setMobile($mobile)
    {
        return $this->sms->setMobile($mobile);
    }

    /**
     * 获得手机号码
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->sms->getMobile();
    }

    /**
     * 设置短信的内容
     *
     * @param  string $content 短信内容
     * @return SmsInterface
     */
    public function setContents($content)
    {
        return $this->sms->setContents($content);
    }

    /**
     * 获得短信的内容
     *
     * @return string
     */
    public function getContents()
    {
        return $this->sms->getContents();
    }

    /**
     * 发送单条短信
     *
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function sendSmsForOnce()
    {
        return $this->sms->sendSmsForOnce();
    }
}