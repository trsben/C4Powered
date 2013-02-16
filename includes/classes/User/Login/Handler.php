<?php

class User_Login_Handler
{

	protected $session = null;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	protected function verifySessionLoginCredentials($identity, $password)
	{
		$userRow = $this->getUserRow($identity);
		if (isset($userRow) && $userRow["password"] === crypt($password, $userRow["password"])) {
			return $userRow;
		} else {
			return array();
		}
	}

	public function attemptLoginUsingRememberMe()
	{
		$loginDetails = User_Login::getLoginByCode(isset($_COOKIE[User_Login::COOKIE_NAME]) ? $_COOKIE[User_Login::COOKIE_NAME] : -1);
		if (is_null($loginDetails))
			return false;

		$userRow = $this->getUserRowForId($loginDetails->userId);
		$this->securedLogin($userRow);
		$this->updateLoginCount($userRow);
		User_Login::addLoginCookie($userRow['id']);
	}

	protected function getUserRowForId($id)
	{
		$db = Database::getInstance();
		return $db->selectRow($this->session->getAuthTable(), "id, login_count, last_login, password", "id = " . $id . " AND activated = 1");
	}

	public function securedLogin($userRow)
	{
		$this->session->userPermissions = false;
		$this->session->userID = $userRow['id'];
		$this->session->loggedIn = true;
	}

	protected function updateLoginCount($userRow)
	{
		$db = Database::getInstance();
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		$db->update($this->session->getAuthTable(), array("login_count" => $userRow['login_count'] + 1, "last_login" => "NOW()", "last_ip" => $ipAddress), "id = " . $db->escapeString($userRow['id']));
	}

	public function logout()
	{
		User_Login::removeLoginCookieByUserId($this->session->userID);
		return $this->logoutActions();
	}

	protected function logoutActions()
	{
		$this->session->loggedIn = false;
		$this->session->userID = false;
		$this->session->_restricted = false;
	}

	protected function setRestricted($value)
	{
		$this->session->_restricted = (bool) $value;
	}
	
	public function login($identity, $password)
	{
		$userRow = $this->verifyUserLoginCredentials($identity, $password);
		if (!empty($userRow)) {
			$this->securedLogin($userRow);
			$this->setRestricted(false);
			$this->updateLoginCount($userRow);
			return true;
		} else {
			return false;
		}
	}

	public function loginAndRememberMe($identity, $password)
	{
		$status = $this->login($identity, $password);
		if ($status) {
			User_Login::addLoginCookie($this->session->userID);
			return true;
		} else {
			return false;
		}
	}

	public function restrictedLogin($userId)
	{
		$db = Database::getInstance();
		$this->logout();
		$userRow = $db->selectRow($this->session->getAuthTable(), "id, login_count, last_login",  "id = " . $db->escapeString($userId) . " AND activated = 1");
		if (!empty($userRow)) {
			$this->securedLogin($userRow);
			$this->setRestricted(true);
			return true;
		} else {
			return false;
		}
	}

	public function verifyUserLoginCredentials($identity, $password)
	{		
		$userRow = $this->getUserRow($identity);
		
		if (isset($userRow) && $userRow["password"] === crypt($password, $userRow["password"])) {
			return $userRow;
		} else {
			return array();
		}
	}

	protected function getUserRow($identity)
	{
		$db = Database::getInstance();
		return $db->selectRow($this->session->getAuthTable(), "*", "md5(title) = " . $db->escapeString(md5($identity)) . " AND activated = 1");
	}

	public function logoutWithoutDeletingCookie()
	{
		$this->logoutActions();
	}

}