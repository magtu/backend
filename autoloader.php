<?php 

spl_autoload_register(function ($class)
{
    $paths = explode('\\', trim($class, '\\'));
    $class = $paths[0];
    $namespace = 'App';
    if (count($paths) == 2) {
        $class = $paths[1];
        $namespace = $paths[0];
    }
    $path = $namespace.'/'.$class.'.php';
    require_once $path;
});