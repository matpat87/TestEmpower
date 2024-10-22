<?php

require_once 'include/MVC/View/views/view.edit.php';
require_once('custom/modules/SO_SavingOpportunities/helpers/SavingOpportunitiesHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SO_SavingOpportunitiesViewEdit extends ViewEdit
{
    public function preDisplay()
    {
        parent::preDisplay();
    }

    public function display()
    {
        $this->bean->so_id = (! isset($this->bean->id)) ? 'TBD' : SavingOpportunitiesHelper::assign_opportunity_id($this->bean->id);
        $this->bean->amount = NumberHelper::GetCurrencyValue($this->bean->amount);
        $this->bean->annual_spend = NumberHelper::GetCurrencyValue($this->bean->annual_spend);
        
        parent::display();
        $this->_js_defaults();
        echo getVersionedScript('custom/modules/SO_SavingOpportunities/js/edit.js');
    }

    private function _js_defaults()
	{
        global $app_list_strings, $sugar_config;
        
		$sales_stage_str = '[';

		foreach($app_list_strings['sales_stage_dom'] as $sales_stage_key => $sales_stage_val)
		{
			$sales_stage_str .= "['$sales_stage_key','$sales_stage_val'], " ;
		}

		// echo strlen($sales_stage_str);
		if(strlen($sales_stage_str) > 2)
		{
			// echo 'yeaahh';
			$sales_stage_str = substr($sales_stage_str, 0, strlen($sales_stage_str) - 2);
		}

		$sales_stage_str .= ']';

		$js_str = "<script type='text/javascript'>
	
		$(document).ready(function(e){

			InitializeSalesStage(false);

		});</script>";

		echo $js_str;
	}
}