<?php

namespace Scout\Library;

use \Exception;

if(!defined("INIT"))
	die("Access denied.");

class Config {

	/**
	 * Store all the configuration strings
	 * 
	 * @var Misc[]
	 */

	private $data = [];

	/**
	 * Load all the configuration strings
	 * 
	 * @return Void
	 */

	public function __construct() {

		foreach(glob(ROOT."/scout/storage/configs/*.ini") as $path) {
			if(is_file($path))
				$this->data = array_merge($this->data, parse_ini_file($path));
		}

	}

	/**
	 * Update/create a configuration file
	 * 
	 * @param String $file
	 * @param Misc[] $data
	 * @return Void
	 */

	public function update($file, $data = []) {

		$path = ROOT."/scout/storage/configs/{$file}.ini";
		$content = "";

		foreach($data as $key => $value) {
			if(is_int($key) || is_bool($key)) {
				$content .= "{$key} = {$value}\n";
			}
			else {
				$content .= "{$key} = \"{$value}\"\n";
			}
		}

		file_put_contents($path, $content);

	}

	/**
	 * Get configuration string
	 * 
	 * @param String $key
	 * @return Misc
	 */

	public function __get($key) {

		if(isset($this->data[$key])) {
			return $this->data[$key];
		}
		else {
			throw new Exception("The '{$key}' configuration string doesn't exists.");
		}

	}

}