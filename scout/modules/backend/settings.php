<?php

if(!defined("INIT"))
	die("Access denied.");

if(!$user->isLoggedIn())
	$router->redirect("dashboard/signin");

$lang->grab("global, settings");

$biomass->addSnippet("@list languages:(.*?):end;", function($m) use($config) {

	$list = "";
	$i = 0;

	foreach(glob(ROOT."/addons/languages/*") as $path) {
		if(is_dir($path)) {
			$lang = basename($path);
			$item[$i] = $m[1];

			if($lang == $config->site_lang) {
				$active = " selected";
			}
			else {
				$active = null;
			}

			$item[$i] = str_replace("{!list:language.id}", $lang, $item[$i]);
			$item[$i] = str_replace("{!list:language.active}", $active, $item[$i]);

			$list .= $item[$i];
			$i++;
		}
	}

	return $list;

}, "s");

$biomass->addSnippet("@list themes:(.*?):end;", function($m) use($config) {

	$list = "";
	$i = 0;

	foreach(glob(ROOT."/addons/themes/*") as $path) {
		if(is_dir($path)) {
			$theme = basename($path);
			$item[$i] = $m[1];

			if($theme == $config->site_theme) {
				$active = " selected";
			}
			else {
				$active = null;
			}

			$item[$i] = str_replace("{!list:theme.id}", $theme, $item[$i]);
			$item[$i] = str_replace("{!list:theme.active}", $active, $item[$i]);

			$list .= $item[$i];
			$i++;
		}
	}

	return $list;

}, "s");

$biomass->addSnippet("@list timezones:(.*?):end;", function($m) use($config) {

	$list = "";
	$i = 0;

	foreach(timezone_identifiers_list() as $timezone) {
		$item[$i] = $m[1];

		if($timezone == $config->site_timezone) {
			$active = " selected";
		}
		else {
			$active = null;
		}

		$item[$i] = str_replace("{!list:timezone.id}", $timezone, $item[$i]);
		$item[$i] = str_replace("{!list:timezone.active}", $active, $item[$i]);

		$list .= $item[$i];
		$i++;
	}

	return $list;

}, "s");

if(isset($form->update)) {
	if(!isset($form->site_name, $form->site_slogan, $form->site_url, $form->site_lang, $form->site_theme, $form->site_timezone)) {
		$form->setResponse("error", $lang->settings_form_response_1);
	}
	else {
		$config->update("site", [
			"site_name" => $form->site_name,
			"site_slogan" => $form->site_slogan,
			"site_url" => $form->site_url,
			"site_lang" => $form->site_lang,
			"site_theme" => $form->site_theme,
			"site_timezone" => $form->site_timezone
		]);

		$logs->register("Settings updated by '{$user->email}'");

		$form->setResponse("success", $lang->settings_form_response_2);
	}
}

$biomass->grabView("settings", [
	"title" => "{$lang->settings_title} - {$lang->global_title}",
	"class" => "settings"
]);