<?php

if(!defined("INIT"))
	die("Access denied.");

$lang->grab("error404");

$biomass->grabView("error404", [
	"title" => "{$lang->error404_title} - {$config->site_name}"
]);