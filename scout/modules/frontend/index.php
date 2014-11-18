<?php

if(!defined("INIT"))
	die("Access denied.");

$biomass->grabView("index", [
	"title" => "{$config->site_name} - {$config->site_slogan}",
	"class" => "index"
]);