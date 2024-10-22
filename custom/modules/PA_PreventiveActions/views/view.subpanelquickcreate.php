<?php

require_once('include/EditView/SubpanelQuickCreate.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class PA_PreventiveActionsSubpanelQuickCreate extends SubpanelQuickCreate
{
    function PA_PreventiveActionsSubpanelQuickCreate()
    {
        global $log;
        
        if ($_REQUEST['parent_type'] == 'Cases') {
            $customerIssue = BeanFactory::getBean('Cases', $_REQUEST['parent_id']);
           echo "<script>
           var siteVal = '{$customerIssue->site_c}';
            $(document).ready(function(){
                $('select#site_c').val(siteVal);
            });
           </script>";

        }
       
        parent::SubpanelQuickCreate("PA_PreventiveActions");
    }
}