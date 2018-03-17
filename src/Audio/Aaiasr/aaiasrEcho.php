<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

class aaiasrEcho extends Aaiasr
{
    public $url = '/fcgi-bin/aai/aai_asr';
    public function send(string $path = '')
    {
        if (!is_file($path)) {
            throw new \Exception("the file {$path} is not exists", 1);
        }
        $data        = file_get_contents($path);
        $speech      = base64_encode($data);
        $form_params = ['speech' => $speech];
        return $this->PostData($this->url, $form_params);
    }
}
