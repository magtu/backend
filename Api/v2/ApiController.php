<?php

namespace Api\v2;

class ApiController extends \Api\BaseApiController {
    public function process($uri_paths) {
        echo '2';
    }
    protected function ok($response) {
        
    }
    protected function fail($code) {
        
    }
}