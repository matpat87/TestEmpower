<?php


class VendorIssuesBeforeSaveHook 
{

    function check_project_number(&$bean, $event, $arguments) 
    {
        global $current_user, $log, $db;
        
        if (! $bean->fetched_row['id']) {
            // Retrieve or increment lates project number
            $db = DBManagerFactory::getInstance();

            $sql= "SELECT vi_vendorissues_number FROM vi_vendorissues WHERE deleted = 0 ORDER BY date_entered DESC LIMIT 1";
            $result = $db->query($sql);
            $row = $db->fetchByAssoc($result);
            $bean->vi_vendorissues_number = $row['vi_vendorissues_number'] + 1;
        
        }
        
    }
    
  
}

?>