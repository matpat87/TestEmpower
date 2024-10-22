<?php

class LeadsBeforeSaveHook
{
    /**
     * Overrides the core/default behavior of Leads save() function
     * Sets a $_REQUEST['check_notify'] to trigger core Lead Email Notification on save
     * Ontrack #1623 Fix: trigger only when assigned User is updated
     */
    public function customCheckNotify(&$bean, $event, $arguments)
    {   
        global $log;
        
        $_REQUEST['check_notify'] = false; // Used in SugarBean class save function: sets the value to this if it exists
        
        if ($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id && !empty($bean->assigned_user_id)) {
            $_REQUEST['check_notify'] = true;
        }
    }

}