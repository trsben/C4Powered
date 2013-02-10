<?php

abstract class Database_Backend
{
	protected $dsn;

	protected $queries = array();
	
	public function __construct($dsn)
	{
		$this->dsn = $dsn;
	}

	public function __destruct()
	{
		global $oSession;
		if (is_object($oSession)) {
			unset($oSession);
		}
	}
	
	abstract public function getAffectedRows();
	abstract public function getInsertId();
	abstract public function query($query);
	abstract public function insert($table, $values);
	abstract public function replace($table, $values);
	abstract public function update($table, $values, $where = "false");
	abstract public function delete($table, $where = "false");
	abstract public function select($table, $columns, $where = null, $order = null, $limit = null);
	abstract public function selectOne($table, $column, $where = null, $order = null);
	abstract public function selectRow($table, $columns, $where = null, $order = null, $seek = null);
	abstract public function selectAll($table, $columns, $where = null, $order = null, $limit = null);
	abstract public function fetchRow($result, $seek = null);
	abstract public function fetchAllRows($result);
	abstract public function fetchRowCount($result);
	abstract public function execute($query);

	public function escapeStrings($values, $caller)
	{
		$escValues = array();
		
		foreach ($values AS $key => $var) {
			$var = $caller->escapeString($var);
			$escValues[$key] = $var;
		}

		return $escValues;
	}


	public function escapeStringsForceQuotes($values, $caller)
	{
		$escValues = array();

		foreach ($values AS $key => $var) {
			$var = $caller->escapeStringForceQuotes($var);
			$escValues[$key] = $var;
		}
		
		return $escValues;
	}


	public function escapeStringsReturnSQL($values, $caller)
	{
		$escValues = array();

		$values = self::escapeStrings($values, $caller);

		foreach ($values AS $key => $var) {
			$escValues[] = $key . " = " . $var;
		}

		return $escValues;
	}
	
	
	public function getQueries()
	{
		return $this->queries;
	}
	
	public function dumpLastQuery()
	{
		$lastQuery = end($this->queries);
		var_dump($lastQuery);
		
		return;
	}
}