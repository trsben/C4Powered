<?php

if ($formValues['submit']) {
	if ($formValues['username'] == "") {
		$formErrors['username'] = "Username is a required field";
	}
	elseif (isset($formValues['username']) && strlen($formValues['username']) < 5) {
		$formErrors['username'] = "Your username must be longer than 4 characters";
	}
	elseif (preg_match ('/[^a-zA-Z0-9]/i', $formValues['username'])) {
		$formErrors['username'] = "Your username can not contain spaces or special characters";
	}
	elseif (!User::usernameAviable($formValues['username'])) {
		$formErrors['username'] = "This username is already in use";
	}
	
	if ($formValues['email'] == "") {
		$formErrors['email'] = "Email is a required field";
	}
	elseif (isset($formValues['email']) && !isValidEmail($formValues['email'])) {
		$formErrors['email'] = "Please provide a valid email";
	}
	else if (!User::emailAviable($formValues['email'])) {
		$formErrors['email'] = "This email is already in use";
	}
	
	if ($formValues['firstname'] == "") {
		$formErrors['firstname'] = "First name is a required field";
	}
	
	if ($formValues['lastname'] == "") {
		$formErrors['lastname'] = "Last name is a required field";
	}
	
	if ($formValues['password'] == "") {
		$formErrors['password'] = "Password is a required field";
	}
	elseif (isset($formValues['password']) && strlen($formValues['password']) < 7) {
		$formErrors['password'] = "Your password must be longer than 6 characters";
	}
	
	if ($formValues['confirm_password'] == "") {
		$formErrors['confirm_password'] = "Confirm password is a required field";
	}
	elseif ($formValues['password'] !== $formValues['confirm_password']) {
		$formErrors['confirm_password'] = "Your passwords must match";
	}
	
	if (count($formErrors) < 1) {
		$newUser = new User();
		
		$newUser->title = $formValues['username'];
		$newUser->email = $formValues['email'];
		$newUser->firstname = $formValues['firstname'];
		$newUser->lastname = $formValues['lastname'];
		$newUser->password = crypt($formValues['password'], crypt($formValues['password']));
				
		$newUser->save();
	
		$registerComplete = true;
	}
}

function isValidEmail($email){
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}
