<?php

require_once 'include/MVC/View/views/view.list.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TR_TechnicalRequestsViewList extends ViewList
{
    public function preDisplay(){
        parent::preDisplay();
        $this->lv->actionsMenuExtraItems[] = $this->exportCSV();
    }

    function display()
    {
        parent::display();
        echo '<script type="text/javascript" src="custom/modules/TR_TechnicalRequests/js/list.js"></script>';
    }

    private function exportCSV(){
        global $mod_strings;
        return <<<EOF
        <a href='javascript:void(0)'
        onclick="return sListView.send_form(true, 'TR_TechnicalRequests', 'index.php?entryPoint=TR_TechnicalRequestsExportXLSRegistry','Please select at least 1 record to proceed.')">
{$mod_strings['LBL_EXPORT_XLS']}
        </a>
EOF;
    }
}