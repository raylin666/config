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

/**
 * Class ConfigOptions
 * @package Raylin666\Config
 */
class ConfigOptions
{
    /**
     * 根目录路径
     * @var
     */
    protected $path;

    /**
     * 配置目录
     * @var
     */
    protected $configPathName;

    /**
     * 配置文件
     * @var
     */
    protected $configFileName;

    /**
     * 配置读取文件目录
     * @var
     */
    protected $readPathName;

    /**
     * ConfigOptions constructor.
     * @param string $path              根目录路径
     * @param string $configPathName    配置目录
     * @param string $configFileName    配置文件
     * @param string $readPathName      配置读取文件目录
     */
    public function __construct(
        string $path,
        $configPathName = 'config',
        $configFileName = 'app',
        $readPathName = 'autoload'
    ) {
        $this->path = $path;
        $this->configPathName = $configPathName;
        $this->configFileName = $configFileName;
        $this->readPathName = $readPathName;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getConfigPathName()
    {
        return $this->configPathName;
    }

    /**
     * @return mixed
     */
    public function getConfigFileName()
    {
        return $this->configFileName;
    }

    /**
     * @return mixed
     */
    public function getReadPathName()
    {
        return $this->readPathName;
    }

    /**
     * @param $path
     * @return ConfigOptions
     */
    public function withPath($path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param $configPathName
     * @return ConfigOptions
     */
    public function withConfigPathName($configPathName): self
    {
        $this->configPathName = $configPathName;
        return $this;
    }

    /**
     * @param $configFileName
     * @return ConfigOptions
     */
    public function withConfigFileName($configFileName): self
    {
        $this->configFileName = $configFileName;
        return $this;
    }

    /**
     * @param $readPathName
     * @return ConfigOptions
     */
    public function withReadPathName($readPathName): self
    {
        $this->readPathName = $readPathName;
        return $this;
    }
}