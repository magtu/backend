<?php

namespace Api;

abstract class BaseApiController {
    public abstract function process($uri_paths);
}