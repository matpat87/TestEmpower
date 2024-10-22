<?php

class CustomerProductAfterRelationshipDelete 
{
    public function removeRelatedProduct(&$bean, $event, $arguments)
    {
        global $log, $db;
        
        // One to Many relationship
        if ($arguments['related_module'] == 'Cases' && $arguments['link'] == "cases_ci_customeritems_1") {
            // delete related data in ci_customeritems_cases_1 table

            $deleteSql = "DELETE FROM ci_customeritems_cases_1_c WHERE ci_customeritems_cases_1ci_customeritems_ida = '{$arguments['id']}' AND ci_customeritems_cases_1cases_idb = '{$arguments['related_id']}'";

            $res = $db->query($deleteSql);
        }

        // Many to Many relationship
        if ($arguments['related_module'] == 'Cases' && $arguments['link'] == "ci_customeritems_cases_1" && $arguments['related_bean']->ci_customeritems_cases_1ci_customeritems_ida == "") {
            // delete related data in aos_invoices_cases_1_c
            $deleteSql = "DELETE FROM cases_ci_customeritems_1_c WHERE cases_ci_customeritems_1ci_customeritems_idb = '{$arguments['id']}' AND cases_ci_customeritems_1cases_ida = '{$arguments['related_id']}'";

            $res = $db->query($deleteSql);
        }
    }
}
