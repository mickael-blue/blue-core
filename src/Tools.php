<?php

namespace BlueCore;

class Tools
{
    /**
     *
     */
    public static function camelize($string, $delimiter = '_')
    {
        return str_replace(' ', '', static::humanize($string, $delimiter));
    }

    /**
     *
     */
    public static function humanize($string, $delimiter = '_')
    {
        $result = explode(' ', str_replace($delimiter, ' ', $string));
        foreach ($result as &$word) {
            $word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
        }
        return implode(' ', $result);
    }

    /**
     *
     */
    public static function variable($string)
    {
        $camelized = static::camelize(static::underscore($string));
        $replace = strtolower(substr($camelized, 0, 1));
        return $replace . substr($camelized, 1);
    }

    /**
     *
     */
    public static function underscore($string)
    {
        return static::delimit(str_replace('-', '_', $string), '_');
    }

    /**
     *
     */
    public static function delimit($string, $delimiter = '_')
    {
        return mb_strtolower(preg_replace('/(?<=\\w)([A-Z])/', $delimiter . '\\1', $string));
    }

}
