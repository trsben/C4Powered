<?php

include_once("classes/Configuration.php");

function autoload($className)
{
	$classFile = explode('_', $className);
	$classFile = functionDeep('ucfirst', $classFile);
	$classFile = Configuration::getInstance()->includes . 'classes/' . implode('/', $classFile) . '.php';
		
	if (!class_exists($className, false)) {
		if (file_exists($classFile)) {
			require_once($classFile);
		} else {
			throw new Exception("Cannot locate " . $classFile . " class.");
			return;
		}
	}
}

spl_autoload_register("autoload");

/**
 * Turns a MySQL timestamp into a formatted date.
 * 
 * @param string $timestamp The timestamp from MySQL
 * @param string $format Format used by php.net/date
 */
function timestamp2date($timestamp,$format) {
	$unixTimestamp = strtotime($timestamp);
	$returnValue = date($format, $unixTimestamp);
	return $returnValue;
}

/**
 * Note: string index might be lost if input is an array
 * @param $func - function name
 * @param $input - mix value 
 * @return mix
 */
function functionDeep($func, $input)
{
	return is_array($input) ? array_map('functionDeep', array_fill(0, count($input), $func), $input) : $func($input);
}

// exit function
function exitScript()
{
	session_write_close();
	exit(0);
}

function httpRedirect($url, $isPermanent = false)
{
	if ($isPermanent) {
		header("HTTP/1.1 301 Moved Permanently");
	}
	header("Location: " . $url);
	exitScript();
}

// convert a string to a URL friendly version
function urlify($url)
{
	// replace spaces with hyphens
	$url = str_replace(" ", "-", $url);

	// remove accents
	$url = htmlentities($url);
	$url = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', $url);

	// convert to lowercase
	$url = strtolower($url);
	
	// remove any non-alphanumeric characters except for hyphens
	$url = preg_replace("/[^a-z0-9-]/", "", $url);

	// remove any strings of hyphens
	$url = preg_replace("/[-]+/", "-", $url);

	return $url;
}

function checkEmailAddress($emailaddress)
{
	return preg_match("/^([_a-z0-9-]+)([.'_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/i", $emailaddress);
}

function checkPhoneNumber($telephone)
{
	return preg_match("/[0-9()+ -]+/u", $telephone);
}

function checkUsername($username)
{
	return preg_match("/[0-9a-z]{6,}/i", $username);
}

function generateSalt()
{
	return substr(md5(uniqid(mt_rand(), true)), 0, 5);
}

function datediff($compareDate, $currentDate = null)
{
	if (null == $currentDate) {
		$currentDate = strtotime(date('Y-m-d H:i:s'));
	}

	$compareDate = strtotime($compareDate);

	$diff = date_difference($currentDate, $compareDate);
	return format_difference($diff);
}

function date_difference($d1, $d2) {
	/* compares two timestamps and returns array with differencies (year, month, day, hour, minute, second)
	*/
	//check higher timestamp and switch if neccessary
	if ($d1 < $d2) {
		$temp = $d2;
		$d2 = $d1;
		$d1 = $temp;
	}
	else {
		$temp = $d1; //temp can be used for day count if required
	}

	$d1 = date_parse(date("Y-m-d H:i:s",$d1));
	$d2 = date_parse(date("Y-m-d H:i:s",$d2));

	//seconds
	if ($d1['second'] >= $d2['second']){
		$diff['second'] = $d1['second'] - $d2['second'];
	}
	else {
		$d1['minute']--;
		$diff['second'] = 60-$d2['second']+$d1['second'];
	}

	//minutes
	if ($d1['minute'] >= $d2['minute']){
		$diff['minute'] = $d1['minute'] - $d2['minute'];
	}
	else {
		$d1['hour']--;
		$diff['minute'] = 60-$d2['minute']+$d1['minute'];
	}

	//hours
	if ($d1['hour'] >= $d2['hour']){
		$diff['hour'] = $d1['hour'] - $d2['hour'];
	}
	else {
		$d1['day']--;
		$diff['hour'] = 24-$d2['hour']+$d1['hour'];
	}
	//days
	if ($d1['day'] >= $d2['day']){
		$diff['day'] = $d1['day'] - $d2['day'];
	}
	else {
		$d1['month']--;
		$diff['day'] = date("t",$temp)-$d2['day']+$d1['day'];
	}

	//months
	if ($d1['month'] >= $d2['month']){
		$diff['month'] = $d1['month'] - $d2['month'];
	}
	else {
		$d1['year']--;
		$diff['month'] = 12-$d2['month']+$d1['month'];
	}

	//years
	$diff['year'] = $d1['year'] - $d2['year'];
	return $diff;
}

function format_difference($difference)
{
	$count = 0;
	$formatted = '';
	$parts = array (
		'year',
		'month',
		'day',
		'hour',
		'minute',
		'second'
	);

	foreach ($parts as $part) {
		if ($difference[$part] > 0) {
			$formatted .= " " . $difference[$part] . " " . $part . (($difference[$part] > 1)?'s':'');
			$count++;
		}

		if ($count > 1) {
			break;
		}
	}

	$formatted = ((!empty($formatted))?$formatted:"1 second") . " ago";
	return trim($formatted);
}