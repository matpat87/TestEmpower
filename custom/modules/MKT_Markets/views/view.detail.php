<?php

require_once 'include/MVC/View/views/view.detail.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class MKT_MarketsViewDetail extends ViewDetail
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function display()
    {
        global $app_list_strings;
        
        $this->bean->industry_non_db = $app_list_strings['industry_dom'][$this->bean->name] ?? $this->bean->name;

        // This will be used to change the label at the header level
        // Ex. INDUSTRY: SAMPLE CONCENTRATE
        $this->bean->name = $app_list_strings['industry_dom'][$this->bean->name] ?? $this->bean->name;
        
        parent::display();
    }
}