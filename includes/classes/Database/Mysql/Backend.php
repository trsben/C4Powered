<?php

/* Routes Online, http://www.routesonline.com */
/* Copyright (c) Fluid Creativity, 2008. */

class Database_MySql_Backend extends Database_Backend
{
	const CLIENT_MULTI_STATEMENTS = 65536;

	private $connection;

	private $config;	

	public function __construct($dsn)
	{
		parent::__construct($dsn);
		$this->connect();
		
		$this->config = Configuration::getInstance();
		
		$this->query("SET NAMES 'utf8'");
	}
	
	public function connect()
	{		
		$this->connection = @mysql_connect($this->dsn->host, $this->dsn->username, $this->dsn->password, false, self::CLIENT_MULTI_STATEMENTS);
			
		if (!is_resource($this->connection)) {
			throw new Exception("The database abstraction layer was unable to connect to the MySQL server");
		}
		
		if (!mysql_select_db($this->dsn->schema, $this->connection)) {
			throw new Exception("The database abstraction layer was unable to select the MySQL database");
		}
	}
	
	public function isConnected()
	{
		return is_resource($this->connection);
	}
	

	public function __call($method, $params = null)
	{
		$method = $this->escapeStringNoQuotes($method);
		if (null != $params) {
			$method .= "(";
			foreach ($params as $value) {
				$method .= $this->escapeString($value) . ",";
			}
			$method = substr($method, 0, strlen($method) - 1);
			$method .= ")";
		}
		
		$result = $this->query("CALL {$method}");
	}

	public function __destruct()
	{
		if (is_resource($this->connection)) {
			@mysql_close($this->connection);
		}
		
		parent::__destruct();
	}
	
	public function query($query)
	{
		if (!$this->isConnected()) $this->connect();
		
		if ($result = @mysql_query($query, $this->connection)) {
			return $result;
		} else throw new Exception("MySQL Query Error" . ($this->config->debugmode->enabled == "true" ? mysql_error($this->connection) . "<br /><br />" . $query : "."));
	}

	public function getAffectedRows()
	{
		return @mysql_affected_rows($this->connection);
	}

	public function getInsertId()
	{
		return @mysql_insert_id($this->connection);
	}

	private function insertReplace($table, $values, $mode = "INSERT")
	{
		if ($table && $values) {
			$multipleRecords = (isset($value[0]) && is_array($values[0]));
			$columns = $multipleRecords ? array_keys($values[0]) : array_keys($values);
			$query	 = $mode . " INTO `" . $table . "` (`";
			$query  .= implode("`, `", $columns) . "`) VALUES ";
			
			if ($multipleRecords) {
				foreach ($multiValues as $values) {
					$inserts[] = "(" . implode(", ", $this->escapeStrings($values)) . ")";
				}
				$query .= implode(",", $inserts);
			} else {
				$query .= "(" . implode(", ", $this->escapeStrings($values, $this)) . ")";
			}
		} elseif ($table) {
			$query = $mode . " INTO `" . $table . "` VALUES ()";
		}
		
		if (isset($query) && $this->query($query)) {
			$var = ((isset($multipleRecords) && $multipleRecords) || $mode === "REPLACE") ? $this->getAffectedRows() : $this->getInsertId();
			
			return $var;
		}
	}

	public function insert($table, $values)
	{
		return $this->insertReplace($table, $values);
	}

	public function replace($table, $values)
	{
		return $this->insertReplace($table, $values, "REPLACE");
	}

	public function update($table, $values, $where = "false")
	{
		if ($table && $values) {
			$query = "UPDATE `" . $table . "` SET ";
			$query .= join(', ', $this->escapeStringsReturnSQL($values, $this));

			$query .= " WHERE " . $where;

			if ($this->query($query)) {
				return $this->getAffectedRows();
			}
		}
	}

	public function delete($table, $where = "false")
	{
		if ($table) {
			$query = "DELETE FROM `" . $table . "`";

			if ($where) $query .= " WHERE " . $where;

			if ($this->query($query)) {
				return $this->getAffectedRows();
			}
		}
	}

