<?php
require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class TemplateCstmfile extends TemplateField{
	var $type='Cstmfile';
	
	public $inline_edit = 0;
	
	function get_field_def(){
		$def = parent::get_field_def();
		$def['dbType'] = 'varchar';
		//$def['source'] = 'custom_field';
		//$def['studio'] = array('listview'=>false,'searchview'=>false,'editview'=>true,'detailview'=>true,);
		$def['studio'] = 'visible';
		return $def;
	}

	function save($df) {
		parent::save($df);
	}

}