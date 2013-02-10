<?php

class News_Category_Collection extends GenericObjectCollection
{
	protected $db;

	public function __construct()
	{
		$this->_tableName = "news_category";
		$this->_className = "News_Category";
		$this->_itemsPerPage = 50;
		
		$this->db = Database::getInstance();
	}

	public function loadCategories($displayAll = true)
	{		
		$this->removeAllItems();
		$this->addItemsFromDatabase($this->_tableName, "id", "display = true", array("sort ASC"));
	}
}