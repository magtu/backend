<?php

namespace Models;

class Group extends EventSubject
{
    public static function subjectName() {
        return 'group';
    }
    public static function reverseName() {
        return 'teacher';
    }
}
