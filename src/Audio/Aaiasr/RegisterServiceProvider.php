<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

use aiwhj\tencentAi\Audio\Aaiasr\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RegisterServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['aaiasr'] = function ($app) {
            return new Client($app);
        };
    }
}
