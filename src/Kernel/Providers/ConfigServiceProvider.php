<?php

namespace aiwhj\tencentAi\Kernel\Providers;

use aiwhj\tencentAi\Kernel\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface {
	public function register(Container $pimple) {
		$pimple['config'] = function ($app) {
			return new Config($app->getConfig());
		};
	}
}
