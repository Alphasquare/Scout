<?php

if(!defined("INIT"))
	die("Access denied.");

if(!$user->isLoggedIn())
	$router->redirect("dashboard/signin");

$lang->grab("global, index");

$biomass->grabView("index", [
	"title" => "{$lang->index_title} - {$lang->global_title}",
	"class" => "index"
]);