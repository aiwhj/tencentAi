<?php

namespace aiwhj\tencentAi\Kernel;

use aiwhj\tencentAi\Kernel\Helper;
use GuzzleHttp\Client;

class HttpClient
{

    protected $app;

    protected $baseUri;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $this->setParams($query)]);
    }

    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $this->setParams($data)]);
    }
    public function request(string $url, string $method = 'GET', array $options = [])
    {

        $response = $this->getHttpClient()->request($method, $url, $options);

        return $response->getBody();
    }
    public function getHttpClient(): Client
    {
        if (!($this->httpClient instanceof Client)) {
            $this->httpClient = $this->app['http_client'] ?? new Client();
        }

        return $this->httpClient;
    }
    protected function getReqSign($params, $appkey)
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value) {
            if ($value !== '') {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }
        $str .= 'app_key=' . $appkey;
        $sign = strtoupper(md5($str));
        return $sign;
    }
    protected function setParams($params, $appkey)
    {
        $params['app_id']     = $appkey;
        $params['nonce_str']  = Helper::randStr();
        $params['time_stamp'] = time();
        $params['sign']       = '';
        $params['sign']       = getReqSign($params);
        return $params;
    }
}
