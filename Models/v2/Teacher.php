<?php

namespace Models\v2;

class Teacher extends \Models\v2\EventSubject
{
    public static function subjectName() {
        return 'teacher';
    }
    public static function reverseName() {
        return 'group';
    }
}
