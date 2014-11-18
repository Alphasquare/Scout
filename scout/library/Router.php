<?php

namespace Scout\Library;

if(!defined("INIT"))
	die("Access denied.");

class Router {

	/**
	 * Config class instance
	 * 
	 * @var Config
	 */

	private $config;

	/**
	 * Module name
	 * 
	 * @var String
	 */

	public $module;

	/**
	 * Page name
	 * 
	 * @var String
	 */

	public $page;

	/**
	 * Optional params
	 * 
	 * @var String[]
	 */

	public $params;

	/**
	 * Parse the current URL
	 * 
	 * @return String[]
	 */

	private function parseUrl() {

		$requestUri = explode("/", $_SERVER['REQUEST_URI']);
		$scriptName = explode("/", $_SERVER['SCRIPT_NAME']);

		for($i = 0; $i < count($scriptName); $i++) {
			if($requestUri[$i] == $scriptName[$i])
				unset($requestUri[$i]);
		}

		return array_values($requestUri);

	}

	/**
	 * Verify if a module exists
	 * 
	 * @param String $module
	 * @return Boolean
	 */

	public function moduleExists($module) {

		$path = ROOT."/scout/modules/{$module}";

		if(strlen(trim($module)) > 0 && is_dir($path)) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * Redirect to another page
	 * 
	 * @param String $path
	 * @return Void
	 */

	public function redirect($path) {

		return header("location: {$this->config->site_url}/{$path}");

	}

	/**
	 * Verify if a page exists
	 * 
	 * @param String $module
	 * @param String $page
	 * @return Boolean
	 */

	public function pageExists($module, $page) {

		$path = ROOT."/scout/modules/{$module}/{$page}.php";

		if(is_file($path)) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * Load depdendencies and the current module/page/params
	 * 
	 * @param Config $config
	 * @return Void
	 */

	public function __construct($config) {

		$this->config = $config;

		$url = $this->parseUrl();

		if($url[0] == "dashboard") {
			$module = "backend";
		}
		else {
			$module = $url[0];
		}

		if($this->moduleExists($module)) {
			$this->module = $module;

			unset($url[0]);
		}
		else {
			$this->module = "frontend";
		}
		
		if(isset($url[0])) {
			if(strlen(trim($url[0])) < 1) {
				$page = "index";
			}
			else {
				$page = $url[0];
			}
		}
		else if(!isset($url[0]) && isset($url[1])) {
			if(strlen(trim($url[1])) < 1) {
				$page = "index";
			}
			else {
				$page = $url[1];
			}
		}
		else {
			$page = "index";
		}

		if($this->pageExists($this->module, $page)) {
			$this->page = $page;
		}
		else {
			$this->page = "error404";
		}

		$this->params = $url ? array_values($url) : [];

	}

}