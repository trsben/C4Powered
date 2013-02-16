<?php

class Page_Collection extends GenericObjectCollection
{
	protected $db;

	public function __construct()
	{
		$this->_tableName = "pages";
		$this->_className = "Page";
		$this->_itemsPerPage = 50;
		
		$this->db = Database::getInstance();
	}

	public function loadPages($displayOnly = true)
	{		
		$this->removeAllItems();
		$this->addItemsFromDatabase($this->_tableName, "id", $displayOnly ? "display = true" : null);
	}
}