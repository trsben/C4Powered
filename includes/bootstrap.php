<?php

defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));

set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/includes/classes'),
	realpath(APPLICATION_PATH . '/includes'),
	get_include_path(),
)));

include_once("commonfuncs.php");

$config = Configuration::create(APPLICATION_PATH . '/includes/configuration/', array('common_conf.xml'));

// Setup the request object
$request = Request::getInstance();

// Setup the main database connection
Database::register($config->database->id, $config->database);
$db = Database::getInstance($config->database->id);

// Setup the smarty templating engine
$smarty = SmartySingleton::getInstance();

$smarty->template_dir  = $config->includes . $config->smarty->templates;
$smarty->compile_dir   = $config->includes . $config->smarty->compiled;
$smarty->plugins_dir[] = $config->includes . $config->smarty->functions;

// Register some basic variables for smarty
$smarty->assign("url",         $config->baseurl);
$smarty->assign("cssurl",      $config->urls->css);
$smarty->assign("jsurl",       $config->urls->scripts);
$smarty->assign("imageurl",    $config->urls->images);
$smarty->assign("currenturl",  $_SERVER['REQUEST_URI']);

// Set up breadcrumbs
$breadcrumb = new Breadcrumb();

// Setup the session
$session = new User_Session($config->session);

//$smarty->assign_by_ref("currentMember", $session->getUserObject());
//$smarty->assign("isLoggedIn", $session->isLoggedIn());