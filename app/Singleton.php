<?php

namespace App;

abstract class Singleton
{
    private static array $instances = [];

    protected function __construct() {
    }

    public static function get_instance(): Singleton {
        if ( ! isset( self::$instances[ static::class ] ) ) {
            self::$instances[ static::class ] = new static();
        }

        return self::$instances[ static::class ];
    }
}
