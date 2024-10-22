<?php

require_once 'include/MVC/View/views/view.edit.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/Surveys/helpers/SurveysHelper.php');

class SurveysViewEdit extends ViewEdit
{
	function display()
	{

		global $log;

		$this->bean->survey_id_number_c = ((! isset($this->bean->id)) || (! $this->bean->survey_id_number_c) || $_REQUEST['isDuplicate'] == 'true') 
			? 'TBD' 
			: SurveysHelper::handleSurveyIdNumberAssignment($this->bean->id);

		parent::display();

		// Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
		echo "<script src='custom/modules/Surveys/js/custom-edit.js?v={$guid}'></script>";
	}
}