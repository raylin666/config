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
use Psr\Container\ContainerInterface;
use Raylin666\Contract\ConfigInterface;

/**
 * Class ConfigFactory
 * @package Raylin666\Config
 */
class ConfigFactory implements ConfigFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigInterface[]
     */
    protected $configs = [];

    /**
     * ConfigFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $path              根目录路径
     * @param string $name              配置名称
     * @param string $configPathName    配置目录
     * @param string $configFileName    配置文件
     * @param string $readPathName      配置读取文件目录
     * @return ConfigInterface
     */
    public function make(
        string $path,
        string $name = 'default',
        $configPathName = 'config',
        $configFileName = 'config',
        $readPathName = 'autoload'
    ): ConfigInterface
    {
        // TODO: Implement make() method.

        $configPath = $path . '/' . $configPathName . '/';
        $config = $this->readConfig($configPath . $configFileName . '.php');
        $autoloadConfig = $this->readPaths([$path . '/' . $configPathName . '/' . $readPathName]);

        $merged = array_merge_recursive(
            array_merge(['path' => $path], $config),
            ...$autoloadConfig
        );

        $this->configs[$name] = make(
            Config::class,
            [
                'configs'   =>  $merged
            ]
        );

        return $this->configs[$name];
    }

    /**
     * @param string $name
     * @return ConfigInterface|null
     */
    public function get(string $name = 'default'): ?ConfigInterface
    {
        // TODO: Implement get() method.

        if (isset($this->configs[$name]) && $this->configs[$name] instanceof ConfigInterface) {
            return $this->configs[$name];
        }
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
     * @param array $paths
     * @return array
     */
    private function readPaths(array $paths)
    {
        $configs = [];

        $finder = new Finder();
        $finder->files()->in($paths)->name('*.php');
        foreach ($finder as $file) {
            $configs[] = [
                $file->getBasename('.php') => require $file->getRealPath(),
            ];
        }

        return $configs;
    }
}