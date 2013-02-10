<?php

class User_Collection extends GenericObjectCollection
{

	private static $namesByOrganisations = null;
	private $db;
	private $page;

	public function __construct($page = null, $itemsPerPage = null)
	{
		$this->_tableName = "user";
		$this->_className = "User";
		
		if (is_null($itemsPerPage) || (int) $itemsPerPage < 1) {
			$this->_itemsPerPage = 50;
		} else {
			$this->_itemsPerPage = (int) $itemsPerPage;
		}

		$this->db = Database::getInstance();
		$this->page = $page;
	}

	public function loadUsers($activatedOnly = false)
	{
		$this->removeAllItems();
		$this->addItemsFromDatabase($this->_tableName, "id", $activatedOnly ? "activated = 1" : null, array("id ASC"), $this->page);
	}

	public function searchUsers($keywords = null)
	{
		$this->removeAllItems();

		if ($keywords) {
			//work out keywords
			$association = "AND";
			$keywords = explode(" ", $keywords);
			$query = array();

			foreach ($keywords as $keyword) {
				$query[] = "(`firstname` LIKE '%" . $keyword . "%' OR `lastname` LIKE '%" . $keyword . "%')";
			}

			$query = implode(" " . $association . " ", $query);
		} else {
			$query = null;
		}

		$this->addItemsFromDatabase($this->_tableName, "id", $query, array("created DESC"), $this->page);
	}
}