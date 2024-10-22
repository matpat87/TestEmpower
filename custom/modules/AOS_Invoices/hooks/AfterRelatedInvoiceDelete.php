<?php

class AfterRelatedInvoiceDelete 
{
    public function removeRelatedInvoice(&$bean, $event, $arguments)
    {
        global $log, $db;

        // One to Many relationship
        if ($arguments['related_module'] == 'Cases' && $arguments['link'] == "aos_invoices_cases_1") {
            // delete related data in cases_aos_invoices_1_c table

            $deleteSql = "DELETE FROM cases_aos_invoices_1_c WHERE cases_aos_invoices_1aos_invoices_idb = '{$arguments['id']}' AND cases_aos_invoices_1cases_ida = '{$arguments['related_id']}'";

            $res = $db->query($deleteSql);
        }

        // Many to Many relationship
        if ($arguments['related_module'] == 'Cases' && $arguments['link'] == "cases_aos_invoices_1") {
            // delete related data in aos_invoices_cases_1_c
            $deleteSql = "DELETE FROM aos_invoices_cases_1_c WHERE aos_invoices_cases_1aos_invoices_ida = '{$arguments['id']}' AND aos_invoices_cases_1cases_idb = '{$arguments['related_id']}'";

            $res = $db->query($deleteSql);
        }
    }
}
