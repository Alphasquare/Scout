<?php

namespace Scout\Library;

use \Exception;

if(!defined("INIT"))
	die();

class Form {

	/**
	 * Store form response
	 * 
	 * @var String
	 */

	private $response;

	/**
	 * Verify if a form field was filled
	 * 
	 * @param String $key
	 * @return Boolean
	 */

	public function __isset($key) {

		if(isset($_POST[$key]) && strlen(trim($_POST[$key])) > 0) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * Get a form field
	 * 
	 * @param String $key
	 * @return Misc
	 */

	public function __get($key) {

		if(isset($_POST[$key])) {
			return $_POST[$key];
		}
		else {
			throw new Exception("The '{$key}' form field was not set.");
		}

	}

	/**
	 * Set form response
	 * 
	 * @param String $type
	 * @param String $message
	 * @return Void
	 */

	public function setResponse($type, $message) {

		$this->response = "<div class=\"response {$type}\">{$message}</div>";

	}

	/**
	 * Get form response
	 * 
	 * @return String
	 */

	public function getResponse() {

		return $this->response;

	}

}