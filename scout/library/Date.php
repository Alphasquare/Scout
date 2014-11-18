<?php

namespace Scout\Library;

use \DateTime;
use \DateTimeZone;

if(!defined("INIT"))
	die("Access denied.");

class Date {

	/**
	 * Config class instance
	 * 
	 * @var Config
	 */	

	private $config;

	/**
	 * Load dependencies
	 * 
	 * @param Config $config
	 * @return Void
	 */

	public function __construct(Config $config) {

		$this->config = $config;

	}

	/**
	 * Apply time zone and format a date
	 * 
	 * @param String $date
	 * @param String $format
	 * @return String
	 */

	public function convert($date, $format) {

		$date = new DateTime($date, new DateTimeZone($this->config->site_timezone));

		return $date->format($format);

	}

	/**
	 * Get current date
	 * 
	 * @param String $format
	 * @return String
	 */

	public function getCurrent($format) {

		$date = new DateTime("now", new DateTimeZone($this->config->site_timezone));

		return $date->format($format);

	}
	
}