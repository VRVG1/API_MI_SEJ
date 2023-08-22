<?php
/**
 * Script que permite cargar los archivos sin la necesidad de usar requires
 * */

spl_autoload_register(function ($class) {
    $route = '../' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($route)) {
        require_once $route;
    } else {
        die("No se encontro la ruta: " . $route);
    }
});