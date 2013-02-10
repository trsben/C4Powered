<?php

class User_Login extends GenericObject
{
	const DURATION = 30; // days
	const COOKIE_NAME = "RememberMe";

	protected $_tableName = "user_login";
	protected $_tableDefinition = array(
		'id' => 'id',
		'code' => 'code',
		'userId' => 'user_id',
		'lastLogin' => 'last_login',
	);
	protected $_db;

	protected static $_cookieGenerator;

	public function __construct($id = null)
	{
		$this->initialise($this->_tableName, $this->_tableDefinition, $id);
		$this->_db = Database::getInstance();
	}

	public static function addLoginCookie($id)
	{
		if ((int)$id <= 0) {
			throw new InvalidArgumentException("Invalid user id: `$id`");
		}
		self::removeLoginsByUserId($id);
		$login = new self();
		$login->code = md5(time() . $id);
		$login->userId = (int)$id;
		$login->save();
		$login->setCookie();
		unset($login);
	}

	public static function removeLoginCookieByUserId($userId)
	{
		self::removeLoginsByUserId($userId);
		self::deleteCookie();
	}
	
	public static function removeLoginsByUserId($userId)
	{
		$db = Database::getInstance();
		$db->delete("user_login", "user_id = " . $userId);
	}

	public function setCookie()
	{
		CookieStore::set(self::COOKIE_NAME, $this->code, self::DURATION);
	}


	public function deleteCookie()
	{
		CookieStore::clear(self::COOKIE_NAME);
	}

}
