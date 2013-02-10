<?php

class User extends GenericObject
{
	protected $_tableName = "user";
	protected $_tableDefinition = array(
		"id"                       => "id",
		"title"                    => "title",
		"firstname"                => "firstname",
		"lastname"                 => "lastname",
		"password"                 => "password",
		"email"                    => "email",
		"activated"                => "activated",
		"login_count"              => "login_count",
		"last_ip"                  => "last_ip",
		"last_login"               => "last_login",
		"is_admin"				   => "is_admin",
	);
	
	protected $db;

	public function __construct($id = null)
	{
		$this->db = Database::getInstance();
	
		$this->initialise($this->_tableName, $this->_tableDefinition, $id);
	}

	public function save()
	{
		parent::save();
	}

	public function destroy()
	{
		parent::destroy();
	}

	public function getFullName()
	{
		return trim($this->firstname . ' ' . $this->lastname);
	}
	
	public static function getUserByTitle($username)
	{
		$db = Database::getInstance();
		$row = $db->selectRow("user", "*", "LOWER(title) = " . $db->escapeString($username));
		
		if ($row) {
			return new User($row['id']);
		}
		else {
			return false;
		}
	}
}