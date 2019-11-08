# 文件配置加载

[![GitHub release](https://img.shields.io/github/release/shugachara/config.svg)](https://github.com/shugachara/config/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.0

### 安装说明

```
composer require "shugachara/config"
```

### 使用方式

<?php 
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use ShugaChara\Config\FileConfig;
use ShugaChara\Config\Repositories\Dotenv;
use ShugaChara\Container\Container;

class {
    
    public function __construct(Container $container)
    {
        $fileInfo = $this->getFileInfo(app()->getEnvFile());
        $envFactory = Dotenv::envFactory([
            new EnvConstAdapter,
            new PutenvAdapter,
            new ServerConstAdapter
        ]);
        
        // 加载.env配置,读取配置方式可以有: $_ENV \ $_SERVER \ getenv() 获取
        Dotenv::create($fileInfo['path'], $fileInfo['name'], $envFactory)->load();
        
        $container->add('config', new FileConfig());
        
        $configPath = app()->getConfigPath();

        $config = $container->get('config');

        $priorityLoadFiles = ['app'];
        // 加载基础配置
        foreach ($priorityLoadFiles as $file) {
            $config->loadFile($configPath . '/' . $file . '.php');
        }
        // 设置过滤配置文件
        $config->setFilterFile($priorityLoadFiles);
        // 加载应用主配置
        $config->loadConfig($_ENV);
        // 加载组件配置
        $config->loadPath($configPath);
    }
    
    protected function getFileInfo($file_name)
    {
        if (! file_exists($file_name)) {
            return null;
        }
        return [
            'path'      =>      dirname($file_name),
            'name'      =>      basename($file_name),
        ];
    }
}
?>

## 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/shugachara/config/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
