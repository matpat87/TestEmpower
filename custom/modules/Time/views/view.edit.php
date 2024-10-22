<?php

require_once 'include/MVC/View/views/view.edit.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TimeViewEdit extends ViewEdit
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function display()
    {
        global $app_list_strings;

        if ($this->bean->parent_id && $this->bean->parent_type == 'TRI_TechnicalRequestItems') {
            $this->bean->parent_name = $app_list_strings['distro_item_list'][$this->bean->parent_name];
        }

        parent::display();
    }
}