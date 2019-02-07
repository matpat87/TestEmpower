<?php
	
class beforeSaveHook
{

	public function setAssignedUser($bean, $event, $arguments)
	{
		global $current_user;

    	// Set default "Assigned To" value to logged user when creating new record
    	if($bean->fetched_row == false) {
    		$bean->assigned_user_id = $current_user->id;
    	}
	}

}