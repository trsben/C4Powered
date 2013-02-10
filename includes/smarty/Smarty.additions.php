<?php

/* Routes Online, http://www.routesonline.com */
/* Copyright (c) Fluid Creativity, 2008. */

/* Smarty Additions */
/* Extend the smarty templating engine. */

/**
 * Allow us to have non-cached parts of templates
 */ 
function smarty_block_nocache($param, $content, &$smarty)
{
	return $content;
}

/**
 * Custom caching function
 */ 
function smarty_mysql_cache_handler($action, &$smarty_obj, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
{
	$db = Database::getInstance();
	
	$use_gzip = false;
	
	// create unique cache id
	$cacheID = md5($tpl_file . $cache_id . $compile_id);
	
	switch ($action) {
		case "read":
			// Read cache from database
			if ($contents = $db->selectOne("smarty_cache", "content", "id = " . $db->escapeString($cacheID))) {
				if ($use_gzip && function_exists("gzuncompress")) {
					$cache_content = gzuncompress($contents);
				}
				else {
					$cache_content = $contents;
				}
				
				$return = true;
			}
			else {
				$return = false;
			}
			break;

		case "write":
			// Save cache to database
			if ($use_gzip && function_exists("gzcompress")) {
				$contents = gzcompress($cache_content);
			}
			else {
				$contents = $cache_content;
			}

			$return = $db->replace("smarty_cache", array("id" => $cacheID, "content" => $contents));
			break;

		case "clear":
			// Clear cache info
			if (empty($cache_id) && empty($compile_id) && empty($tpl_file)) {
				// Clear them all
				$results = $db->delete("smarty_cache", "1 = 1");
			}
			else {
				$results = $db->delete("smarty_cache", "id = " . $db->escapeString($cacheID));
			}

			$return = $results;
			break;

		default:
			// Error, unknown action
			$smarty_obj->_trigger_error_msg("cache_handler: unknown action \"$action\"");
			$return = false;
			break;
	}
	
	return $return;
}

?>
