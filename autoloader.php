<?php
//https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
spl_autoload_register(function ($class)
{
  // base directory for the namespace prefix
  $base_dir = __DIR__.'/';

  // replace the namespace prefix with the base directory, replace namespace
  // separators with directory separators in the relative class name, append
  // with .php
  $file = $base_dir . str_replace('\\', '/', $class) . '.php';
  // if the file exists, require it
  if (file_exists($file)) {
      require $file;
  }
});
