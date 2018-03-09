<?php

namespace aiwhj\tencentAi\Audio;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Register implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['access_token']) && $app['access_token'] = function ($app) {
            return new AccessToken($app);
        };

        !isset($app['auth']) && $app['auth'] = function ($app) {
            return new Client($app);
        };
    }
}
