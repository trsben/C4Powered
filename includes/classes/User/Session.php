<?php

class User_Session extends Session
{
	protected $fieldLoggedIn    = "logged_in";   // the field for whether the user is logged in
	protected $fieldUserID      = "user_id";     // the field for whether the user is logged in
	protected $namespace = 'UserSession';

	protected function initiateLoginHandler(Session $session)
	{
		$this->setLoginHandler(new User_Login_Handler($session));
	}

	public function getUserObject()
	{
		if ($this->isLoggedIn()) {
			 return new User($this->getUserID(), null, $this->_restricted);
		}
		
		return null;
	}

	public function restrictedLogin($userId)
	{
		$this->loginHandler->restrictedLogin($userId);
	}

	protected function logoutWithoutDeletingCookie()
	{
		$this->loginHandler->logoutWithoutDeletingCookie();
	}
}