<?php

/* Routes Online, http://www.routesonline.com */
/* Copyright (c) Fluid Creativity, 2008. */

class GenericObject
{
	protected $_id;
	protected $_table;
	protected $_tableDefinition;
	protected $_dbFields;
	protected $_isLoaded = false;
	protected $_isModified = false;
	protected $_modifiedFields;
	protected $_className = false;

	public function __call($name, $args)
	{
		$this->reload();

		$className = ucwords(strtolower(str_replace("get", "", $name)));
		$fileName  = $className . ".php";
		$linkField = strtolower($className) . "_id";
		$object    = null;

		if (isset($this->_dbFields[$linkField])) {
			try {
				$object = new $className($this->_dbFields[$linkField]);
			} catch(Exception $e) {
				// probably if class does not exist
			}
		}

		if ($object instanceof $className) {
			return $object;
		} else {
			throw new BadMethodCallException();
		}
	}

	public function __clone()
	{
		if (!$this->_isLoaded) {
			$this->load();
		}
		
		$this->_id = null;
		$this->_isLoaded = false;
		$this->_isModified = true;
		
		foreach ($this->_dbFields as $fieldKey => $value) {
			if ($fieldKey != "id") $this->_modifiedFields[$fieldKey] = true;
		}
	}

	public function __get($field)
	{
		if (!$this->_isLoaded) {
			$this->load();
		}

		$fieldKey = $this->getFieldKey($field);

		return (isset($this->_dbFields[$fieldKey])) ? $this->_dbFields[$fieldKey] : false;
	}

	public function __set($field, $value)
	{
		if (!$this->_isLoaded && $this->_id) {
			$this->load();
		}

		$fieldKey = $this->getFieldKey($field);

		if (!isset($this->_dbFields[$fieldKey]) || $this->_dbFields[$fieldKey] != $value) {
			$this->_dbFields[$fieldKey] = $value;
			$this->_modifiedFields[$fieldKey] = true;
			$this->_isModified = true;
		}
	}

	public function __isset($field)
	{
		if (!$this->_isLoaded) {
			$this->load();
		}

		$fieldKey = $this->getFieldKey($field);

		return isset($this->_dbFields[$fieldKey]);
	}

	public function __unset($field)
	{
		if (!$this->_isLoaded) {
			$this->load();
		}

		$fieldKey = $this->getFieldKey($field);

		if (isset($this->_dbFields[$fieldKey])) {
			$this->_dbFields[$fieldKey] = null;
		}
	}

	public function reload()
	{
		$db = Database::getInstance();

		if ($row = $db->selectRow($this->_table, "*", "id = " . $db->escapeString($this->_id))) {
			$this->_dbFields = $row;
			$this->_isLoaded = true;
		} else {
			$this->_id = null;
			$this->_isLoaded = false;
		}
	}

	public function load()
	{
		$this->reload();
		$this->_isLoaded = true;
	}

	public function forceLoaded()
	{
		$this->_isLoaded = true;
	}

	public function getI()
	{
		if (!$this->_isLoaded) {
			$this->load();
		}

		return $this->_id;
	}

	public function getClassName()
	{
		if (!$this->_className) {
			$this->_className = get_class($this);
		}

		return $this->_className;
	}

	public function getModifiedFields()
	{
		return $this->_modifiedFields;
	}

	public function initialise($table, $tableDefinition = null, $tupleID = null, $tupleValues = null)
	{
		$this->_table = $table;
		$this->_tableDefinition = $tableDefinition;
		$this->_id = $tupleID;

		if (is_array($tupleValues)) {
			$this->_dbFields = $tupleValues;
			$this->_isLoaded = true;
		}
	}

	public function destroy()
	{
		if ($this->_id) {
			$db = Database::getInstance();
			$db->delete($this->_table, "id = " . $db->escapeString($this->_id));
		}
	}

	public function save()
	{
		if ($this->_isModified) {
			$db = Database::getInstance();

			if (!$this->_id) {
				$this->_isLoaded = false;
			}

			foreach ($this->_modifiedFields as $field => $modified) {
				if ($modified) {
					 $data[$field] = $this->_dbFields[$field];
				}
			}

			if (!$this->_isLoaded) {
				if (in_array("created", $this->_tableDefinition)) {
					$data["created"] = "NOW()";
				}

				// insert new record
				$this->_id = $db->insert($this->_table, $data);
			} else {
				if (in_array("updated", $this->_tableDefinition)) {
					$data["updated"] = "NOW()";
				}

				// update existing record
				$db->update($this->_table, $data, "id = " . $db->escapeString($this->_id));
			}
		}
	}

	protected function getFieldKey($field)
	{
		return ($this->_tableDefinition == null) ? $field : $this->_tableDefinition[$field];
	}
}
