<?php

namespace aiwhj\tencentAi\Kernel;

class Config {
	public $config = [];
	public function __construct(Array $config) {
		$this->config = $config;
	}
	public function get(string $key, array $extre = []) {
		return array_merge($this->config[$key], $extre);
	}
}