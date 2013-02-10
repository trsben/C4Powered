<?php

class Database
{
	public static function register($dbName, $urlData)
	{
		if (empty($urlData->type)) {
			throw new Exception('No database type set');
		}
			
		$className = 'Database_' . ucfirst($urlData->type) . '_Backend';		
		$objBack = new $className($urlData);
		
		Database::manageBackends($dbName, $objBack);
	}

	public static function getInstance($name = null)
	{
		if ($name == null) {
			return Database::manageBackends(Configuration::getInstance()->database->id);
		} else {
			return Database::manageBackends($name);
		}
	}

	public static function manageBackends($name, $objBack = null)
	{
		static $backEnds;
		
		if (!isset($backEnds)) {
			$backEnds = array();
		}
		
		if (!isset($objBack)) {
			// we're retrieving a backend
			if (isset($backEnds['name'])) {
				return $backEnds['name'];
			} else throw new Exception('The specified backend "' . $name . '" was not registered with the database abstraction layer');
		} else {
			// we're adding a backend
			$backEnds['name'] = $objBack;
		}
	}
}