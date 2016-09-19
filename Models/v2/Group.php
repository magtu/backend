<?php

namespace Models\v2;

class Group extends \Models\v2\EventSubject
{
    public static function subjectName() {
        return 'group';
    }
    public static function reverseName() {
        return 'teacher';
    }
}