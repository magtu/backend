<?php

namespace Models;

class EventType
{
    public static function all() {
        return array(1=>'лекция','практика','лабораторная','факультатив');
    }
}
