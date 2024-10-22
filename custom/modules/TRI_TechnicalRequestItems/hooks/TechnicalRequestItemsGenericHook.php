<?php
    require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

    class TechnicalRequestItemsGenericHook
    {
        /**
         * A generic hook that is triggered either by AFTER SAVE TR ITEM or AFTER RELATIONSHIP ADD
         * 
         */
        public function handleAssignedUserNotification(&$bean, $events, $arguments)
        {
            global $app_list_strings, $log;

            /**
             * Event: after_relationship_add
             * Check if $arguments['related_module] == 'TR_TechnicalRequests'
             * And that if it's a new Record OR the assigned user is changed
             */
            if ($events == 'after_relationship_add') {
                // Need to skip as it causes issue where it sends the email twice on non-distro generated TR Items
                if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'TRI_TechnicalRequestItems') && (! $bean->fetched_row['id'])) {
                    return;
                }

                $bean->tri_techni0387equests_ida = (isset($arguments['related_module']) && $arguments['related_module'] == 'TR_TechnicalRequests')
                    ? $arguments['related_id']
                    : $bean->tri_techni0387equests_ida;
            } else if ($events == 'after_save') {
                $bean->tri_techni0387equests_ida = (isset($_REQUEST['module']) && $_REQUEST['module'] == 'TR_TechnicalRequests')
                    ? $_REQUEST['record']
                    : $bean->tri_techni0387equests_ida;
            }

            // Need to trim as for some reason it appends blank spaces when value is blank
            // Note: This happens when saving from TRWG_TRWorkingGroup
            if (! trim($bean->tri_techni0387equests_ida)) {
                $bean->tri_techni0387equests_ida = (isset($_REQUEST['tr_technic9742equests_ida']) && $_REQUEST['tr_technic9742equests_ida'])
                    ? $_REQUEST['tr_technic9742equests_ida']
                    : $bean->tri_techni0387equests_ida;
            }

            // Do not proceed if core bug triggers where supposed record id is returned as module object
            if (is_object($bean->tri_techni0387equests_ida)) return;

            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tri_techni0387equests_ida);

            if (! $trBean->id) return;

            $sendNotification = false;

            if ($bean->name == 'colormatch_task') {
                // Send Notification for new record or assignment
                if (! $bean->fetched_row['id'] || $bean->fetched_row['assigned_user_id'] <> $bean->assigned_user_id) {
                    $sendNotification = true;
                }

                // If Colormatch is set to Complete, retrieve all related TR Items with status 'New' and notify assigned user
                if ($bean->fetched_row['status'] <> $bean->status && $bean->status == 'complete') {
                    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tri_techni0387equests_ida);

                    if (! $trBean->id) return;

                    $trItemBeanList = $trBean->get_linked_beans(
                        'tri_technicalrequestitems_tr_technicalrequests',
                        'TRI_TechnicalRequestItems',
                        array(),
                        0,
                        -1,
                        0,
                        "tri_technicalrequestitems.status IN ('new') AND tri_technicalrequestitems.name <> 'colormatch_task'"
                    );

                    if (! empty($trItemBeanList) && count($trItemBeanList) > 0) {
                        foreach($trItemBeanList as $trItemBean) {
                            TechnicalRequestItemsHelper::triggerMailNotification($trItemBean, [], "EmpowerCRM Assigned Technical Request Item: {$app_list_strings['distro_item_list'][$trItemBean->name]}");
                        }
                    }
                }
            } else {
                $colormatchTrItemBeanList = $trBean->get_linked_beans(
                    'tri_technicalrequestitems_tr_technicalrequests',
                    'TRI_TechnicalRequestItems',
                    array(),
                    0,
                    -1,
                    0,
                    "tri_technicalrequestitems.status NOT IN ('complete', 'rejected') AND tri_technicalrequestitems.name = 'colormatch_task'"
                );

                // Do not proceed if Colormatch exists where status is not complete or rejected
                if (! empty($colormatchTrItemBeanList) && count($colormatchTrItemBeanList) > 0) {
                    return;
                }

                // Send Notification for new record or assignment
                if (! $bean->fetched_row['id'] || $bean->fetched_row['assigned_user_id'] <> $bean->assigned_user_id) {
                    $sendNotification = true;
                }
            }

            if ($sendNotification) {
                TechnicalRequestItemsHelper::triggerMailNotification($bean, [], "EmpowerCRM Assigned Technical Request Item: {$app_list_strings['distro_item_list'][$bean->name]}");
            }
        }
}
