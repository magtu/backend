<?

spl_autoload_register(function ($class)
{
    require_once 'App/'.$class.'.php';
});

?>