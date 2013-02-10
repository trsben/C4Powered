<?php

class News_ArticleCollection extends GenericObjectCollection
{
	protected $db;

	public function __construct($language = null)
	{
		$this->_tableName = "news";
		$this->_className = "News_Article";
		$this->_itemsPerPage = 5;
		
		$this->db = Database::getInstance();
	}

	public function loadNews($displayOnly = true)
	{
		$this->removeAllItems();

		$this->addItemsFromDatabase($this->_tableName, "*", $displayOnly ? "display = true" : null, array("created DESC"), $this->_currentPage);
	}

	public function loadNewsFromCategory($categoryId, $displayOnly = true, $todayOnly = false)
	{		
		$this->removeAllItems();
		
		$where = "n.category_id = " . $this->db->escapeString($categoryId);
		
		if ($displayOnly) {
			$where .= " AND n.display = true";
		}
		
		if ($todayOnly) {
			$dateCutOff = date("Y:m:d H:i:s", strtotime("-24 hours"));
			$where .= " AND n.created >= '{$dateCutOff}'";
		}
				
		$this->addItemsFromDatabase($this->_tableName . " AS n", "n.*", $where, array("n.created DESC"), $this->_currentPage);
	}

	public function loadLatestNewsFromCategory($categoryId, $count = 5)
	{
		$this->removeAllItems();
		$this->setItemsPerPage((int)$count);

		$where = "c.id = " . $this->db->escapeString($categoryId);
		$where .= " AND n.display = true AND c.display = true ";

		$this->addItemsFromDatabase($this->_tableName . " AS n JOIN news_category AS c ON c.id = n.category_id", "n.id", $where, array("n.created DESC"), 1);
	}
}
