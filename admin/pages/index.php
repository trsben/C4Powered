<?php

$adminPage = true;
require_once("../../includes/bootstrap.php");

// redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$pages = new Page_Collection();
$pages->loadPages(false);

$smarty->assign_by_ref("pages", $pages);
$smarty->assign('dashboardTitle', 'Pages');
$smarty->assign('pageClass', 'admin-pages');

// Display the page template
$smarty->display('pages/pages.tpl');
exitScript();