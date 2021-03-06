<?php
namespace aiwhj\tencentAi\Kernel;

use aiwhj\tencentAi\Kernel\Providers\ConfigServiceProvider;
use aiwhj\tencentAi\Kernel\Providers\HttpClientServiceProvider;
use Pimple\Container;

class AppContainer extends Container {
	protected $providers = [];
	protected $config = [];
	public function __construct(array $config = []) {
		$this->config = $config;
		$this->registerProviders($this->getProviders());
	}
	public function getConfig() {
		$base = [
			'http' => [
				'timeout' => 5.0,
				'base_uri' => 'https://api.ai.qq.com/fcgi-bin/',
			],
		];

		return array_replace_recursive($base, $this->config);
	}
	public function getProviders() {
		return array_merge([
			ConfigServiceProvider::class,
			HttpClientServiceProvider::class,
		], $this->providers);
	}
	public function registerProviders(array $providers) {
		foreach ($providers as $provider) {
			parent::register(new $provider());
		}
	}
}
