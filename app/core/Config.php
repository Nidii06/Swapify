<?php

class Config
{
    private static $config = null;

    public static function load()
    {
        if (self::$config === null) {
            $configPath = __DIR__ . '/../../config/config.php';
            if (!file_exists($configPath)) {
                throw new RuntimeException('Configuration file not found');
            }
            self::$config = require $configPath;
        }
        return self::$config;
    }

    public static function get($key, $default = null)
    {
        $config = self::load();
        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }
}

