<?php

require_once 'include/MVC/View/views/view.detail.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SurveysViewDetail extends ViewDetail
{
	function display()
	{
        $this->ss->assign(
    "PREVIEW_SURVEY_BTN",
    "<a target='_blank' class='button' style='line-height: 25px;' href='/index.php?entryPoint=survey&id={$this->bean->id}&preview_mode=1'>Preview Survey</a>"
        );

		parent::display();
	}
}