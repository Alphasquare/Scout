<?php

if(!defined("INIT"))
	die("Access denied.");

$lang->grab("global, logs");

$pageNum = isset($router->params[1]) ? (int)$router->params[1] : 0;

if($pageNum < 0)
	$pageNum = 0;

$resLimitStart = $pageNum * 15;

$biomass->addSnippet("@list logs:(.*?):end;", function($m) use($resLimitStart, $date, $db, $biomass) {

	$list = "";

	$query = $db->query("SELECT * FROM prefix@logs ORDER BY date DESC LIMIT :start,15");
	$query->execute([
		"start" => $resLimitStart
	]);

	foreach($query->fetchAll(\PDO::FETCH_ASSOC) as $log) {
		$item[$log['id']] = $m[1];

		$biomass->addSnippet("{!list:log.(.*?)}", function($m) use($date, $log) {

			switch($m[1]) {
				case 'date':
					return $date->convert($log['date'], "j F Y H:i:s");
				break;
				default:
					if(isset($log[$m[1]]))
						return $log[$m[1]];
				break;
			}

		});

		$list .= $biomass->applySnippets($item[$log['id']]);
	}

	return $list;

}, "s");

$biomass->addSnippet("@if page.next:(.*?):end;", function($m) use($resLimitStart, $db, $pageNum) {

	$query = $db->query("SELECT COUNT(*) FROM prefix@logs");
	$query->execute();

	if($resLimitStart+15 < $query->fetchColumn())
		return str_replace("@page.next", $pageNum+1, $m[1]);

}, "s");

$biomass->addSnippet("@if page.prev:(.*?):end;", function($m) use($pageNum, $db) {

	if($pageNum > 0)
		return str_replace("@page.prev", $pageNum-1, $m[1]);

}, "s");

$biomass->grabView("logs", [
	"title" => "{$lang->logs_title} - {$lang->global_title}",
	"class" => "logs"
]);