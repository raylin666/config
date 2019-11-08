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

namespace ShugaChara\Config;

use ShugaChara\Core\Helpers;
use ShugaChara\Core\Utils\Helper\ArrayHelper;

/**
 * 文件配置加载类
 *
 * Class FileConfig
 * @package ShugaChara\Config
 */
class FileConfig
{
    protected $config = [];

    /**
     * 过滤的配置文件，一般默认外部优先加载该文件
     * @var array
     */
    private $filterFile = [];

    public function __construct() {}

    /**
     * 过滤的配置文件
     * @param array $filesName
     */
    public function setFilterFile(array $filesName = [])
    {
        $this->filterFile = $filesName;
    }

    /**
     * 加载配置
     * @param $config
     */
    public function loadConfig($config): array
    {
        $this->config = ArrayHelper::merge($this->config, $config);
        return $this->config;
    }

    /**
     * 加载配置文件
     * @param $file
     * @return array|bool|mixed
     */
    public function loadFile($file)
    {
        $config = Helpers::loadFile($file);
        return $this->loadConfig($config);
    }

    /**
     * 加载配置目录
     * @param        $path
     * @param string $ext
     */
    public function loadPath($path, $ext = '.php')
    {
        foreach (glob($path . '/*' . $ext) as $file) {
            $filename = str_replace($ext, '', basename($file));
            if (! in_array($filename, $this->filterFile)) {
                $this->config = ArrayHelper::merge(
                    $this->config,
                    [
                        $filename       =>      Helpers::loadFile($file)
                    ]
                );
            }
        }
    }

    /**
     * 获取配置
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return ArrayHelper::get($this->config, $key, $default);
    }

    /**
     * 获取所有配置项
     * @return array
     */
    public function all()
    {
        return (array) $this->config;
    }
}
