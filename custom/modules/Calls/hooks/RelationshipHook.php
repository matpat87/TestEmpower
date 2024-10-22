<?php

class MeetingsRelationshipHooks
{
    public function handleAddParent(&$bean, $event, $arguments)
    {
        global $log, $db;
    
        
        if ($_REQUEST['return_module'] == 'PA_PreventiveActions' && $_REQUEST['module'] == 'PA_PreventiveActions' && $bean->parent_id != $_REQUEST['record']) {
            $log->fatal(print_r($_REQUEST, true));

           $updateSQL = "UPDATE calls SET parent_type = 'PA_PreventiveActions', parent_id = '{$_REQUEST['record']}' WHERE id = '{$bean->id}'";
           $db->query($updateSQL);
        }
        
       
    }
   
}

?>