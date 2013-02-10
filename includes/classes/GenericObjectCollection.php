<?php

class GenericObjectCollection extends Collection
{
	protected $_tableName;
	protected $_className;
	protected $_itemsPerPage = 10;
	protected $_currentPage = null;
	protected $_totalCount = null;
	protected $_totalQuery = null;
	
	public function addItemFromID($id, $key = null, $values = null)
	{
		$this->_checkCallback();
		
		if ($key) {
			if (isset($this->_members[$key])) {
				throw new KeyInUseException("Key '" . $key . "' already in use!");
			} else {
				$this->_members[$key] = new $this->_className($id, $values);
			}
		} else {
			$this->_members[] = new $this->_className($id, $values);
		}
	}

	public function addItemsFromIDs($ids, $fieldName = "id")
	{
		$this->_checkCallback();
		
		if (is_array($ids) && count($ids) > 0) {
			$valuesPassed = is_array($ids[0]);
			
			foreach ($ids as $key => $id) {
				if ($valuesPassed) {
					if (!empty($id[$fieldName])) {
						$this->_members[] = new $this->_className($id[$fieldName], $id);
					}
				} else {
					$this->_members[] = new $this->_className($id);
				}
			}
		}
	}

	public function addItemsFromDatabase($table, $columns, $where = null, $order = null, $page = null)
	{
		$this->_checkCallback();
		
		$db = Database::getInstance();
		
		$limit = null;
		
		if ($page) {
			if (stripos($where, "group by")) {
				$subQuery = "SELECT 0 FROM " . $table . ($where ? " WHERE " . $where : "");
				$this->_totalQuery = array (
					'table' => "(" . $subQuery . ") AS sub",
					'values' => "COUNT(0)",
					'where' => null
				);
			} else {
				$this->_totalQuery = array (
					'table' => $table,
					'values' => "COUNT(0)",
					'where' => $where
				);
			}
			
			$limit = (($page - 1) * $this->_itemsPerPage) . ", " . $this->_itemsPerPage;
		} else {
			$this->_totalCount = 0;
		}
		
		$this->addItemsFromIDs($db->selectAll($table, $columns, $where, $order, $limit));
	}

	public function setCurrentPage($page, $itemsPerPage = null)
	{
		$this->_currentPage = $page;
		if ($itemsPerPage) $this->_itemsPerPage = $itemsPerPage;
	}
	
	public function setItemsPerPage($itemsPerPage)
	{
		$this->_itemsPerPage = $itemsPerPage;
	}

	public function getTotalCount()
	{
		$this->_checkCallback();

		if (null == $this->_totalCount && null != $this->_totalQuery) {
			// load total count here
			$db = Database::getInstance();
			$this->_totalCount = $db->selectOne($this->_totalQuery['table'], $this->_totalQuery['values'], $this->_totalQuery['where']);
		}

		return $this->_totalCount > 0 ? $this->_totalCount : $this->getItemCount();
	}

	public function getPageCount()
	{
		$this->_checkCallback();
	
		return ceil($this->getTotalCount() / $this->_itemsPerPage);
	}
}