<?php

	class BeforeSaveHook {
		public function logProjectUpdates($bean, $event, $arguments)
		{
            global $current_user;
            
            $newUpdates = $bean->project_update_c;
            
            if($newUpdates) {
                $newLogUpdate = 'Updated By: ' . $current_user->first_name . ' ' . $current_user->last_name . ' on ' . $bean->date_modified . "\n" . $newUpdates;

                $previousLogUpdates = $bean->fetched_row['updates_c'];
                
                if(!empty($previousLogUpdates)) {
                    $bean->updates_c = $newLogUpdate . "\n\n" . $previousLogUpdates;
                } else {
                    $bean->updates_c = $newLogUpdate;
                }

            }
            
		}
	}
?>