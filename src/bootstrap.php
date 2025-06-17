<?php
// src/bootstrap.php

spl_autoload_register(function(string $class) {
    // Sólo cargamos clases bajo el namespace App\
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    // convierte App\Controller\Foo en Controller/Foo.php
    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
