<?php

namespace Scout\Library;

use \Exception;

if(!defined("INIT"))
	die("Access denied.");

class Language {

	/**
	 * Config class instance
	 * 
	 * @var Config
	 */

	private $config;

	/**
	 * Router class instance
	 * 
	 * @var Router
	 */

	private $router;

	/**
	 * Store all the language strings
	 * 
	 * @var String[]
	 */

	private $data = [];

	/**
	 * Load dependencies
	 * 
	 * @param Config $config
	 * @param Router $router
	 * @return Void
	 */

	public function __construct($config, $router) {

		$this->config = $config;
		$this->router = $router;

	}

	/**
	 * Grab language files
	 * 
	 * @param String $files
	 * @return Void
	 */

	public function grab($files) {

		foreach(explode(",", $files) as $file) {
			$file = trim($file);
			$path = ROOT."/addons/languages/{$this->config->site_lang}/{$this->router->module}/{$file}.json";

			if(is_file($path)) {
				$this->data = array_merge($this->data, json_decode(file_get_contents($path), true));
			}
			else {
				throw new Exception("The '{$path}' file doesn't exists.");
			}
		}

	}

	/**
	 * Get formatted language string
	 * 
	 * @param String $key
	 * @param String[] $args
	 * @return String
	 */

	public function getFormatted($key, $args = []) {

		if(isset($this->data[$key])) {
			return vsprintf($key, $args);
		}
		else {
			throw new Exception("The '{$key}' string doesn't exists.");
		}

	} 

	/**
	 * Get language string
	 * 
	 * @param String $key
	 * @return String
	 */

	public function __get($key) {

		if(isset($this->data[$key])) {
			return $this->data[$key];
		}
		else {
			throw new Exception("The '{$key}' string doesn't exists.");
		}

	}

}