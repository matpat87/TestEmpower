<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Opportunities/views/view.list.php';

class CustomOpportunitiesViewList extends OpportunitiesViewList
{
    function display()
    {
        parent::display();
        echo "<script src='custom/modules/Opportunities/js/custom-filter.js'></script>";
    }

    //OnTrack #1269
    public function preDisplay(){
        parent::preDisplay();
        $this->lv->actionsMenuExtraItems[] = $this->exportCSV();
    }

    private function exportCSV(){
        global $mod_strings;
        return <<<EOF
        <a href='javascript:void(0)'
        onclick="return sListView.send_form(true, 'Opportunities', 'index.php?entryPoint=OppExpCSVEntryPoint','Please select at least 1 record to proceed.')">
{$mod_strings['LBL_EXPORT_XLS']}
        </a>
EOF;
    }
}