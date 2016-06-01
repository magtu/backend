<?php 

spl_autoload_register(function ($class)
{
    $path = str_replace('\\', '/', trim($class, '\\')).'.php';
    if (!file_exists(__DIR__.'/'.$path)) {
        return;
    }
    require_once $path;
});