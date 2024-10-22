<?php

require_once('custom/modules/AOS_Products_Quotes/helpers/ParentModuleLineItemChangeLogHelper.php');

class AOSProductsQuotesBeforeDeleteHook
{
    // This needs to be called here instead of after_delete as it causes an issue where if multiple line items are removed, only 1 gets inserted on the audit log
    // This needs to be called here instead of before or after relationship delete as it causes an issue where it triggers the logic hook equal to the total number of line items before delete was triggered (Ex. 3 Line items = 3 Logic hook executions of the same bean)
    function HandleParentModuleLineItemChangeLogTransactions(&$bean, $event, $arguments)
    {
        // Need to retrieve bean by way of $arguments['id'] as $bean->id is empty at this point
        if (! $arguments['id']) {
            return;
        }

        $deletedBean = BeanFactory::getBean('AOS_Products_Quotes', $arguments['id']);
        ParentModuleLineItemChangeLogHelper::HandleChangeLogTransactions($deletedBean, 'delete');
    }
}