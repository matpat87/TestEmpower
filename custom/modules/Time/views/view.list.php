<?php

require_once('include/MVC/View/views/view.list.php');

class TimeViewList extends ViewList
{
    function TimeViewList()
    {
        parent::__construct();
 	}

    public function preDisplay()
    {
        parent::preDisplay();
        $this->lv->actionsMenuExtraItems[] = $this->handleDisplayExportCSVButton();
    }

    public function display()
    {
        parent::display();   
    }

    private function handleDisplayExportCSVButton()
    {
        global $mod_strings;
        
        return "
            <a  href='javascript:void(0)'
                onclick=\"
                    return sListView.send_form(true, 'Time', 'index.php?entryPoint=TimeExportCSV','Please select at least 1 record to proceed.')
                \">{$mod_strings['LBL_EXPORT_XLS']}
            </a>
        ";
    }
}

