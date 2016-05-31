<?php 

spl_autoload_register(function ($class)
{
    $paths = explode('\\', trim($class, '\\'));
    $path = '';
    $count = count($paths);
    for ($i=0; $i < $count - 1 ; $i++) { 
        $path .= $paths[$i].'/';
    }
    $path .= $paths[$count-1].'.php';
    require_once $path;
});