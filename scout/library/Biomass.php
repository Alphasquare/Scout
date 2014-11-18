<?php

namespace Scout\Library;

use \Exception;

if(!defined("INIT"))
	die();

class Biomass {

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
	 * Store all the snippets
	 * 
	 * @var String
	 */

	private $data = [];

	/**
	 * Load dependencies
	 * 
	 * @param Config $config
	 * @param Router $router
	 * @return Void
	 */

	public function __construct(Config $config, Router $router) {

		$this->config = $config;
		$this->router = $router;

	}

	/**
	 * Add a new snippet
	 * 
	 * @param String $snippet
	 * @param Method $replacement
	 * @return Void
	 */

	public function addSnippet($snippet, $replacement, $type = null) {

		$snippet = "^{$snippet}^{$type}";

		$this->data[$snippet] = $replacement;

	}

	/**
	 * Apply snippets
	 * 
	 * @param String $template
	 * @return String
	 */

	public function applySnippets($template) {

		foreach($this->data as $snippet => $replacement) {
			if(preg_match($snippet, $template))
				$template = preg_replace_callback($snippet, $replacement, $template);
		}

		return $template;

	}

	/**
	 * Get style path
	 * 
	 * @param String $path
	 * @return String
	 */

	public function getPath($path) {

		switch($this->router->module) {
			case 'frontend':
				return ROOT."/addons/themes/{$this->config->site_theme}/{$path}";
			break;
			case 'backend':
				return ROOT."/scout/modules/backend/style/{$path}";
			break;
		}

	}

	/**
	 * Get style URL
	 * 
	 * @param String $path
	 * @return String
	 */

	public function getUrl($path) {

		switch($this->router->module) {
			case 'frontend':
				return "{$this->config->site_url}/addons/themes/{$this->config->site_theme}/{$path}";
			break;
			case 'backend':
				return "{$this->config->site_url}/scout/modules/backend/style/{$path}";
			break;
		}

	}

	/**
	 * Grab a view
	 * 
	 * @param String $view
	 * @return Void
	 */

	public function grabView($view, $data = []) {

		$path = $this->getPath("{$view}.html");

		if(is_file($path)) {
			$this->addSnippet("{!page.(.*?)}", function($m) use($data) {

				if(isset($data[$m[1]]))
					return $data[$m[1]];

			});

			echo $this->applySnippets(file_get_contents($path));
		}
		else {
			throw new Exception("The '{$path}' file doesn't exists.");
		}

	}

}