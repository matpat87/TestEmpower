<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
ini_set('memory_limit', '-1');
chdir('../../..');

require_once 'SugarWebServiceImplv4_1_custom.php';

$webservice_path = 'service/core/SugarRestService.php';
$webservice_class = 'SugarRestService';
$webservice_impl_class = 'SugarWebServiceImplv4_1_custom';
$registry_path = 'custom/service/v4_1_custom/registry.php';
$registry_class = 'registry_v4_1_custom';
$location = 'custom/service/v4_1_custom/rest.php';

require_once 'service/core/webservice.php';