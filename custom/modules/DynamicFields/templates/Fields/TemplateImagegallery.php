<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('modules/DynamicFields/templates/Fields/TemplateField.php');

class TemplateImagegallery extends TemplateField {
    
	var $type = 'imagegallery';
    function get_field_def(){
        $def = parent::get_field_def();
		$def['inline_edit'] = 0;
        $def['dbType'] = 'text';
        return $def;
    }
}
?>