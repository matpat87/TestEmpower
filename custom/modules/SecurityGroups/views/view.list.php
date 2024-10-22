<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.list.php');

class SecurityGroupsViewList extends ViewList {
    function __construct()
    {
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $this->hideDeleteButton();
    }
    
    private function hideDeleteButton()
    {
        echo "<style>a#delete_listview_top.parent-dropdown-action-handler, a#delete_listview_bottom.parent-dropdown-action-handler {display: none !important;}</style>";
    }
}

