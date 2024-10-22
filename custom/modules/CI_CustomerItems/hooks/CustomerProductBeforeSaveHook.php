<?php
	
class CustomerProductBeforeSaveHook
{

	public function setAssignedUser($bean, $event, $arguments)
	{
		global $current_user;

    	// Set default "Assigned To" value to logged user when creating new record
    	if($bean->fetched_row == false) {
    		$bean->assigned_user_id = $current_user->id;
    	}
	}

	function handleIndustryDbValues(&$bean, $event, $arguments)
    {
        global $log, $app_list_strings, $db;

        // Retrieve Industry Row with id $bean->industry_c
        $industryQuery = $db->query("
                SELECT * from mkt_markets WHERE id = '{$bean->industry_c}'
            ");
        
        while ($row = $db->fetchByAssoc($industryQuery)) {

            // Set the $bean->sub_industry_c = $industryBean->id -- to inline data saved from prev implementation
            $bean->sub_industry_c = $row['id'];
            // Set the $bean->industry = with value from $app_list_strings['industry_dom][$industryBean->name]
            $bean->industry_c = $row['name'];
        }
        
    }
}