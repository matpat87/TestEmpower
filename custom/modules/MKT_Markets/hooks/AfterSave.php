<?php


class MKT_MarketsAfterSaveHook 
{
    // On market after save, updates the NAME column with the Industry Value
    public function saveNameWithIndustryValue(&$bean, $event, $arguments)
    {
        global $db, $log, $app_list_strings;

        // $log->fatal(print_r($bean->industry, true));
        if ($bean->fetched_row['industry'] != $bean->industry) {
            $updateSql = "UPDATE mkt_markets SET name = '{$app_list_strings['industry_dom'][$bean->industry]}' WHERE id = '{$bean->id}'";
            
            // $log->fatal($updateSql);
            $db->query($updateSql);
        }
    }
  
}

?>