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
     * @var ConfigInterface[]
     */
    protected $config;

    /**
     * ConfigFactory constructor.
     * @param string $path
     * @param string $configPathName
     * @param string $configFileName
     * @param string $readPathName
     */
    public function __construct(
        string $path = __DIR__,
        $configPathName = 'config',
        $configFileName = 'config',
        $readPathName = 'autoload'
    ) {
        $configPath = $path . '/' . $configPathName . '/';
        $config = $this->readConfig($configPath . $configFileName . '.php');
        $autoloadConfig = $this->readPaths([$configPath . $readPathName]);
        $merged = array_merge_recursive($config, ...$autoloadConfig);
        $this->config = new Config($merged);
    }

    /**
     * @param ContainerInterface $container
     * @return ConfigInterface
     */
    public function __invoke(ContainerInterface $container): ConfigInterface
    {
        // TODO: Implement __invoke() method.

        $this->container = $container;

        return $this->config;
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