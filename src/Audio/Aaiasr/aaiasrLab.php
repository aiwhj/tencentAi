<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

class aaiasrLab extends Aaiasr
{
    public $url = '/fcgi-bin/aai/aai_asrs';

    public function send(string $path = '', string $speech_id = '', int $end = 0)
    {
        if (!is_file($path)) {
            throw new \Exception("the path {$path} is not exist", 1);
        }
        if (!$speech_id) {
            throw new \Exception("speech_id  is not exist", 1);
        }

        $data   = file_get_contents($path);
        $speech = base64_encode($data);

        $leng = strlen($data);

        $cacheKey = md5($speech_id);
        if (!$this->app->cache->has($cacheKey)) {
            $seq = 0;
        } else {
            $seq = $this->app->cache->get($cacheKey);
        }
        if ($end) {
            $this->app->cache->delete($cacheKey);
        } else {
            $this->app->cache->set($cacheKey, $leng + $seq);
        }

        $form_params = [
            'speech_chunk' => $speech,
            'seq'          => $seq,
            'len'          => $leng,
            'speech_id'    => $speech_id,
            'end'          => $end,
        ];
        return $this->PostData($this->url, $form_params);
    }
}
