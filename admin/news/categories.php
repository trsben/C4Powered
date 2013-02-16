<?php

$adminPage = true;
require_once("../../includes/bootstrap.php");

// redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$categories = new News_Category_Collection();
$categories->loadCategories(false);

$smarty->assign_by_ref("categories", $categories);
$smarty->assign('dashboardTitle', 'News Categories');
$smarty->assign('pageClass', 'admin-categories');

// Display the page template
$smarty->display('news/categories.tpl');
exitScript();