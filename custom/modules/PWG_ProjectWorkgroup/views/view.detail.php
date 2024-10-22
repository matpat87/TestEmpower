<?php

require_once 'include/MVC/View/views/view.detail.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class PWG_ProjectWorkgroupViewDetail extends ViewDetail
{
    function display()
    {
        global $app_list_strings;


        if ($this->bean->parent_type == 'Project') {
            $this->bean->parent_name = "Project - {$this->bean->parent_name}";
        }
        
        if ($this->bean->parent_type == 'PWG_ProjectWorkgroup') {
            $this->bean->parent_name = "Workgroup - {$this->bean->parent_name}";

        }

        parent::display();
    }

    
}