<?php

namespace Scout\Library;

use \PDO;
use \PDOException;

if(!defined("INIT"))
	die("Access denied.");

class Database extends PDO {

	/**
	 * Config class instance
	 * 
	 * @var Config
	 */

	private $config;

	/**
	 * Load dependencies and start database connection
	 * 
	 * @param Config $config
	 * @return Void
	 */

	public function __construct(Config $config) {

		$this->config = $config;

		$dsn = "{$this->config->db_driver}:host={$this->config->db_hostname};port={$this->config->db_port};dbname={$this->config->db_name}";
		$username = $this->config->db_username;
		$password = $this->config->db_password;

		parent::__construct($dsn, $username, $password);
		parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		parent::setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	}

	/**
	 * Prepare a query
	 * 
	 * @param String $sql
	 * @return Object
	 */

	public function query($sql) {

		if(preg_match("^prefix@^", $sql))
			$sql = str_replace("prefix@", $this->config->db_tables_prefix, $sql);

		return parent::prepare($sql);

	}

}