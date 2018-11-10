# rongcloud-for-laravel
基于融云服务端sdk封装成laravel5包
# 推荐使用composer安装
```
composer require huangkem/rongcloud-for-laravel
```
直接下载安装，SDK 没有依赖其他第三方库，可直接下载引入使用
# 使用方法
要使用融云服务端SDK服务提供者，你必须自己注册服务提供者到Laravel服务提供者列表中。  
  
- 找到 `config/app.php` 配置文件中，key为 providers 的数组，在数组中添加服务提供者。
```
    'providers' => [
        // ...
        RongCloud\ServiceProvider::class,
    ]
```
- 找到key为 aliases 的数组，在数组中注册Facades。
```
    'aliases' => [
        // ...
        'RongCloud' => RongCloud\Facades\RongCloud::class,
    ]
```
- 运行 `php artisan vendor:publish` 命令，发布配置文件`config/rongcloud.php`到你的项目中。
  
  
- 推荐使用`.env`管理你的appKey和appSecret
```
    RONGCLOUD_APP_KEY=XXXXXXX #你的app_key
    RONGCLOUD_APP_SECRET=XXXXXXX #你的app_secret
    RONGCLOUD_FORMAT=json #默认选择json格式读取数据
```
# 例子
`test/test.php`提供了所有的 API 接口的调用用例  

```
    // 获取用户token
    $client = new RongCloud();
    $token = $client::user()->getToken('userId1', 'username', 'http://www.rongcloud.cn/images/logo.png');
    ...
```
更多使用方法，请参考融云API文档：[http://www.rongcloud.cn/docs/server.html](http://www.rongcloud.cn/docs/server.html)  

融云API错误信息参考：[https://www.rongcloud.cn/docs/server.html#api](https://www.rongcloud.cn/docs/server.html#api)  

官方sdk地址：[https://github.com/rongcloud/server-sdk-php-composer](https://github.com/rongcloud/server-sdk-php-composer)
