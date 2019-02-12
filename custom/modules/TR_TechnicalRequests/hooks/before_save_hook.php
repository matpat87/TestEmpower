<?php

	class BeforeSaveHook {
		public function logTechnicalRequestUpdates($bean, $event, $arguments)
		{
            global $current_user;

            $newUpdates = $bean->technical_request_update;
            
            if($newUpdates) {
                $newLogUpdate = 'Updated By: ' . $current_user->first_name . ' ' . $current_user->last_name . ' on ' . $bean->date_modified . "\n" . $newUpdates;

                $previousLogUpdates = $bean->fetched_row['updates'];
                
                if(!empty($previousLogUpdates)) {
                    $bean->updates = $previousLogUpdates . "\n" . $newLogUpdate;
                } else {
                    $bean->updates = $newLogUpdate;
                }

                $bean->technical_request_update = '';
            }
            
		}
	}
?>