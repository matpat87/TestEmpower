<?php

global $theme;

$manifest = array(
    'acceptable_sugar_flavors' => array (),
    'name' => 'AlineaSol Publish Homepage - Community Edition',
	'remove_tables' => 'prompt',
    'description' => 'Enhances the homepage of SugarCRM CE, supporting mult-tab dashboards, and role specific home pages.',
    'author' => 'AlineaSol',
    'published_date' => '2016-11-30',
    'version' => '4.5',
    'type' => 'module',
	'is_uninstallable' => true,
);


$installdefs = array(

    'id'=> 'AlineaSolPublishHomePage',
	
	'copy' => array(
	
		0 =>
		array(
			'from'=> '<basepath>/modules/',
			'to'=> 'modules/',
		),
		1 =>
		array(
			'from'=> '<basepath>/custom/',
			'to'=> 'custom/',
		),
		
	),
	'language'=> array(
		array(
            'from' => '<basepath>/language/en_us.home.php' ,
            'to_module' => 'Home' ,
            'language' => 'en_us'
        ) ,
		array(
            'from' => '<basepath>/language/sp_ve.home.php' ,
            'to_module' => 'Home' ,
            'language' => 'sp_ve'
        ) ,
        array(
            'from' => '<basepath>/language/es_es.home.php' ,
            'to_module' => 'Home' ,
            'language' => 'es_es'
        ) ,
	),
	'pre_execute'=>array(
		0 => '<basepath>/actions/pre_install.php',
	),
	'post_execute'=>array(
		0 => '<basepath>/actions/post_install.php',
	),
	'pre_uninstall'=>array(
		0 => '<basepath>/actions/pre_uninstall.php'
	),
	'post_uninstall'=>array(
		0 => '<basepath>/actions/post_uninstall.php',
	),

);
?>