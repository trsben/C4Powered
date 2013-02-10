<?php

if ($formValues['submit']) {
	if (($formValues['rememberMe'] && $session->loginAndRememberMe($formValues['username'], $formValues['password'])) 
		|| (!$formValues['rememberMe'] && $session->login($formValues['username'], $formValues['password']))) {
		httpRedirect("/usercp/");
	}
	else if ($formValues['submit']) {
		$formErrors['submit'] = "Login details incorrect";
	}
}