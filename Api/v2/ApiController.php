<?php

namespace Api\v2;

class ApiController extends \Api\BaseApiController {
    public function process($uri_paths) {
        if (count($uri_paths) == 0) {
            $this->fail(404);
        }
        $methodName = $uri_paths[0].'Method';
        $callable = array($this, $methodName);

        if (!(method_exists($this, $methodName) && is_callable($callable))) {
            $this->fail(404);
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
            $this->jsonResult(\Models\v2\Group::list());
            return;
        }
        $this->jsonResult(\Models\Group::search($_GET['q']));
    }
    function groupDetailMethod($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                $this->groupScheduleMethod($id, array_slice($uri_paths,1));
                return;
            }
            if ($uri_paths[0] == 'updates') {
                $this->groupUpdatesMethod($id, array_slice($uri_paths,1));
                return;
            }
        }
        $this->jsonResult(\Models\Group::details($id));
    }
    function groupScheduleMethod($id) {
        $schedule = \Models\v2\Group::schedule($id);
        if (!$schedule) {
            $this->errorResult(400, 'bad parametr group id');
        }
        $this->ok($schedule);
    }
    function groupUpdatesMethod($id, $uri_paths) {
        if (count($uri_paths)>0) {
            if ($uri_paths[0] == 'schedule') {
                $this->jsonResult(array('updated_at' => \Models\Group::scheduleUpdates($id)));
                return;
            }
        }
        throw new \Exception("incorrect request url", 404);
    }

    protected function ok($response) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    protected function fail($code) {
        echo $code;
        exit;
    }
}