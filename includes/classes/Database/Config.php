<?php

class Database_Config
{
	public static $_tableName = "option";

	public function get($key)
	{
		$db = Database::getInstance();
		if ($value = $db->selectOne("`" . self::$_tableName . "`", "value", "`key` = " . $db->escapeString($key))) {
			return $value;
		}
		return null;
	}

	public function getAll()
	{
		$db = Database::getInstance();
		return $db->selectAll("`" . self::$_tableName . "`", "*");
	}

	public function set($key, $value)
	{
		$db = Database::getInstance();
		return $db->update(self::$_tableName, array (
			"value" => $value
		),
		"`key` = " . $db->escapeString($key));
	}
}