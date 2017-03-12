<?php

namespace Api\tg;

class ApiController extends \Api\BaseApiController {
    protected function getDoc() {
        return "https://github.com/gordinmitya/magtu";
    }

    public function process($uri_paths) {
        if (count($uri_paths) == 0) return;
        if ($uri_paths[0]!=TG_TOKEN) return;
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON);

        
        $this->doit('sendMessage',array('chat_id'=>$input->message->from->id,'text'=>$input->message->text));
    }

    private function log(string $message) {
        $q = 'INSERT INTO tg_log (text) VALUES(:message)';
        $smbt = \App\PdoHelper::get()->prepare($q);
        $smbt->execute(compact('message'));
    }
    private function doit($method, $params) {
        var_dump($params);
        file_get_contents('https://api.telegram.org/bot'.TG_TOKEN.'/'.$method.'?chat_id='.$params['chat_id'].'&text='.urldecode($params['text']));
    }
}