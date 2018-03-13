<?php

namespace aiwhj\tencentAi\Kernel;

class HttpClient {

	protected $app;

	protected $baseUri;

	public function __construct(ServiceContainer $app) {
		$this->app = $app;
	}

	public function performRequest($url, $method = 'GET', $options = []): ResponseInterface{
		$method = strtoupper($method);

		$options = array_merge(self::$defaults, $options, ['handler' => $this->getHandlerStack()]);

		$options = $this->fixJsonIssue($options);

		if (property_exists($this, 'baseUri') && !is_null($this->baseUri)) {
			$options['base_uri'] = $this->baseUri;
		}

		$response = $this->getHttpClient()->request($method, $url, $options);
		$response->getBody()->rewind();

		return $response;
	}

	public function httpGet(string $url, array $query = []) {
		return $this->request($url, 'GET', ['query' => $query]);
	}

	public function httpPost(string $url, array $data = []) {
		return $this->request($url, 'POST', ['form_params' => $data]);
	}

	public function httpPostJson(string $url, array $data = [], array $query = []) {
		return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
	}

	public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false) {
		if (empty($this->middlewares)) {
			$this->registerHttpMiddlewares();
		}

		$response = $this->performRequest($url, $method, $options);

		return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
	}
}
