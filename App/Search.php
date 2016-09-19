<?php

namespace App;

class Search {
    public static function query($query) {        
        $prefix = substr($query, 0, 1);
        $id = intval(substr($query, 1));
        
        //group by id
        if ($prefix == 'g' && $id > 0) {
            $q = 'SELECT `id`, `name`, `name` as `url` FROM `groups` WHERE `id`=:id';
            $smbt = \App\PdoHelper::get()->prepare($q);
            $smbt->execute(array('id' => $id));
            $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
            $result = [];
            if (count($res) > 0) {
                $line = $res[0];
                $result[] = array(
                    'type' => 'group',
                    'id' => $line['id'],
                    'name' => $line['name'],
                    'url' => $line['url']
                );
            }
            return $result;
        }
        //teacher by id
        if ($prefix == 't' && $id > 0) {
            $q = 'SELECT `id`, `name`, `url` FROM `teachers` WHERE `id`=:id';
            $smbt = \App\PdoHelper::get()->prepare($q);
            $smbt->execute(array('id' => $id));
            $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
            $result = [];
            if (count($res) > 0) {
                $line = $res[0];
                $result[] = array(
                    'type' => 'teacher',
                    'id' => $line['id'],
                    'name' => $line['name'],
                    'url' => $line['url']
                );
            }
            return $result;
        }
        //search by name
        $result = [];
        $query .= '%';
        $q = 'SELECT `id`, `name`, `name` as `url` FROM `groups` WHERE `name` LIKE :query';
        $smbt = \App\PdoHelper::get()->prepare($q);
        $smbt->execute(array('query'=>$query));
        $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
        for ($i=0; $i<count($res); $i++) {
            $result[] = array(
                'type' => 'group',
                'id' => $res[$i]['id'],
                'name' => $res[$i]['name'],
                'url' => $res[$i]['url'],
            );
        }
        $q = 'SELECT `id`, `name`, `url` FROM `teachers` WHERE `url` LIKE :query';
        $smbt = \App\PdoHelper::get()->prepare($q);
        $smbt->execute(array('query'=>$query));
        $res = $smbt->fetchAll(\PDO::FETCH_ASSOC);
        for ($i=0; $i<count($res); $i++) {
            $result[] = array(
                'type' => 'teacher',
                'id' => $res[$i]['id'],
                'name' => $res[$i]['name'],
                'url' => $res[$i]['url']
            );
        }
        return $result;
    }
}