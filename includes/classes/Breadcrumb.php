<?php

class Breadcrumb {
	private $crumbs = array(
		'' => 'Home'
	);
	
	public function addCrumb($title, $url)
	{
		$this->crumbs = array_merge($this->crumbs, array($url => $title));
	}
	
	public function addCrumbs(array $crumbs) {
		$this->crumbs = array_merge($this->crumbs, $crumbs);
	}
	
	public function getCrumbs()
	{
		return $this->crumbs;
	}
}