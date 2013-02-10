<?php

class Page extends GenericObject
{
	protected $_tableName = "pages";
		
	protected $_tableNonMultiDefinition = array(
		"id"             => "id",
		"slug"			 => "slug",
		"display"        => "display",
		"created"        => "created",
		"updated"        => "updated",
		"title"     	 => "title",
		"strapline" 	 => "strapline",
		"text"   	 	 => "text"
	);
	
	private $db;

	public function __construct($id = null, $language = null)
	{
		$this->initialise($this->_tableName, $this->_tableNonMultiDefinition, $id);
		
		$this->db = Database::getInstance();
	}
	
	public static function getPageBySlug($slug)
	{
		$db = Database::getInstance();
		$row = $db->selectRow("pages", "*", "slug = " . $db->escapeString($slug));
		
		if ($row) {
			return new Page($row['id']);
		}
		else {
			return null;
		}
	}
}