<?php

if(!defined("INIT"))
	die("Access denied.");

if(!$user->isLoggedIn())
	$router->redirect("dashboard/signin");

$action = isset($router->params[1]) ? $router->params[1] : "list";

if($action == "list") {
	$lang->grab("global, users");

	$pageNum = isset($router->params[2]) ? (int)$router->params[2] : 0;

	if($pageNum < 0)
		$pageNum = 0;

	$resLimitStart = $pageNum * 15;

	$biomass->addSnippet("@list users:(.*?):end;", function($m) use($resLimitStart, $date, $db, $biomass) {

		$list = "";

		$query = $db->query("SELECT * FROM prefix@users ORDER BY name ASC LIMIT :start,15");
		$query->execute([
			"start" => $resLimitStart
		]);

		foreach($query->fetchAll() as $user) {
			$item[$user['id']] = $m[1];

			$biomass->addSnippet("{!list:user.(.*?)}", function($m) use($user) {

				if(isset($user[$m[1]]))
					return $user[$m[1]];

			});

			$list .= $biomass->applySnippets($item[$user['id']]);
		}

		return $list;

	}, "s");

	$biomass->addSnippet("@if page.next:(.*?):end;", function($m) use($resLimitStart, $db, $pageNum) {

		$query = $db->query("SELECT COUNT(*) FROM prefix@users");
		$query->execute();

		if($resLimitStart+15 < $query->fetchColumn())
			return str_replace("@page.next", $pageNum+1, $m[1]);

	}, "s");

	$biomass->addSnippet("@if page.prev:(.*?):end;", function($m) use($pageNum, $db) {

		if($pageNum > 0)
			return str_replace("@page.prev", $pageNum-1, $m[1]);

	}, "s");

	$biomass->grabView("users", [
		"title" => "{$lang->users_title} - {$lang->global_title}",
		"class" => "users"
	]);
}
else if($action == "edit") {
	if(isset($router->params[2])) {
		$id = (int)$router->params[2];

		$query = $db->query("SELECT COUNT(*) FROM prefix@users WHERE id = :id");
		$query->execute([
			"id" => $id
		]);

		if($query->fetchColumn() > 0) {

		}
		else {
			$router->redirect("dashboard/users");
		}
	}
	else {
		$router->redirect("dashboard/users");
	}
}
else if($action == "delete") {
	if(isset($router->params[2])) {
		$id = (int)$router->params[2];

		$query = $db->query("SELECT COUNT(*) FROM prefix@users WHERE id = :id");
		$query->execute([
			"id" => $id
		]);

		if($query->fetchColumn() > 0) {

		}
		else {
			$router->redirect("dashboard/users");
		}
	}
	else {
		$router->redirect("dashboard/users");
	}
}
else {
	$router->redirect("dashboard/404");
}