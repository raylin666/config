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
use Raylin666\Contract\FactoryInterface;
use Raylin666\Contract\ConfigInterface;

/**
 * Class ConfigFactory
 * @package Raylin666\Config
 */
class ConfigFactory implements FactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var ConfigInterface[]
     */
    protected $config;

    /**
     * ConfigFactory constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->basePath = $path;
    }

    /**
     * @param ContainerInterface $container
     * @return FactoryInterface
     */
    public function __invoke(ContainerInterface $container): FactoryInterface
    {
        // TODO: Implement __invoke() method.

        $this->container = $container;
        return $this;
    }

    /**
     * 实例化配置
     * @param string $configName        配置名
     * @param string $configPathName    配置目录
     * @param string $configFileName    配置文件
     * @param string $readPathName      配置读取文件目录
     * @return mixed
     */
    public function make(
        string $configName = 'default',
        $configPathName = 'config',
        $configFileName = 'config',
        $readPathName = 'autoload'
    ) {
        $configPath = $this->basePath . '/' . $configPathName . '/';
        $config = $this->readConfig($configPath . $configFileName . '.php');
        $autoloadConfig = $this->readPaths([$configPath . $readPathName]);
        $merged = array_merge_recursive($config, ...$autoloadConfig);
        $this->config[$configName] = new Config($merged);
        return $this->config[$configName];
    }

    /**
     * 获取配置对象
     * @param string $name
     * @return ConfigInterface|null
     */
    public function get(string $name = 'default'): ?ConfigInterface
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
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

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}