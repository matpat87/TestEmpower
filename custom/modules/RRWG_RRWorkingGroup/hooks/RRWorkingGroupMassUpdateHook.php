<?php
    class RRWorkingGroupMassUpdateHook {
        public function handleMassUpdate(&$bean, $event, $arguments)
        {
            global $db;
            
            if ($_REQUEST['action'] == 'MassUpdate') {
                if (! empty($_REQUEST['record'])) {
                    // If Assigned To value is updated via Mass Update, update Parent Type and Parent ID to selected User
                    if (isset($_REQUEST['assigned_user_id']) && $_REQUEST['assigned_user_id']) {
                        $bean->parent_type = 'Users';
                        $bean->parent_id = $_REQUEST['assigned_user_id'];

                        // Custom codes to force new assignment email notification to not trigger
                        $_REQUEST['check_notify'] = false;
                    }
                }
            }
        }
    }

?>