<?php

namespace Scout\Library;

use \Exception;

if(!defined("INIT"))
	die("Access denied.");

class Session {

	/**
	 * Initialize PHP sessions
	 * 
	 * @return Void
	 */

	public function __construct() {

		session_start();

	}

	/**
	 * Verify if a session exists
	 *
	 * @param String $key
	 * @return Boolean
	 */

	public function __isset($key) {

		return isset($_SESSION[$key]);

	}

	/**
	 * Get a session
	 * 
	 * @param String $key
	 * @return Misc
	 */

	public function __get($key) {

		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		else {
			throw new Exception("The '{$key}' session doesn't exists.");
		}

	}

	/**
	 * Create/rewrite a session
	 * 
	 * @param String $key
	 * @param Misc $value
	 * @return Void
	 */

	public function __set($key, $value) {

		$_SESSION[$key] = $value;

	}

	/**
	 * Delete a session
	 * 
	 * @param String $key
	 * @return Void
	 */

	public function __unset($key) {

		if(isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}
		else {
			throw new Exception("The '{$key}' session doesn't exists.");
		}

	}

}