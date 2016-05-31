<?php

namespace App;

class Search {
    public static function query($q) {
        $mysql = Mysql::get();
        
        $prefix = substr($q, 0, 1);
        $id = intval(substr($q, 1));
        
        //group by id
        if ($prefix == 'g' && $id > 0) {
            $stmt = $mysql->prepare('SELECT `id`, `name` FROM `groups` WHERE `id`=?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $mysqlResult = $stmt->get_result();
            $result = [];
            if ($mysqlResult->num_rows == 1) {
                $line = $mysqlResult->fetch_assoc();
                $result[] = array(
                    'type' => 'group',
                    'id' => $line['id'],
                    'name' => $line['name']
                );
            }
            Mysql::close($mysql);
            return $result;
        }
        //teacher by id
        if ($prefix == 't' && $id > 0) {
            $stmt = $mysql->prepare('SELECT `id`, `name` FROM `teachers` WHERE `id`=?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $mysqlResult = $stmt->get_result();
            $result = [];
            if ($mysqlResult->num_rows == 1) {
                $line = $mysqlResult->fetch_assoc();
                $result[] = array(
                    'type' => 'teacher',
                    'id' => $line['id'],
                    'name' => $line['name']
                );
            }
            Mysql::close($mysql);
            return $result;
        }
        //search by name
        $result = [];
        $q .= '%';
        $stmt = $mysql->prepare('SELECT `id`, `name` FROM `groups` WHERE `name` LIKE ?');
        $stmt->bind_param('s', $q);
        $stmt->execute();
        $mysqlResult = $stmt->get_result();
        while ($line = $mysqlResult->fetch_assoc()) {
            $result[] = array(
                'type' => 'group',
                'id' => $line['id'],
                'name' => $line['name']
            );
        }
        $stmt = $mysql->prepare('SELECT `id`, `name` FROM `teachers` WHERE `name` LIKE ?');
        $stmt->bind_param('s', $q);
        $stmt->execute();
        $mysqlResult = $stmt->get_result();
        while ($line = $mysqlResult->fetch_assoc()) {
            $result[] = array(
                'type' => 'teacher',
                'id' => $line['id'],
                'name' => $line['name']
            );
        }
        return $result;
    }
}