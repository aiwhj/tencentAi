<?php

namespace aiwhj\tencentAi\Kernel\Providers;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['http_client'] = function ($app) {
            echo "http_client\n";
            return new Client($app['config']->get('http', []));
        };
    }
}
