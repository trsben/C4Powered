<?php

class Request
{
	private static $instance;

	private $_getVars;
	private $_postVars;
	private $_cookieVars;
	private $_requestVars;

	public function __construct()
	{
		$this->_getVars     = &$_GET;
		$this->_postVars    = &$_POST;
		$this->_cookieVars  = &$_COOKIE;
		$this->_requestVars = &$_REQUEST;
	}

	public static function getInstance()
	{
		if (!is_object(self::$instance)) {
			self::$instance = new Request();
		}

		return self::$instance;
	}
	
	public function getParameterValue($param)
	{
		return isset($this->_requestVars[$param]) ? $this->_requestVars[$param] : "";
	}

	public function getParameters()
	{
		return $this->_requestVars;
	}

	public function getCookies()
	{
		return $this->_cookieVars;
	}

	public function getPostVariables()
	{
		return $this->_postVars;
	}

	public function getGetVariables()
	{
		return $this->_getVars;
	}

	public function isPost()
	{
		return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
	}

	public function setParameterValue($param, $value) {
		$this->_requestVars[$param] = $value;
	}
}