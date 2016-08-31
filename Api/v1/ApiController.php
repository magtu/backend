<?php

namespace Api\v1;

class ApiController extends \Api\BaseApiController {
    public function process($uri_paths) {
        if (count($uri_paths) == 0) {
            $this->fail(404);
        }
        $methodName = $uri_paths[0].'Method';
        $callable = array($this, $methodName);

        if (!(method_exists($this, $methodName) && is_callable($callable))) {
            $this->errorResult(404, 'api method not found');
        }

        call_user_func($callable, array_slice($uri_paths, 1));
    }

    function groupsMethod($uri_paths) {
        if (count($uri_paths)>0) {
            $id = intval($uri_paths[0]);
            if ($id > 0) {
                $this->groupDetailMethod($id, array_slice($uri_paths, 1));
            } else {
                $this->errorResult(400, 'bad parametr group id');
            }
            return;
        }
        if (empty($_GET['q'])) {
            $this->jsonResult(\Models\Group::list());
            return;
        }
        $this->jsonResult(\Models\Group::search($_GET['q']));
    }
    function groupDetailMethod($id, $uri_paths) {
        if (count($uri_paths)>0 && $uri_paths[0] == 'schedule') {
            $this->groupScheduleMethod($id, $uri_paths);
            return;
        }
        $this->jsonResult(\Models\Group::details($id));
    }
    function groupScheduleMethod($id) {
        $schedule = \Models\Group::schedule($id);
        if (!$schedule) {
            $this->errorResult(400, 'bad parametr group id');
        }
        $this->jsonResult($schedule);
    }

    function teachersMethod($uri_paths) {
        if (count($uri_paths)>0) {
            $id = intval($uri_paths[0]);
            if ($id > 0) {
                $this->teacherDetailMethod($id, array_slice($uri_paths, 1));
            } else {
                $this->errorResult(400, 'bad parametr group id');
            }
            return;
        }
        if (empty($_GET['q'])) {
            $this->jsonResult(\Models\Teacher::list());
            return;
        }
        $this->jsonResult(\Models\Teacher::search($_GET['q']));
    }
    function teacherDetailMethod($id, $uri_paths) {
        if (count($uri_paths)>0 && $uri_paths[0] == 'schedule') {
            $this->teacherScheduleMethod($id, $uri_paths);
            return;
        }
        $this->jsonResult(\Models\Teacher::details($id));
    }
    function teacherScheduleMethod($id) {
        $schedule = \Models\Teacher::schedule($id);
        if (!$schedule) {
            $this->errorResult(400, 'bad parametr teacher id');
        }
        $this->jsonResult($schedule);
    }

    function jsonResult($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    function errorResult($code, $string) {
        http_response_code($code);
        $message = array(
            'code' => $code,
            'message' => $string,
            'docs' => 'https://gitlab.com/gordin.mitya/schedule/wikis/home'
        );
        $this->jsonResult($message);
        die();
    }
}
