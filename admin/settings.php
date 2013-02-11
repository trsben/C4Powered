<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect("/admin");
}

// Assign vars
$smarty->assign("formErrors", $formErrors);
$smarty->assign("formValues", $formValues);
$smarty->assign('dashboardTitle', 'Settings');
$smarty->assign('pageClass', 'admin-settings');

// Display the page template
$smarty->display('settings.tpl');
exitScript();
