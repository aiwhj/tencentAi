<?php
namespace aiwhj\tencentAi\Audio;

use aiwhj\tencentAi\Kernel\AppContainer;

class Application extends AppContainer
{
    protected $providers = [
        Aaiasr\RegisterServiceProvider::class,
    ];
}
