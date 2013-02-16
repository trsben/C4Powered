<?php

$adminPage = true;
require_once("../../includes/bootstrap.php");

// redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$articles = new News_Article_Collection();
$articles->loadNews(false);

$smarty->assign_by_ref("articles", $articles);
$smarty->assign('dashboardTitle', 'News Articles');
$smarty->assign('pageClass', 'admin-articles');

// Display the page template
$smarty->display('news/articles.tpl');
exitScript();