<?php

include_once("Zend/Config.php");
include_once("Zend/Config/Xml.php");
include_once("Zend/Exception.php");

class Configuration
{
	private static $instance; 

	public static function create($configPath, $configFiles, $configMode = "production")
	{
		if (!is_object(self::$instance)) {
			if (!is_array($configFiles)) $configFiles = array($configFiles);

			foreach ($configFiles as $configFile) {
				if (file_exists($configPath . $configFile)) {
					$configLocations[] = realpath($configPath . $configFile);
				}
			}

			self::$instance = new Zend_Config_Xml(array_shift($configLocations), $configMode, true);

			foreach ($configLocations as $configFile) {
				self::$instance = self::$instance->merge(new Zend_Config_Xml($configFile, $configMode));
			}
		}
		
		return self::$instance;
	}

	public static function getInstance()
	{
		return self::$instance;
	}
}