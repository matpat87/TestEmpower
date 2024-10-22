<?php

use Carbon\Carbon;

class PA_PreventiveActionsRelationshipHooks
{

    public function handleActivityRemoveParent(&$bean, $event, $arguments)
    {
        global $log, $db;

        $activityModules = [
            array(
                'module' => 'Meetings',
                'link_name' => 'pa_preventiveactions_meetings_1',
                'db_table' => 'meetings'
            ), 
            array(
                'module' => 'Calls',
                'link_name' => 'pa_preventiveactions_calls_1',
                'db_table' => 'calls'
            )
        ];
        
        if ($_REQUEST['module'] == 'PA_PreventiveActions' && $_REQUEST['action'] == 'DeleteRelationship' && in_array($_REQUEST['linked_field'], array_column($activityModules, 'link_name'))) {
            // Remove the Parent ID by using sql UPDATE only to avoid triggering other hooks
    
            $module = array_merge([], array_filter($activityModules, function($val, $key) {
                return $val['link_name'] == $_REQUEST['linked_field'];
            }, ARRAY_FILTER_USE_BOTH));

            $updateSQL = "UPDATE {$module[0]['db_table']} SET parent_id = NULL WHERE id = '{$_REQUEST['linked_id']}'";
            $db->query($updateSQL);
                    
        } // end of if

    }

   
}

?>