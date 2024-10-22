<?php

require_once 'include/MVC/View/views/view.edit.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class MKT_MarketsViewEdit extends ViewEdit
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function display()
    {
        global $app_list_strings, $log;

        $industryName = $app_list_strings['industry_dom'][$this->bean->name];

        $dom = "<select id='name' name='name'>";
            foreach ($app_list_strings['industry_dom'] as $key => $value) {
                $selected = $this->bean->name == $key 
                    ? "selected='selected'" 
                    : '';
                    
                $dom .= "<option label='{$value}' value='{$key}' {$selected}>{$value}</option>";
            }
        $dom .= "</select>";
        
        $this->ss->assign('INDUSTRY_NAME', $dom);
        
        // Add after assigning to TR_ITEM since this will be used to change the label at the header level
        // Ex. TECHNICAL REQUEST ITEMS: SAMPLE CONCENTRATE >> EDIT
        $this->bean->name = $industryName;
        parent::display();
    }
}