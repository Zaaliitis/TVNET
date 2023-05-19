<?php

namespace App\Core;

use Carbon\Carbon;

class Cache
{
    private static string $cacheDir = '';

    private static function getCacheDir(): string
    {
        if (empty(self::$cacheDir)) {
            $rootDir = dirname(__DIR__, 2);
            self::$cacheDir = $rootDir . '/Cache/';
        }
        return self::$cacheDir;
    }

    public static function remember(string $key, string $data, int $ttl = 600): void
    {
        $cacheDir = self::getCacheDir();
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        $cacheFile = $cacheDir . $key;
        file_put_contents($cacheFile, json_encode([
            'expires_at' => Carbon::now('GMT+2')->addSeconds($ttl),
            'content' => $data
        ]));
    }

    public static function forget(string $key): void
    {
        $cacheDir = self::getCacheDir();
        unlink($cacheDir . $key);
    }

    public static function get(string $key): ?string
    {
        $cacheDir = self::getCacheDir();
        if (!self::has($key)) {
            return null;
        }
        $content = json_decode(file_get_contents($cacheDir . $key));
        return $content->content;
    }

    public static function has(string $key): bool
    {
        $cacheDir = self::getCacheDir();
        if (!file_exists($cacheDir . $key)) {
            return false;
        }
        $content = json_decode(file_get_contents($cacheDir . $key));
        return Carbon::now('GMT+2') < $content->expires_at;
    }
}