	public function select($table, $columns, $where = null, $order = null, $limit = null)
	{
		if ($table && $columns) {
			if (is_string($columns)) $columns = explode(", ", $columns);
			
			$query  = "SELECT " . implode(", ", $columns) . " FROM " . $table;
			
			if ($where) $query .= " WHERE " . $where;
			if ($order) $query .= " ORDER BY " . implode(", ", $order);
			if ($limit) $query .= " LIMIT " . $limit;
			
			if ($resource = $this->query($query)) {
				return $resource;
			}
		}
	}

	public function selectOne($table, $column, $where = null, $order = null)
	{
		if ($result = $this->select($table, $column, $where, $order, 1)) {
			$row = @mysql_fetch_row($result);
			@mysql_free_result($result);
			return $row[0];
		}
	}

	public function selectRow($table, $columns, $where = null, $order = null, $seek = null)
	{
		if ($result = $this->select($table, $columns, $where, $order)) {
			return $this->fetchRow($result, $seek);
		}
	}

	public function selectAll($table, $columns, $where = null, $order = null, $limit = null)
	{
		if ($result = $this->select($table, $columns, $where, $order, $limit)) {
			return $this->fetchAllRows($result);
		}
	}
	
	public function selectCol($table, $columns, $where = null, $order = null, $limit = null, $y = 0)
	{
		
		if (($result = $this->select($table, $columns, $where, $order, $limit)) && @mysql_num_fields($result) > $y){
			
			$rows = array();
			while ($row = @mysql_fetch_row($result)) {
				$rows[] = $row[$y];
			}
			@mysql_free_result($result);
			return $rows;
		}
	}
	
	public function selectPair($table, $columns, $where = null, $order = null, $limit = null)
	{
		if ($result = $this->select($table, $columns, $where, $order, $limit)) {			
			$colNum = @mysql_num_fields($result);
			$rows = array();
			
			if ($colNum == 1){
				while ($row = @mysql_fetch_assoc($result)) {
					$keys = array_keys($row);
					$rows[] = $row[$keys[0]];
				}
				return $rows;
			} elseif ($colNum == 2){
				while($row = @mysql_fetch_assoc($result)){
					$values = array_values($row);
					$rows[$values[0]] = $values[1];
				}
				return $rows;
			} elseif ($colNum > 2){
				
				while($row = @mysql_fetch_assoc($result)){
					$key = array_shift($row);
					if (!is_null($key)){
						$rows[$key] = $row;
					}
				}
				return $rows;
			} else{
				return $result->fetchAllRows();
			}		
		}
	}
	public function fetchRow($result, $seek = null)
	{
		if (is_resource($result)) {
			if ($seek) @mysql_data_seek($result, $seek);
			return @mysql_fetch_assoc($result);
		}
	}

	public function fetchAllRows($result)
	{
		if (is_resource($result)) {
			$rows = array();
			while ($row = @mysql_fetch_assoc($result)) {
				$rows[] = $row;
			}
			@mysql_free_result($result);
			return $rows;
		}
	}

	public function fetchRowCount($result) 
	{
		if (is_resource($result)) {
			return @mysql_num_rows($result);
		}
	}

	public function execute($query)
	{
		$args = func_get_args();

		if (is_array($args[1])) {
			$params = $args[1];
		} else {
			unset($args[0]);
			$params = $args;
		}

		$query = vsprintf($query, $params);

		if ($result = $this->query($query)) {
			return $result;
		}
	}

	public function escapeString($string)
	{
		if (!$this->isConnected()) $this->connect();
		
		if (strtoupper($string) !== "NOW()") {
			$string = "'" . mysql_real_escape_string($string, $this->connection) . "'";
		}
		return $string;
	}

	public function escapeStringForceQuotes($string)
	{
		if (!$this->isConnected()) $this->connect();
		
		if (!$string) {
			return "NULL";
		} elseif (strtoupper($string) !== "NOW()") {
			$string = "'" . mysql_real_escape_string($string, $this->connection) . "'";
		}
		return $string;
	}

	public function escapeStringNoQuotes($string)
	{
		return mysql_real_escape_string($string, $this->connection);
	}
	
}