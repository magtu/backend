<?php

namespace Api\v2;

class ApiController extends \Api\BaseApiController {
    public function process($uri_paths) {
        if (count($uri_paths) == 0) {
            $this->fail(404);
        }
        $methodName = $uri_paths[0].'Method';
        $callable = array($this, $methodName);

        if (!(method_exists($this, $methodName) && is_callable($callable))) {
            $this->fail(404);
        }

        call_user_func($callable, array_slice($uri_paths, 1));
    }
    function groupsMethod() {

    }
    protected function ok($response) {
        
    }
    protected function fail($code) {
        echo $code;
        exit;
    }
}