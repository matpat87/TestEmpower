<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class SecurityGroupsViewEdit extends ViewEdit {
    function __construct()
    {
        parent::__construct();
    }

    function display()
    {
        parent::display();

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
        $guid = create_guid();
        echo "<script src='custom/modules/SecurityGroups/js/edit.js?v={$guid}'></script>";
    }
}

