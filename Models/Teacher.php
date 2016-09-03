<?php

namespace Models;

class Teacher extends EventSubject
{
    public static function subjectName() {
        return 'teacher';
    }
    public static function reverseName() {
        return 'group';
    }
}
