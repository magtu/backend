<?php

namespace Models;

abstract class EventSubject {
    public static abstract function subjectName();
    public static abstract function reverseName();

    public static function subjectId() {
        return static::subjectName().'_id';
    }
    public static function subjectTable() {
        return static::subjectName().'s';
    }

    public static function reverseId() {
        return static::reverseName().'_id';
    }
    public static function reverseTable() {
        return static::reverseName().'s';
    }

    public static function list() {
        $q = 'SELECT id, name FROM '.static::subjectTable();

        $smbt = \App\PdoHelper::get()->query($q);
        $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
        for ($i=0;$i<count($res);$i++){
            $res[$i]['id'] = intval($res[$i]['id']);
        }
        return $res;
    }
    public static function search($prefix)
    {
        $q = 'SELECT id, name FROM '.static::subjectTable().' WHERE name LIKE :name';
        $smbt = \App\PdoHelper::get()->prepare($q);
        $smbt->execute(array('name' => $prefix.'%'));
        $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
        for ($i=0;$i<count($res);$i++){
            $res[$i]['id'] = intval($res[$i]['id']);
        }
        return $res;
    }
    public static function details($id)
    {
        return 'details for '.static::subjectName().' with id='.$id;
    }
    public static function schedule($id) {
        $weeks = WeekType::all();
        $days = DaysOfWeek::all();
        $types = EventType::all();
        $q = 'SELECT
            `week_id`,
            `day_id`,
            `event_index`,
            `course_id`, (SELECT `name` FROM `courses` WHERE `id` = e.`course_id`) course,
            `type_id`,
            `group_id`, (SELECT `name` FROM `groups` WHERE `id` = e.`group_id`) `group`,
            `subgroup`,
            `teacher_id`, (SELECT `name` FROM `teachers` WHERE `id` = e.`teacher_id`) `teacher`,
            `location`
            FROM event_templates e WHERE `'.static::subjectId().'` = '.$id.'
            ORDER BY `week_id`, `day_id`, `event_index`, `subgroup`';
        $smbt = \App\PdoHelper::get()->query($q);
        $db_res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
        if (count($db_res) == 0) {
            throw new \Exception(static::subjectName()." with id=$id not found", 404);
        }
        $raw_result = array(1=>array(), array());
        $intFields = array("event_index", "course_id", "type_id",
            "group_id", "subgroup", "teacher_id");
        $intFieldsCount = count($intFields);
        for ($i = 0; $i < count($db_res); $i++) {
            for ($j=0;$j<$intFieldsCount;$j++) {
                $db_res[$i][$intFields[$j]] = intval($db_res[$i][$intFields[$j]]);
            }
            $db_res[$i]['type'] = $types[$db_res[$i]['type_id']];

            $weekId = $db_res[$i]['week_id'];
            $dayId = $db_res[$i]['day_id'];
            if ($weekId == 3) {
                $raw_result[1][$dayId][] = $db_res[$i];
                $raw_result[2][$dayId][] = $db_res[$i];
            } else {
                $raw_result[$weekId][$dayId][] = $db_res[$i];
            }
        }
        $result = array();
        foreach ($raw_result as $week_id => $week) {
            $days_of_week = array();
            foreach ($days as $day_id => $day_name) {
                $days_of_week[] = [
                    'day_id' => $day_id,
                    'day' => $day_name,
                    'events' => []
                ];
            }
            foreach ($week as $day_id => $events) {
                $days_of_week[$day_id-1]['events'] = $events;
            }
            $result[] = [
                "week_id" => $week_id,
                "week" => $weeks[$week_id],
                "days" => $days_of_week,
            ];
        }
        return $result;
    }
    public static function scheduleUpdates($id) {
        $q = 'SELECT `updated_at` FROM `'.static::subjectTable().'` WHERE `id`='.$id;
        $smbt = \App\PdoHelper::get()->query($q);
        $res = $smbt->fetch(\PDO::FETCH_ASSOC);
        if (!$res){
            throw new \Exception(static::subjectName()." with id=$id not found", 404);
        }
        $updated = strtotime($res['updated_at']);
        return $updated;
    }
}
