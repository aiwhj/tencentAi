<?php

namespace aiwhj\tencentAi\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class CacheServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['cache'] = function ($app) {
            return new FilesystemCache();
        };
    }
}
