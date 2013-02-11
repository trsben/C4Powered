<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

if ($session->isLoggedIn() && $session->getUserObject()->is_admin) {
	httpRedirect("/admin");
}

// Check for login attempt
$formValues = $request->getPostVariables();
if ($formValues['submit']) {
	if (($formValues['rememberMe'] && $session->loginAndRememberMe($formValues['username'], $formValues['password'])) 
		|| (!$formValues['rememberMe'] && $session->login($formValues['username'], $formValues['password']))) {
		httpRedirect("/admin");
	}
	else {
		$formErrors['main'] = "Login details incorrect";
	}
}
else {
	$formErrors['main'] = "You are required to log in using a admin account to view this page.";
}

// Assign vars
$smarty->assign("formErrors", $formErrors);
$smarty->assign("formValues", $formValues);
$smarty->assign('pageClass', 'admin-login');

// Display the page template
$smarty->display('login.tpl');
exitScript();
