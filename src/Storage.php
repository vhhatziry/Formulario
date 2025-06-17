<?php
namespace App;

class Storage
{
    /**
     * @return array<int,array>  Todos los submissions como arrays asociativos
     */
    public static function readAll(): array
    {
        $file = Config::DATA_FILE;
        if (!file_exists($file)) {
            return [];
        }
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        return is_array($data) ? $data : [];
    }

    /**
     * @param array<int,array> $all  Lista completa de submissions
     */
    public static function writeAll(array $all): void
    {
        $file = Config::DATA_FILE;
        // JSON_PRETTY_PRINT y UNESCAPED_UNICODE para legibilidad
        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
