<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

// Redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$smarty->assign('dashboardTitle', 'Dashboard');
$smarty->assign('pageClass', 'admin-index');

// Display the page template
$smarty->display('index.tpl');
exitScript();