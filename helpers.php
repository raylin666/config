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

if (! function_exists('load_conf_file')) {
    /**
     * 加载配置文件
     * @param $file
     * @return array|bool|mixed
     */
    function load_conf_file($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'ini':
                $config = parse_ini_file($file, true);
                break;
            case 'json':
                $config = json_decode(file_get_contents($file), true);
                break;
            case 'php':
            default:
                $config = include $file;
        }

        return $config;
    }
}