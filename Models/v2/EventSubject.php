<?php

namespace Models\v2;

abstract class EventSubject extends \Models\EventSubject {
    public static function schedule($id) {
        $res = static::details($id);
        $res['schedule'] = parent::schedule($id);
        for ($w=0; $w<count($res['schedule']); ++$w) {
            $week = &$res['schedule'][$w];
            for ($d=0; $d<count($week['days']); ++$d) {
                $day = &$week['days'][$d];
                for ($e=0; $e<count($day['events']); ++$e) {
                    $event = &$day['events'][$e];
                    $event['reverse_id'] = $event[static::reverseId()];
                    $event['reverse'] = $event[static::reverseName()];
                    unset($event['group_id']);
                    unset($event['group']);
                    unset($event['teacher_id']);
                    unset($event['teacher']);
                }
            }
        }
        return $res;
    }
}