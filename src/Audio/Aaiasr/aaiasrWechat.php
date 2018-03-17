<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

class aaiasrWechat extends Aaiasr
{
    public $url = '/fcgi-bin/aai/aai_wxasrs';

    public $formats = [
        'PCM'    => 1,
        'WAV'    => 2,
        'AMR'    => 3,
        'SILK'   => 4,
        'SPEEX ' => 5,
    ];
    public $rates = [
        '16000' => 16000,
        '16KHz' => 16000,
    ];
    public function send(string $path = '', string $speech_id = '', int $end = 0, int $cont_res = 0)
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
            'cont_res'     => $cont_res,
            'bits'         => 16,
        ];
        return $this->PostData($this->url, $form_params);
    }
}
