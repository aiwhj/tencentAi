<?php

namespace aiwhj\tencentAi\Kernel;

use aiwhj\tencentAi\Kernel\Helper;
use GuzzleHttp\Client;

class HttpClient
{

    protected $app;

    protected $baseUri;

    protected $httpClient;

    protected $params;

    public function __construct(AppContainer $app)
    {
        $this->app = $app;
    }

    public function httpGet(string $url, array $query = [])
    {
        $this->setParams($query);

        return $this->request($url, 'GET', ['query' => $this->params]);
    }

    public function httpPost(string $url, array $data = [])
    {
        $this->setParams($data);

        return $this->request($url, 'POST', ['form_params' => $this->params]);
    }

    public function request(string $url, string $method = 'GET', array $options = [])
    {
        $response = $this->getHttpClient()->request($method, $url, $options);

        return $this->responseType($response->getBody());
    }

    public function responseType($body)
    {
        switch ($this->app->config->responseType) {
            case 'array':
                return \json_decode($body, 1);
                break;
            case 'object':
                return \json_decode($body, 0);
                break;
            case 'json':
            default:
                return (string) $body;
                break;
        }
    }

    public function getHttpClient(): Client
    {
        if (!($this->httpClient instanceof Client)) {
            $this->httpClient = $this->app['http_client'] ?? new Client();
        }

        return $this->httpClient;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    protected function getReqSign($params)
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value) {
            if ($value !== '') {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }
        $str .= 'app_key=' . $this->app->config->appkey;
        $sign = strtoupper(md5($str));
        return $sign;
    }

    protected function setParams($params)
    {
        $params_def = [
            'app_id'     => $this->app->config->appId,
            'nonce_str'  => Helper::randStr(16),
            'time_stamp' => time(),
            'sign'       => '',
        ];
        $this->params         = array_merge($params, $params_def);
        $this->params['sign'] = $this->getReqSign($this->params);
    }
}
