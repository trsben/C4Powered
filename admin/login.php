<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

if ($session->isLoggedIn() && $session->getUserObject()->is_admin) {
	httpRedirect("/admin");
}

$formErrors = array();

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

if (empty($formErrors) && !$user->is_admin) {
	$formErrors['main'] = "You do not have the current permissions to view this page";
}

// Assign vars
$smarty->assign("formErrors", $formErrors);
$smarty->assign("formValues", $formValues);
$smarty->assign("pageClass", "admin-login");

// Display the page template
$smarty->display("login.tpl");
exitScript();
