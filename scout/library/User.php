<?php

namespace Scout\Library;

if(!defined("INIT"))
	die("Access denied.");

class User {

	/**
	 * Session class instance
	 * 
	 * @var Session
	 */

	private $session;

	/**
	 * Database class instance
	 * 
	 * @var Database
	 */

	private $db;

	/**
	 * Store user informations
	 * 
	 * @var Misc[]
	 */

	private $data = [];

	/**
	 * Load dependencies and user informations
	 * 
	 * @param Session $session
	 * @param Database $db
	 * @return Void
	 */

	public function __construct(Session $session, Database $db) {

		$this->session = $session;
		$this->db = $db;

		if($this->isLoggedIn()) {
			$query = $this->db->query("SELECT * FROM prefix@users WHERE lastToken = :token");
			$query->execute([
				"token" => $this->session->scout_userToken
			]);

			$this->data = $query->fetchAll()[0];
		}

	}

	/**
	 * Validate token
	 * 
	 * @param String $token
	 * @return Boolean
	 */

	public function validateToken($token) {

		$query = $this->db->query("SELECT COUNT(*) FROM prefix@users WHERE lastToken = :token");
		$query->execute([
			"token" => $token
		]);

		if($query->fetchColumn() > 0) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * Generate token
	 * 
	 * @return String
	 */

	public function generateToken() {

		return hash("sha256", INIT.$_SERVER['REMOTE_ADDR'].time());

	}

	/**
	 * Check if user is logged in
	 * 
	 * @return Boolean
	 */

	public function isLoggedIn() {

		if(isset($this->session->scout_userToken) && $this->validateToken($this->session->scout_userToken)) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * Do user login
	 * 
	 * @param String $email
	 * @param String $password
	 * @return Boolean
	 */

	public function doLogin($email, $password) {

		if(!$this->isLoggedIn()) {
			$query = $this->db->query("SELECT COUNT(*) FROM prefix@users WHERE email = :email AND password = :password");
			$query->execute([
				"email" => $email,
				"password" => md5($password)
			]);

			if($query->fetchColumn() > 0) {
				$token = $this->generateToken();

				$query = $this->db->query("UPDATE prefix@users SET lastToken = :token, lastSignin = NOW() WHERE email = :email AND password = :password");
				$query->execute([
					"token" => $token,
					"email" => $email,
					"password" => md5($password)
				]);

				$this->session->scout_userToken = $token;

				return true;
			}
			else {
				return false;
			}
		}

	}

	/**
	 * Do user logout
	 * 
	 * @return Void
	 */

	public function doLogout() {

		if($this->isLoggedIn()) {
			unset($this->session->scout_userToken);
		}

	}

	/**
	 * Get user information
	 * 
	 * @param String $key
	 * @return Misc
	 */

	public function __get($key) {

		if(isset($this->data[$key])) {
			return $this->data[$key];
		}
		else {
			throw new Exception("The '{$key}' user information doesn't exists.");
		}

	}

}