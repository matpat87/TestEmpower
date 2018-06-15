<?php

require_once('include/MVC/View/views/view.list.php');
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
require_once("modules/asol_Process/___common_WFM/php/checkConfigurationDefsFunctions.php");

class asol_OnHoldViewList extends ViewList
{
	function asol_OnHoldViewList()
	{
		parent::ViewList();
	}
	function Display()
	{
		if (wfm_utils::isCommonBaseInstalled()) {
			wfm_utils::initWFMFunctions();
			
			$this->lv->quickViewLinks = false;
			$this->lv->export = false;
			$this->lv->showMassupdateFields = false;
			parent::Display();
		} else {
			echo asol_CheckConfigurationDefsFunctions::checkModuleDependence('AlineaSolCommonBase', wfm_utils::$common_version, true);
		}		
	}
}
?>