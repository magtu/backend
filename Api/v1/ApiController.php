<?php

namespace Api\v1;

class ApiController extends \Api\BaseApiController {
    public function process($uri_paths) {
        if (count($uri_paths) == 0) {
            $this->errorResult(404,'empty url');
        }
        $methodName = $uri_paths[0].'PublicMethod';
        $callable = array($this, $methodName);

        if (!(method_exists($this, $methodName) && is_callable($callable))) {
            $this->errorResult(404, 'api method not found');
        }
        try {
            call_user_func($callable, array_slice($uri_paths, 1));
        } catch (\Exception $e) {
            $this->errorResult($e->getCode(), $e->getMessage());
        }
    }

    // Api callable method
    function groupsPublicMethod($uri_paths) {
        if (count($uri_paths)>0) {
            $id = intval($uri_paths[0]);
            if ($id > 0) {
                $this->groupDetail($id, array_slice($uri_paths, 1));
            } else {
                $this->errorResult(400, 'bad parametr group id');
            }
            return;
        }
        if (empty($_GET['q']) || !is_scalar($_GET['q'])) {
            $this->jsonResult(\Models\Group::all());
            return;
        }
        $this->jsonResult(\Models\Group::search($_GET['q']));
    }
    function groupDetail($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                $this->groupSchedule($id, array_slice($uri_paths,1));
                return;
            }
            if ($uri_paths[0] == 'updates') {
                $this->groupUpdates($id, array_slice($uri_paths,1));
                return;
            }
        }
        $this->jsonResult(\Models\Group::details($id));
    }
    function groupSchedule($id) {
        $schedule = \Models\Group::schedule($id);
        if (!$schedule) {
            $this->errorResult(400, 'bad parametr group id');
        }
        $this->jsonResult($schedule);
    }
    function groupUpdates($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                $this->jsonResult(array('updated_at' => \Models\Group::scheduleUpdates($id)));
                return;
            }
        }
        throw new \Exception("incorrect request url", 404);
    }

    // Api callable method
    function teachersPublicMethod($uri_paths) {
        if (count($uri_paths)>0) {
            $id = intval($uri_paths[0]);
            if ($id > 0) {
                $this->teacherDetail($id, array_slice($uri_paths, 1));
            } else {
                $this->errorResult(400, 'bad parametr group id');
            }
            return;
        }
        if (empty($_GET['q']) || !is_scalar($_GET['q'])) {
            $this->jsonResult(\Models\Teacher::all());
            return;
        }
        $this->jsonResult(\Models\Teacher::search($_GET['q']));
    }
    function teacherDetail($id, $uri_paths) {
        if (count($uri_paths)>0 && $uri_paths[0] == 'schedule') {
            $this->teacherSchedule($id, $uri_paths);
            return;
        }
        $this->jsonResult(\Models\Teacher::details($id));
    }
    function teacherSchedule($id) {
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
            'docs' => 'https://github.com/magtu/backend/'
        );
        $this->jsonResult($message);
        die();
    }
}
