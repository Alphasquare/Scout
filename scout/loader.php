<?php

namespace Scout;

use \Whoops\Run as WhoopsRun;
use \Whoops\Handler\PrettyPageHandler as WhoopsHandler;

use \Exception;

use Scout\Library as Lib;

if(!defined("INIT"))
	die("Access denied.");

require_once ROOT."/vendor/autoload.php";

$whoops = new WhoopsRun;
$whoops->pushHandler(new WhoopsHandler);
$whoops->register();

foreach(glob(ROOT."/scout/library/*.php") as $path) {
	if(is_file($path))
		require_once $path;
}

$session = new Lib\Session;
$form = new Lib\Form;
$config = new Lib\Config;
$date = new Lib\Date($config);
$db = new Lib\Database($config);
$logs = new Lib\Logs($db);
$user = new Lib\User($session, $db);
$router = new Lib\Router($config);
$lang = new Lib\Language($config, $router);
$biomass = new Lib\Biomass($config, $router);

require_once ROOT."/scout/snippets.php";

$path = ROOT."/scout/modules/{$router->module}/{$router->page}.php";

if(is_file($path)) {
	require_once $path;
}
else {
	throw new Exception("The '{$path}' file doesn't exists.");
}