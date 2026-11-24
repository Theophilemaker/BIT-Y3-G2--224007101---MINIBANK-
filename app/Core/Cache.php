<?php
class Cache {
    private static function getDir() {
        $dir = __DIR__ . '/../../storage/cache/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        return $dir;
    }

    public static function set($key, $data, $ttl = 300) {
        $file = self::getDir() . md5($key) . '.cache';
        file_put_contents($file, serialize(['expires' => time() + $ttl, 'data' => $data]));
    }

    public static function get($key) {
        $file = self::getDir() . md5($key) . '.cache';
        if (!file_exists($file)) return false;
        $content = unserialize(file_get_contents($file));
        if ($content['expires'] < time()) { unlink($file); return false; }
        return $content['data'];
    }
}
?>