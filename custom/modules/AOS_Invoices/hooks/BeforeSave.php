<?php

require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

class AOS_InvoicesBeforeSaveHook
{
    public function handleInvoiceName(&$bean, $event, $arguments)
    {
        global $log;

        if (isset($bean->number)) {
            $bean->name = $bean->number;
        }
    }
    
}

?>