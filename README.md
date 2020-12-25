# 服务配置

[![GitHub release](https://img.shields.io/github/release/raylin666/config.svg)](https://github.com/raylin666/config/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207.2-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.2

### 安装说明

```
composer require "raylin666/config"
```

### 使用方式

```php

<?php

require_once 'vendor/autoload.php';

$container = new \Raylin666\Container\Container();

$container->singleton(\Raylin666\Contract\ConfigInterface::class, function ($container) {
    return (new \Raylin666\Config\ConfigFactory(__DIR__))($container);
});


$container->get(\Raylin666\Contract\ConfigInterface::class);

```

### 测试

### 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/config/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

### License MIT
