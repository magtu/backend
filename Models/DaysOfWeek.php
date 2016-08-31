<?php

namespace Models;

class DaysOfWeek
{
    public static function all() {
        return array(
            1=>'Понедельник','Вторник','Среда','Четверг','Пятница',
            'Суббота','Воскресенье'
        );
    }
}
