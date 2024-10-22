<?php

require_once('custom/modules/AOS_Products_Quotes/helpers/ParentModuleLineItemChangeLogHelper.php');

class AOSProductsQuotesAfterSaveHook
{
    function HandleParentModuleLineItemChangeLogTransactions(&$bean, $event, $arguments)
    {
        ParentModuleLineItemChangeLogHelper::HandleChangeLogTransactions($bean, 'insert');
    }
}