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

use Raylin666\Contract\ConfigInterface;
use Raylin666\Util\Helper\ArrayHelper;

/**
 * Class Config
 * @package Raylin666\Config
 */
class Config implements ConfigInterface
{
    /**
     * @var array
     */
    protected $configs = [];

    /**
     * Config constructor.
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
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
}