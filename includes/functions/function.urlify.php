<?php

function smarty_function_urlify($params, $smarty)
{
	return urlify($params['var']);
}