<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

use aiwhj\tencentAi\Kernel\HttpClient;

class Client extends HttpClient
{
    public $url = 'fffff';
    public function send(string $path = '')
    {  
        if (!is_file($path)) {
            throw new \Exception("the path is not", 1);
        }
    }
}
