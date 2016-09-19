<?php

namespace Views;

class ViewHelper {
    public static function render($name, $data = []) {
        include $name.'.php';
    }
    public static function renderError($code, $data = []) {
        http_response_code($code);
        include 'Errors/'.$code.'.php';
    }
}
