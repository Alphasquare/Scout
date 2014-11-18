<?php

if(!defined("INIT"))
	die("Access denied.");

$biomass->addSnippet("@partial '(.*?)';", function($m) use($biomass) {

	$path = $biomass->getPath("partials/{$m[1]}.html");

	if(is_file($path)) {
		return $biomass->applySnippets(file_get_contents($path));
	}
	else {
		throw new Exception("The '{$path}' file doesn't exists.");
	}

});

$biomass->addSnippet("@asset '(.*?):(.*?)';", function($m) use($biomass) {

	switch($m[1]) {
		case 'css':
			return "<link href=\"{$biomass->getUrl("assets/css/{$m[2]}.css")}\" rel=\"stylesheet\" />";
		break;
		case 'js':
			return "<script src=\"{$biomass->getUrl("assets/js/{$m[2]}.js")}\" type=\"text/javascript\"></script>";
		break;
	}

});

$biomass->addSnippet("{!config.(.*?)}", function($m) use($config) {

	return $config->$m[1];

});

$biomass->addSnippet("{!lang.(.*?)}", function($m) use($lang) {

	return $lang->$m[1];

});

$biomass->addSnippet("{!form.(.*?)}", function($m) use($form) {

	switch($m[1]) {
		case 'response':
			return $form->getResponse();
		break;
		default:
			if(isset($form->$m[1]))
				return $form->$m[1];
		break;
	}

});

$biomass->addSnippet("{!user.(.*?)}", function($m) use($user) {

	return $user->$m[1];

});

$biomass->addSnippet("@if form.(.*?):(.*?):else:(.*?):end;", function($m) use($form) {

	if(isset($form->$m[1])) {
		return $m[2];
	}
	else {
		return $m[3];
	}

});