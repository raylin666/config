<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2020 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Config;

use Symfony\Component\Finder\Finder;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Utils\Helper\ArrayHelper;

/**
 * Class Config
 * @package Raylin666\Config
 */
class Config implements ConfigInterface
{
    const CONFIG_FILE_EXT = '.php';

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @param array $configs
     */
    public function __invoke(array $configs)
    {
        $this->configs = $configs;
    }

    /**
     * @param string $path              根目录路径
     * @param string $configPathName    配置目录
     * @param string $configFileName    配置文件
     * @param string $readPathName      配置读取文件目录
     * @return array
     */
    public function make(
        string $path,
        $configPathName = 'config',
        $configFileName = 'app',
        $readPathName = 'autoload'
    ): array
    {
        /**
         * 配置文件及目录 例如: /var/www/myApp/config/config.php
         *                   /var/www/myApp/config/autoload/...php
         *
         * 目录路径结构: /var/www/myApp
         *                          /config
         *                              app.php
         *                              /autoload
         *                                  amqp.php
         *                                  database.php
         *                                  cache.php
         *                                  ...
         */

        $configPath = $path . '/' . $configPathName . '/';
        $config = $this->readConfig($configPath . $configFileName . self::CONFIG_FILE_EXT);
        $autoloadConfig = $this->readPath([$path . '/' . $configPathName . '/' . $readPathName]);

        $merged = array_merge_recursive(
            array_merge(['path' => $path], $config),
            ...$autoloadConfig
        );

        return $merged;
    }

    /**
     * @param string $key
     * @param        $value
     * @return mixed|void
     */
    public function set(string $key, $value)
    {
        // TODO: Implement set() method.

        ArrayHelper::set($this->configs, $key, $value);
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public function has(string $key)
    {
        // TODO: Implement has() method.

        return ArrayHelper::has($this->configs, $key);
    }

    /**
     * @param string $key
     * @param null   $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        // TODO: Implement get() method.

        return ArrayHelper::get($this->configs, $key, $default);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->configs;
    }

    /**
     * 读取文件配置
     * @param string $configPath
     * @return array
     */
    private function readConfig(string $configPath): array
    {
        $config = [];

        if (file_exists($configPath) && is_readable($configPath)) {
            $config = require $configPath;
        }

        return is_array($config) ? $config : [];
    }

    /**
     * 读取目录配置文件
     * @param array $paths  支持多文件配置读取
     * @return array
     */
    private function readPath(array $paths): array
    {
        $config = [];
        $finder = new Finder();
        $finder->files()->in($paths)->name('*' . self::CONFIG_FILE_EXT);
        foreach ($finder as $file) {
            $config[] = [
                $file->getBasename(self::CONFIG_FILE_EXT) => require $file->getRealPath(),
            ];
        }

        return $config;
    }
}