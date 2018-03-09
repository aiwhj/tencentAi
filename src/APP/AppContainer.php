<?php
namespace aiwhj\tencentAi\App;

use Pimple\Container;

class AppContainer extends Container
{
    protected $providers = [];
    public function __construct(array $config = [])
    {
        $this->registerProviders($this->getProviders());
    }
    public function getProviders()
    {
        return array_merge([
        ], $this->providers);
    }
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}
