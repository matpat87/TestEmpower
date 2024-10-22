<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);


/**
 * This is a rest entry point for rest version Sugar 6.5 +
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Allow-Credentials: true");

@ini_set('display_errors', '0');

require_once('../../service/quickcrm/rest.php');
