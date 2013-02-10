<?php

function smarty_function_timestamp2date($params, $smarty)
{
	if (!isset($params['timestamp'])) {
		$smarty->trigger_error("timestamp2date: missing 'timestamp' parameter");
	}
	
	if (!isset($params['format'])) {
		$smarty->trigger_error("timestamp2date: missing 'format' parameter");
	}
	
	return timestamp2date($params['timestamp'],$params['format']);
}