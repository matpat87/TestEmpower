<?php


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');
require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');


class TRWG_TRWorkingGroupViewEdit extends ViewEdit
{
    function __construct()
    {
        parent::__construct();
    }

    function display()
    {
        $parentData = TRWorkingGroupHelper::getParentData($this->bean->parent_type, $this->bean->parent_id);
        
        $this->bean->first_name_non_db = $parentData['first_name'];
        $this->bean->last_name_non_db = $parentData['last_name'];
        $this->bean->company_non_db = $parentData['company'];
        $this->bean->email_non_db = $parentData['email'];
        $this->bean->phone_work_non_db = $parentData['phone_work'];
        $this->bean->phone_mobile_non_db = $parentData['phone_mobile'];
        $this->bean->name = $parentData['first_name'] . " " . $parentData['last_name'];

        parent::display();

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/TRWG_TRWorkingGroup/js/custom-edit.js?v={$guid}'></script>";
    }
}