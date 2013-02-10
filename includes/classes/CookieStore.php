<?php

final class CookieStore
{
	public static function exists($name)
	{
		return isset($_COOKIE[$name]);
	}
	
	public static function get($name, $default = null)
	{
		if (self::exists($name)) {
			return $_COOKIE[$name];
		} else {
			return $default;
		}
	}
	
	public static function clear($name)
	{
		setcookie($name, false, time() - 3600);
		unset($_COOKIE[$name]);
	}
	
	public static function set($name, $value, $duration = 7)
	{
		setcookie($name, $value, time() + 60*60*24* $duration, "/", $_SERVER['HTTP_HOST']);
	}
}

?>