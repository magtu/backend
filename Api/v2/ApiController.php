<?php

namespace Api\v2;

class ApiController extends \Api\BaseApiController {
    protected function getDoc() {
        return "https://github.com/gordinmitya/magtu";
    }

    public function process($uri_paths) {
        if (count($uri_paths) == 0) {
            return $this->methodNotFound('empty url');
        }
        $methodName = $uri_paths[0].'Method';
        $callable = array($this, $methodName);

        if (!(method_exists($this, $methodName) && is_callable($callable))) {
            return $this->methodNotFound($methodName);
        }

        $success = call_user_func($callable, array_slice($uri_paths, 1));
        if (!$success) {
            return $this->methodNotFound(join('/',$uri_paths));
        }
    }

    function searchMethod() {
        if (empty($_GET['q']) || !is_scalar($_GET['q'])) {
            return $this->invalidParametr('q');
        }
        return $this->ok(\App\Search::query($_GET['q']));
    }

    function groupsMethod($uri_paths) {
        if (count($uri_paths) == 0) {
            if (empty($_GET['q']) || !is_scalar($_GET['q'])) {
                return $this->ok(\Models\v2\Group::list());
            }
            return $this->ok(\Models\v2\Group::search($_GET['q']));
        }
        $id = intval($uri_paths[0]);
        if ($id > 0) {
            return $this->groupDetailMethod($id, array_slice($uri_paths, 1));
        } else {
            return $this->invalidParametr('group id');
        }
    }
    function groupDetailMethod($id, $uri_paths) {
        if (count($uri_paths) == 0) {
            return $this->ok(\Models\Group::details($id));
        }
        if ($uri_paths[0] == 'schedule') {
            return $this->groupScheduleMethod($id, $uri_paths);
        }
        if ($uri_paths[0] == 'updates') {
            return $this->groupUpdatesMethod($id, array_slice($uri_paths,1));
        }
        return false;
    }
    function groupScheduleMethod($id) {
        $schedule = \Models\v2\Group::schedule($id);
        if (!$schedule) {
            return $this->invalidParametr('group id');
        }
        return $this->ok($schedule);
    }
    function groupUpdatesMethod($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                return $this->ok(array('updated_at' => \Models\Group::scheduleUpdates($id)));
            }
        }
        throw new \Exception("incorrect request url", 404);
    }

    function teachersMethod($uri_paths) {
        if (count($uri_paths) == 0) {
            if (empty($_GET['q']) || !is_scalar($_GET['q'])) {
                return $this->ok(\Models\v2\Teacher::list());
            }
            return $this->ok(\Models\v2\Teacher::search($_GET['q']));
        }
        $id = intval($uri_paths[0]);
        if ($id > 0) {
            return $this->teacherDetailMethod($id, array_slice($uri_paths, 1));
        } else {
            return $this->invalidParametr('teacher id');
        }
    }
    function teacherDetailMethod($id, $uri_paths) {
        if (count($uri_paths) == 0) {
            return $this->ok(\Models\Teacher::details($id));
        }
        if ($uri_paths[0] == 'schedule') {
            return $this->teacherScheduleMethod($id, $uri_paths);
        }
        if ($uri_paths[0] == 'updates') {
            return $this->teacherUpdatesMethod($id, array_slice($uri_paths,1));
        }
        return false;
    }
    function teacherScheduleMethod($id) {
        $schedule = \Models\v2\Teacher::schedule($id);
        if (!$schedule) {
            return $this->invalidParametr('teacher id');
        }
        return $this->ok($schedule);
    }
    function teacherUpdatesMethod($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                return $this->ok(array('updated_at' => \Models\Teacher::scheduleUpdates($id)));
            }
        }
        throw new \Exception("incorrect request url", 404);
    }

    protected function jsonResult($code, $data) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        return true;
    }
    protected function ok($response) {
        return $this->jsonResult(200, $response);
    }
    protected function invalidParametr($paramName){
        return $this->jsonResult(400, array(
            'error'=>"invalid parametr '$paramName'",
            'documentation'=>$this->getDoc()
            ));
    }
    protected function methodNotFound($methodName) {
        return $this->jsonResult(404, array(
            'error'=>"method '$methodName' not found",
            'documentation'=>$this->getDoc()
            ));
    }
}
