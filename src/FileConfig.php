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

use ShugaChara\Core\Utils\Helper\ArrayHelper;

/**
 * 文件配置加载类
 *
 * Class FileConfig
 * @package ShugaChara\Config
 */
class FileConfig
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * 过滤的配置文件，一般默认外部优先加载该文件
     * @var array
     */
    private $filterFile = [];

    /**
     * FileConfig constructor.
     */
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
        return $this->config = ArrayHelper::merge($this->config, $config);
    }

    /**
     * 加载配置文件
     * @param $file
     * @return array|bool|mixed
     */
    public function loadFile($file)
    {
        return $this->loadConfig(load_conf_file($file));
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
                        $filename       =>      load_conf_file($file)
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
    public function all(): array
    {
        return (array) $this->config;
    }
}
