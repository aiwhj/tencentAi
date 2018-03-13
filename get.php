<?php
require './vendor/autoload.php';
use aiwhj\tencentAi\Factory;
$config = [
    'appId'  => '1106687373',
    'appkey' => 'MiKfVhNfey2WUwqI',
];
$audio = Factory::Audio($config);
print_r($audio);
print_r($audio->aaiasr) . "\n\n\n\n";
print_r($audio->http_client->request());
