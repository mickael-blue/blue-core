<?php

namespace BlueCore;

class Configure 
{
    protected static $_values = [
        'debug' => false,
    ];

    public static function read($var = null)
    {
        if ($var === null) {
            return static::$_values;
        }

        return static::$_values[$var];
    }

    public static function loadAll($base)
    {
        static::$_values = require $base . "config.php";
        foreach (glob($base . "config-*.php") as $file) {
            static::$_values = array_merge_recursive(static::$_values, require $file);
        }
    }
}
