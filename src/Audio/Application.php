<?php
namespace aiwhj\tencentAi\Audio;

use aiwhj\tencentAi\App\AppContainer;

class Application extends AppContainer
{
    protected $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        BasicService\Media\ServiceProvider::class,
    ];
}
