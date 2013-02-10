<?php

require_once(Configuration::getInstance()->includes . "smarty/Smarty.class.php");
require_once(Configuration::getInstance()->includes . "smarty/Smarty.additions.php");

class SmartSmarty extends Smarty
{
	public function display($template, $cache_id = NULL, $compile_id = NULL)
	{
		if (Configuration::getInstance()->validmimetype->enabled == "true") {
			$this->correctMime();
		}
		
		parent::display($template);
	}
	
	private function correctMime()
	{
		header("Vary: Accept");

		if ((isset($_SERVER['HTTP_ACCEPT']) && stristr($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml")) || (isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER["HTTP_USER_AGENT"],"W3C_Validator"))) {
			
			if (preg_match("/application\/xhtml\+xml;q=0(\.[1-9]+)/i", $_SERVER["HTTP_ACCEPT"], $matches)) $xhtmlQ = $matches[1];
			if (preg_match("/text\/html;q=0(\.[1-9]+)/i", $_SERVER["HTTP_ACCEPT"], $matches)) $htmlQ = $matches[1];
				
			if (isset($xhtmlQ) && isset($htmlQ) && $htmlQ < $xhtmlQ) {
				header("Content-type: text/html");
			} else {
				header("Content-type: application/xhtml+xml");
			}
		} else {
			header("Content-type: text/html");
		}
	}
}

class SmartySingleton
{
	public static function getInstance()
	{
		static $instance;
		
		if (!is_object($instance)) {
			$instance = new SmartSmarty();
			
			$instance->caching = false;
			//$instance->compile_check = false;
			$instance->register_block("nocache", "smarty_block_nocache", false);
			//$instance->cache_handler_func = "smarty_mysql_cache_handler";
			
			if (Configuration::getInstance()->debugmode->enabled == "true") {
				$instance->force_compile = true;
			}
		}
		
		return $instance;
	}
}