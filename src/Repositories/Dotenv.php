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

namespace ShugaChara\Config\Repositories;

use Dotenv\Dotenv as GDotenv;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Environment\FactoryInterface;

/**
 * .env 配置类
 *
 * Class Dotenv
 * @package ShugaChara\Config\Repositories
 */
class Dotenv
{
    /**
     * 配置构造工厂
     * @var
     */
    protected $envFactory;

    /**
     * 创建一个新的dotenv实例
     *
     * @param                       $paths
     * @param null                  $file
     * @param FactoryInterface|null $envFactory
     * @return GDotenv
     */
    public static function create($paths, $file = null, FactoryInterface $envFactory = null)
    {
        return GDotenv::create($paths, $file, $envFactory);
    }

    /**
     * 配置构造工厂
     *
     * @param array|null $adapters
     * 例: [
                new EnvConstAdapter,
                new PutenvAdapter,
                new ServerConstAdapter
            ]
     * @return DotenvFactory
     */
    public static function envFactory(array $adapters = null)
    {
        return new DotenvFactory($adapters);
    }
}
