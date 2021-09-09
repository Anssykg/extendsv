<?php


namespace Extendsv\Utils;

/**
 * Trait Singleton 单例
 * @package Extendsv\Utils
 */
trait Singleton
{
    private static $instance;

    static function getInstance(...$args)
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}
