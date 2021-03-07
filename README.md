# A simple configuration service

[![GitHub release](https://img.shields.io/github/release/raylin666/config.svg)](https://github.com/raylin666/config/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207.0-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.0

### 安装说明

```
composer require "raylin666/config"
```

### 使用方式

```php

<?php

require_once 'vendor/autoload.php';

$config = new \Raylin666\Config\Config;

$configArray = $config->make(__DIR__);

$config($configArray);

var_dump($config->toArray());

/**
 * array(3) {
        ["path"]=>
        string(33) "/Users/raylin/Web/www/myApp"
        ["name"]=>
        string(6) "raylin"
        ["database"]=>
        array(2) {
        ["host"]=>
        string(9) "127.0.0.1"
        ["port"]=>
        int(3306)
        }
    }   
 */

```

### 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/config/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

### License MIT
