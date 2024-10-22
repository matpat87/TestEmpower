<?php
$entry_point_registry['QuickCRMgetConfig'] = array(
	'file' => 'custom/QuickCRM/getConfig.php',
	'auth' => false
);

$entry_point_registry['configquickcrm_save'] = array(
	'file' => 'custom/modules/Administration/configquickcrm_save.php',
	'auth' => true
);

$entry_point_registry['QCRMSAMLSession'] = array(
    'file' => 'custom/QuickCRM/SAMLSession.php',
    'auth' => true,
);

