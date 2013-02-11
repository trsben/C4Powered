<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

// redirect them if they are logged in
if ($session->isLoggedIn()) {
	httpRedirect($config->baseurl . "login.php");
}

$smarty->assign('pageClass', 'admin-index');

// Display the page template
$smarty->display('index.tpl');
exitScript();