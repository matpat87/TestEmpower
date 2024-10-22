<?php


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');


class CWG_CAPAWorkingGroupViewDetail extends ViewDetail
{

    function __construct(){
        parent::__construct();
    }

    function display()
    {
        global $log;
        $parentData = CapaWorkingGroupHelper::getParentData($this->bean->parent_type, $this->bean->parent_id);
        
        
        $this->bean->first_name_non_db = $parentData['first_name'];
        $this->bean->last_name_non_db = $parentData['last_name'];
        $this->bean->company_non_db = $parentData['company'];
        $this->bean->email_non_db = $parentData['email'];
        $this->bean->phone_work_non_db = $parentData['phone_work'];
        $this->bean->phone_mobile_non_db = $parentData['phone_mobile'];
        $this->bean->name = $parentData['first_name'] . " " . $parentData['last_name'];
        parent::display();

    
    }

    protected function render_js() 
    {
        $js = "
            <script></script>
        
        ";

        echo $js;
    }
}