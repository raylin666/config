<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2019 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Config;

use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\FactoryInterface;

/**
 * Interface ConfigFactoryInterface
 * @package Raylin666\Config
 */
interface ConfigFactoryInterface extends FactoryInterface
{
    /**
     * @param string $path              根目录路径
     * @param string $name              配置名称
     * @param string $configPathName    配置目录
     * @param string $configFileName    配置文件
     * @param string $readPathName      配置读取文件目录
     * @return ConfigInterface
     */
    public function make(string $path, string $name = 'default', $configPathName = 'config', $configFileName = 'config', $readPathName = 'autoload'): ConfigInterface;

    /**
     * @param string $name
     * @return ConfigInterface|null
     */
    public function get(string $name = 'default'): ?ConfigInterface;
}