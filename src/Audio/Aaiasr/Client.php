<?php

namespace aiwhj\tencentAi\Audio;

use aiwhj\tencentAi\Kernel\HttpClient;

class Client implements HttpClient
{
    public $url = 'fffff';
    public function send(string $path = '')
    {
        if (!is_file($path)) {
            throw new Exception("the path is", 1);
        }
    }
}
