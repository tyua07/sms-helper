<?php

// +----------------------------------------------------------------------
// | date: 2015-12-25
// +----------------------------------------------------------------------
// | SmsManager: 短信
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Sms;

use InvalidArgumentException;
use Closure;

class SmsManager
{
    /**
     * sms方式
     *
     * @var array
     */
    protected $drive = [];

    /**
     * app 实例
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * 自定义扩展 sms 对象
     *
     * @var array
     */
    protected $customCreator = [];

    /**
     * 构造方法
     *
     * @param \Illuminate\Foundation\Application $app app实例
     */
    public function __construct(\Illuminate\Foundation\Application $app)
    {
        $this->app = $app;
    }

    /**
     * sms 方式
     *
     * @param null|string $name
     */
    public function drive($name = null)
    {
        return $this->sms($name);
    }

    /**
     * 获得 sms 对象
     *
     * @param null $name
     * @return object
     */
    public function sms($name = null)
    {
        $name = $name ?: $this->getDefaultName();

        return $this->drive[$name] = $this->get($name);
    }

    /**
     * 获得当前 sms 对象
     *
     * @return object
     */
    protected function get($name = null)
    {
        return isset($this->drive[$name]) ? $this->drive[$name] : $this->resolve($name);
    }

    /**
     * 设置 sms 对象
     *
     * @param $name
     * @return mixed
     */
    protected function resolve($name)
    {
        //获得配置信息
        $config = $this->getConfig($name);

        if ( isset($this->customCreator[$name]) ) {
            return $this->callCustomCreator($config);
        }

        $driver = "create" . ucfirst(strtolower($name)) . "Driver";

        if ( method_exists($this, $driver)) {
            return call_user_func_array([$this, $driver], [$config]);
        } else {
            throw new InvalidArgumentException(" [{$driver}] sms 方式不存在.");
        }
    }

    /**
     * 使用自定义扩展 sms
     *
     * @param $config
     * @return SmsAdapter
     */
    protected function callCustomCreator($config)
    {
        $drive = $this->customCreator[$config['drive']]($this->app, $config);

        if ( $drive instanceof SmsInterface ) {
            return $this->adapt($drive);
        }

        return $drive;
    }

    /**
     * 实现 sms 适配器
     *
     * @param SmsInterface $sms
     * @return SmsAdapter
     */
    protected function adapt(SmsInterface $sms)
    {
        return new SmsAdapter($sms);
    }

    /**
     * 创建云片
     *
     * @param array $config sms 配置信息
     */
    protected function createYunpianDriver($config)
    {
        return $this->adapt(
            new YunpianSms($this->app, $config)
        );
    }

    /**
     * 获得 sms 配置信息
     *
     * @param $name
     * @return mixed
     */
    protected function getConfig($name)
    {
        $name = strtolower($name);

        return $this->app['config']["sms.sms.{$name}"];
    }

    /**
     * 获得默认短信方式
     *
     * @return string
     */
    protected function getDefaultName()
    {
        return $this->app['config']['sms.default'];
    }

    /**
     * 自定义 短信 方式
     *
     * @param $drive
     * @param Closure $callback
     * @return $this
     */
    public function extend($drive, Closure $callback)
    {
        $this->customCreator[$drive] = $callback;

        return $this;
    }

    /**
     * __call 魔术方法
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->sms(), $name], $arguments);
    }
}