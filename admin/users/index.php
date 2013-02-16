<?php

$adminPage = true;
require_once("../../includes/bootstrap.php");

// redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$users = new User_Collection();
$users->loadUsers();

$smarty->assign_by_ref("users", $users);
$smarty->assign('dashboardTitle', 'Users');
$smarty->assign('pageClass', 'admin-users');

// Display the page template
$smarty->display('users/users.tpl');
exitScript();