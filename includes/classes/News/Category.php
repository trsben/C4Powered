<?php

class News_Category extends GenericObject
{
	protected $_tableName = "news_category";
	
	protected $_tableNonMultiDefinition = array(
		"id"             => "id",
		"sort"           => "sort",
		"created"        => "created",
		"updated"        => "updated",
		"display"        => "display",
		"title"       	 => "title",
		"description" 	 => "description"
	);

	public $articles;

	public function __construct($id = null)
	{
		$this->initialise($this->_tableName, $this->_tableNonMultiDefinition, $id);

		$this->articles = new News_Article_Collection($language);
		$this->articles->setLoadCallback("_loadArticles", $this);
	}

	public function destroy()
	{
		parent::destroy();

		if ($this->_id) {
			foreach ($this->articles as $article) {
				$article->destroy();
			}
		}
	}

	public function _loadArticles(Collection $col)
	{
		$this->articles->loadNewsFromCategory($this->_id);
	}
}

