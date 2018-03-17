<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

use aiwhj\tencentAi\Kernel\HttpClient;

class Aaiasr extends HttpClient
{
    public $url;

    public $formats = [
        'PCM'  => 1,
        'WAV'  => 2,
        'AMR'  => 3,
        'SILK' => 4,
    ];
    public $rates = [
        '8000'  => 8000,
        '16000' => 16000,
        '8KHz'  => 8000,
        '16KHz' => 16000,
    ];

    public $format = 2;
    public $rate   = '16000';

    public function setFormat($format, $rate)
    {
        if (!isset($this->formats[$format])) {
            throw new \Exception("Format {$format} is not exist", 1);
        }
        if (!isset($this->rates[$rate])) {
            throw new \Exception("Rate {$rate} is not exist", 1);
        }
        $this->format = $this->formats[$format];
        $this->rate   = $this->rates[$rate];
    }
    public function PostData($url, $params)
    {
        $form_params = array_merge($params, ['format' => $this->format, 'rate' => $this->rate]);
        return $this->httpPost($url, $form_params);
    }
}
