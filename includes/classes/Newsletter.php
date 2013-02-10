<?php

class Newsletter extends GenericObject
{
	protected $_tableName = "newsletter";
		
	protected $_tableNonMultiDefinition = array(
		"id"        => "id",
		"email"     => "email",
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
}