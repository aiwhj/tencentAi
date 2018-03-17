<?php

namespace aiwhj\tencentAi\Audio\Aaiasr;

use aiwhj\tencentAi\Audio\Aaiasr\aaiasrEcho;
use aiwhj\tencentAi\Audio\Aaiasr\aaiasrLab;
use aiwhj\tencentAi\Audio\Aaiasr\aaiasrWechat;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RegisterServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['aecho'] = function ($app) {
            return new aaiasrEcho($app);
        };
        $app['alab'] = function ($app) {
            return new aaiasrLab($app);
        };
        $app['awechat'] = function ($app) {
            return new aaiasrWechat($app);
        };

    }
}
