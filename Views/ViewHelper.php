<?php

namespace Views;

class ViewHelper {
    public static function render($name, $data = []) {
        include $name.'.php';
    }
    public static function renderError($code, $name, $data = []) {

    }
}
