<?php

$adminPage = true;
require_once("../includes/bootstrap.php");

// Log user out and redirect to login page
$session->logout();
httpRedirect($config->baseurl_backend . "login.php");

// Exit script
exitScript();