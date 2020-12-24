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

use RuntimeException;
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
     * ConfigFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ConfigInterface
     */
    public function make(): ConfigInterface
    {
        if (empty($this->basePath)) {
            throw new RuntimeException('Please call `setBasePath` method first.');
        }

        $configPath = $this->basePath . '/config/';
        $config = $this->readConfig($configPath . 'config.php');
        $autoloadConfig = $this->readPaths([$configPath . 'autoload']);
        $merged = array_merge_recursive($config, ...$autoloadConfig);

        return new Config($merged);
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
     * @param string $path
     */
    public function setBasePath(string $path)
    {
        $this->basePath = $path;
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