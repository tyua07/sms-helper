### 短信组件


### 开始

* 安装 ``` composer require yangyifan/sms-helper:v0.1 ```
* 添加 ``` \Yangyifan\Sms\SmsServiceProvider::class ``` 到 ```/config/app.php``` 文件的 
* 执行 ```php artisan vendor:publish```

### 发送短信

    app('sms')->setMobile('手机号码')->setContents('短信内容')->sendSmsForOnce();

> 注意：暂时只是支持了云片。

#### Lincense 

MIT
