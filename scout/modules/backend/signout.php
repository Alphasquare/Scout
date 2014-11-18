<?php

if(!defined("INIT"))
	die("Access denied.");

if($user->isLoggedIn()) {
	$logs->register("User signed out with email '{$user->email}'");

	$user->doLogout();

	$router->redirect("");
}
else {
	$router->redirect("dashboard/signin");
}