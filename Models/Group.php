<?php

namespace Models;

class Group
{
    public static function list() {
        $q = 'SELECT id, name FROM groups';
        $smbt = \App\PdoHelper::get()->query($q);
        return $smbt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function search($prefix)
    {
        $q = 'SELECT id, name FROM groups WHERE name LIKE :name';
        $smbt = \App\PdoHelper::get()->prepare($q);
        $smbt->execute(array('name' => $prefix.'%'));
        return $smbt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function details($id)
    {
        return 'details for group with id='.$id;
    }
    public static function schedule($id) {
        $weeks = WeekType::all();
        $days = DaysOfWeek::all();
        $types = EventType::all();
        $smbt = \App\PdoHelper::get()->query("SELECT
            `week_id`,
            `day_id`,
            `event_index`,
            `course_id`, (SELECT `name` FROM `courses` WHERE `id` = i.`course_id`) course,
            `type_id`,
            `subgroup`,
            `teacher_id`, (SELECT `name` FROM `teachers` WHERE `id` = i.`teacher_id`) teacher,
            `location`
            FROM event_templates i WHERE `group_id` = $id
            ORDER BY `week_id`, `day_id`, `event_index`, `subgroup`");
        $db_res = $smbt->fetchAll(\PDO::FETCH_OBJ);
        if (count($db_res) == 0) {
            return false;
        }
        $raw_result = array(1=>array(), array());
        for ($i = 0; $i < count($db_res); $i++) {
            $info = [
                "event_index" => intval($db_res[$i]->event_index),
                "course_id" => intval($db_res[$i]->course_id),
                "course" => $db_res[$i]->course,
                "type_id" => intval($db_res[$i]->type_id),
                "type" => $types[$db_res[$i]->type_id],
                "subgroup" => intval($db_res[$i]->subgroup),
                "teacher_id" => intval($db_res[$i]->teacher_id),
                "teacher" => $db_res[$i]->teacher,
                "location" => $db_res[$i]->location,
            ];
            if ($db_res[$i]->week_id == 3) {
                $raw_result[1][$db_res[$i]->day_id][] = $info;
                $raw_result[2][$db_res[$i]->day_id][] = $info;
            } else {
                $raw_result[$db_res[$i]->week_id][$db_res[$i]->day_id][] = $info;
            }
        }
        $result = array();
        foreach ($raw_result as $week_id => $value) {
            $days_of_week = array();
            foreach ($days as $day_id => $day_name) {
                $days_of_week[] = [
                    "day_id" => $day_id,
                    "day" => $day_name,
                    "events" => []
                ];
            }
            foreach ($value as $day_id => $value) {
                $days_of_week[$day_id-1]["events"] = $value;
            }
            $result[] = [
                "week_id" => $week_id,
                "week" => $weeks[$week_id],
                "days" => $days_of_week,
            ];
        }
        return $result;
    }
}
