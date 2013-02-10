<?php

class Collection implements IteratorAggregate, Countable
{
	protected $_members = array();
	protected $_onLoad;
	protected $_isLoaded = false;

	public function count()
	{
		return $this->getItemCount();
	}
	
	public function addItem($obj, $key = null) 
	{
		$this->_checkCallback();
	
		if ($key) {
			if (isset($this->_members[$key])) {
				throw new KeyInUseException("Key '" . $key . "' already in use!");
			} else {
				$this->_members[$key] = $obj;
			}
		} else {
			$this->_members[] = $obj;
		}
		return $this;
	}
	
	public function removeItem($key)
	{
		$this->_checkCallback();
	
		if (isset($this->_members[$key])) {
			unset($this->_members[$key]);
		} else {
			throw new KeyInvalidException("Invalid key '" . $key . "'!");
		}
		return $this;
	}
	
	public function removeAllItems()
	{
		$this->_checkCallback();
	
		$this->_members = array();
		return $this;
	}
	
	public function getItem($key)
	{
		$this->_checkCallback();
	
		if (isset($this->_members[$key])) {
			return $this->_members[$key];
		} else {
			throw new KeyInvalidException("Invalid key '" . $key . "'!");
		}
	}
	
	public function getKeys()
	{
		$this->_checkCallback();
	
		return array_keys($this->_members);
	}

	public function isLoaded()
	{
		return $this->_isLoaded;
	}
	
	public function itemExists($key)
	{
		$this->_checkCallback();
	
		return isset($this->_members[$key]);
	}
	
	public function getItemCount()
	{
		$this->_checkCallback();
	
		return count($this->_members);
	}
	
	public function setLoadCallback($functionName, &$objOrClass = null)
	{
		if ($objOrClass) {
			$callback = array($objOrClass, $functionName);
		} else {
			$callback = $functionName;
		}
		
		if (!is_callable($callback, false, $callableName)) {
			throw new Exception("'" . $callableName . "' is not callable as a parameter to onload");
			return false;
		}
		
		$this->_onLoad = $callback;
		return $this;
	}
	
	public function getIterator()
	{
		$this->_checkCallback();

		return new ArrayIterator($this->_members);
	}
	
	protected function _checkCallback()
	{
		if (isset($this->_onLoad) && !$this->_isLoaded) {
			$this->_isLoaded = true;
			call_user_func($this->_onLoad, $this);
		}
	}
}