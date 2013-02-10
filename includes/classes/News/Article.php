<?php

class News_Article extends GenericObject
{
	protected $_tableName = "news";
		
	protected $_tableNonMultiDefinition = array(
		"id"             => "id",
		"categoryId"     => "category_id",
		"display"        => "display",
		"created"        => "created",
		"updated"        => "updated",
		"title"     	 => "title",
		"strapline" 	 => "strapline",
		"article"   	 => "article"
	);
	
	private $db;

	public function __construct($id = null, $language = null)
	{
		$this->initialise($this->_tableName, $this->_tableNonMultiDefinition, $id);
		
		$this->db = Database::getInstance();
	}

	public function destroy()
	{
		parent::destroy();
	}

	public function getCategory()
	{
		if ($this->categoryId > 0) {
			return new News_Category($this->categoryId);
		}
		
		return null;
	}

	public function save()
	{
		parent::save();

		return $this;
	}
}