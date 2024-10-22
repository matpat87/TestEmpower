<?php
    require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

    class DistributionAfterSaveHook {
        public function handleTRItemsData(&$bean, $event, $arguments)
        {
            // Since the handleTRItemsCRUDWorkflow function cannot execute on before save due to not having the distribution record generated yet, execute the function for new records on after save
            if (! $bean->fetched_row['id']) {
                $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tr_technicalrequests_id_c);
                $trBean && $trBean->id ? TechnicalRequestItemsHelper::handleTRItemsCRUDWorkflow($trBean) : null;
            }
        }
    }

?>