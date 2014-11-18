<?php

if(!defined("INIT"))
	die("Access denied.");

if($user->isLoggedIn())
	$router->redirect("dashboard");

$lang->grab("global, signin");

if(isset($form->signin)) {
	if(!isset($form->email, $form->password)) {
		$form->setResponse("error", $lang->signin_form_response_1);
	}
	else if($user->doLogin($form->email, $form->password)) {
		$logs->register("User signed in with email '{$form->email}'");

		$router->redirect("dashboard");
	}
	else {
		$form->setResponse("error", $lang->signin_form_response_2);
	}
}

$biomass->grabView("signin", [
	"title" => "{$lang->signin_title} - {$lang->global_title}"
]);