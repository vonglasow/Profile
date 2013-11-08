<?php

namespace Profile\Bench;

class Mark
{
    static private $benchmark = null;

    public static function run()
    {
        if (true) {
            $instance = new State\Active;
        } else {
            $instance = new State\Inactive;
        }

        if (static::$benchmark === null) {
            static::$benchmark = $instance;
        }

        return static::$benchmark;
    }
} 