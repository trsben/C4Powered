<?php

require_once("includes/bootstrap.php");

$smarty->assign('pageClass', 'holding-page');

// Display the page template
$smarty->display('index.tpl');
exitScript();