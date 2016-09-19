<?php

namespace App;

class Search {
    public static function query($query) {        
        $prefix = substr($query, 0, 1);
        $id = intval(substr($query, 1));
        
        //group by id
        if ($prefix == 'g' && $id > 0) {
            $result = [];
            try {
                $result[] = \Models\Group::details($id);
                $result[0]['type'] = 'group';
            } catch (\Exception $e) {
            }
            return $result;
        }
        //teacher by id
        if ($prefix == 't' && $id > 0) {
            $result = [];
            try {
                $result[] = \Models\Teacher::details($id);
                $result[0]['type'] = 'teacher';
            } catch (\Exception $e) {
            }
            return $result;
        }
        //search by name
        $groups = \Models\Group::search($query);
        for ($i=0;$i<count($groups); ++$i) {
            $groups[$i]['type'] = 'group';
        }
        $teachers = \Models\Teacher::search($query);
        for ($i=0;$i<count($teachers); ++$i) {
            $teachers[$i]['type'] = 'teacher';
        }
        $result = array_merge($groups, $teachers);
        return $result;
    }
}