<?php

namespace Scout\Library;

if(!defined("INIT"))
	die("Access denied.");

class Logs {

	/**
	 * Database class instance
	 * 
	 * @var Database
	 */

	private $db;

	/**
	 * Load dependencies
	 * 
	 * @param Database $db
	 * @return Void
	 */

	public function __construct(Database $db) {

		$this->db = $db;

	}

	/**
	 * Register a new log
	 * 
	 * @param String $description
	 * @return Void
	 */

	public function register($description) {

		$query = $this->db->query("INSERT INTO prefix@logs (description, date) VALUES (:description, NOW())");
		$query->execute([
			"description" => $description
		]);

	}

}