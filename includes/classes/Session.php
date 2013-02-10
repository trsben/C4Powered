<?php

abstract class Session
{
	protected $phpSessionID;
	protected $tableUsers = "user";
	protected $fieldLoggedIn = "logged_in"; 
	protected $fieldUserID  = "user_id";
	protected $namespace = 'Session';
	protected $loginHandler = null;

	public abstract function getUserObject();

	public function __construct($options = null)
	{
		$this->setOptions($options);
		$this->initiateLoginHandler($this);
		$this->initiateSession();
	}

	protected function setOptions($options = null)
	{
		if (null != $options) {
			$params = $options->files;

			foreach ($params as $optionKey => $optionValue) {
				ini_set('session.' . $optionKey, $optionValue);
			}
		}
	}

	protected function initiateLoginHandler(Session $session)
	{
		$this->setLoginHandler(new User_Login_Handler($session));
	}

	public function setLoginHandler(User_Login_Handler $loginHandler)
	{
		$this->loginHandler = $loginHandler;
	}

	protected function initiateSession()
	{
		session_start();
		$this->phpSessionID = session_id();
	}

	public function isLoggedIn()
	{
		if (isset($this->loggedIn)) {
			return $this->loggedIn;
		} else {
			return false;
		}
	}

	public function login($identity, $password)
	{
		return $this->loginHandler->login($identity, $password);
	}

	public function loginAndRememberMe($identity, $password)
	{
		return $this->loginHandler->loginAndRememberMe($identity, $password);
	}

	public function logout()
	{
		return $this->loginHandler->logout();
	}

	public function attemptLoginUsingRememberMe()
	{
		$this->loginHandler->attemptLoginUsingRememberMe();
	}

	public function getUserID()
	{
		if ($this->loggedIn) {
			return $this->userID;
		} 
		else {
			return false;
		}
	}

	public function getSessionIdentifier()
	{
		return $this->phpSessionID;
	}


	protected function regenerateId()
	{
		session_regenerate_id();
		return $this;
	}

	public function __get($var)
	{		
		if (isset($_SESSION[$this->namespace][$var])) {
			return $_SESSION[$this->namespace][$var];
		}

		return null;
	}

	public function __set($var, $value)
	{		
		$_SESSION[$this->namespace][$var] = $value;
	}

	public function __isset($var)
	{		
		return isset($_SESSION[$this->namespace][$var]);
	}

	public function __unset($var)
	{
	
		if (isset($_SESSION[$this->namespace][$var])) {
			unset($_SESSION[$this->namespace][$var]);
		}
	}

	public function getAuthTable()
	{
		return $this->tableUsers;
	}

}