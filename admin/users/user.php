<?php

$adminPage = true;
require_once("../../includes/bootstrap.php");

// redirect them if they are logged in
if (!$session->isLoggedIn() || !$session->getUserObject()->is_admin) {
	httpRedirect($config->baseurl_backend . "login.php");
}

$userId = (int) $request->getParameterValue("id");
$user = new User($userId);

$formErrors = array();
$formNotices = array();
$formValues = array();

switch(strtolower($request->getParameterValue("action"))) {
	case "save":
		$userData = array(
			"title"        => $request->getParameterValue("title"),
			"firstname"    => $request->getParameterValue("firstname"),
			"lastname"     => $request->getParameterValue("lastname"),
			"password"     => $request->getParameterValue("password"),
			"email"        => $request->getParameterValue("email"),
			"activated"    => (bool) $request->getParameterValue("activated"),
			"is_admin"	   => (bool) $request->getParameterValue("is_admin"),
		);

		// check email is valid
		if (empty($userData['email']) || !checkEmailAddress($userData['email'])) {
			$formErrors["email"] = "Please enter a valid email address";
		} elseif ($userData['email'] != $user->email && $db->selectOne("user", "id", "md5(email) = " . $db->escapeString(md5($userData['email'])))) {
			$formErrors["email"] = "The email address you entered is already registered on this website";
		}

		// check if changing password
		if (!empty($userData['password'])) {
			$user->password = crypt($userData['password']);
			$formNotices[] = "Password updated";
		}
		else {
			unset($userData['password']);
		}

		// check required fields are present
		if (empty($userData['title'])) {
			$formErrors["title"] = "Username is a required field";
		}
		if (empty($userData['firstname']) || empty($userData['lastname'])) {
			$formErrors["name"] = "Please enter a first name and surname";
		}

		// if no errors then save data
		if (empty($formErrors)) {
			$user->title         = $userData['title'];
			$user->firstname     = $userData['firstname'];
			$user->lastname      = $userData['lastname'];
			$user->email         = $userData['email'];
			$user->activated     = $userData['activated'];
			$user->is_admin	     = $userData['is_admin'];

			$user->save();

			$formNotices[] = "User updated";
		}
	break;
	case "delete":
		if ($user->id == $userId) {
			$user->destroy();
			httpRedirect($config->baseurl_backend . "users/index.php");
		}
	break;
}

if ($user->id != null) {
	$formValues = array(
		"id"	       => $user->id,
		"title"        => $user->title,
		"firstname"    => $user->firstname,
		"lastname"     => $user->lastname,
		"email"        => $user->email,
		"activated"    => (bool) $user->activated,
		"is_admin"	   => (bool) $user->is_admin,
	);
}

$smarty->assign_by_ref("user", $user);
$smarty->assign("formErrors", $formErrors);
$smarty->assign("formValues", $formValues);
$smarty->assign("formNotices", $formNotices);
$smarty->assign("dashboardTitle", (!is_null($userId)) ? "Edit User" : "New User");
$smarty->assign("pageClass", "admin-user");

// Display the page template
$smarty->display("users/user.tpl");
exitScript();