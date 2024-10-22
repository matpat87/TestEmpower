<?php

require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

class CWGProcessRecordHook
{
    public function customNameColumn($bean, $event, $arguments)
    {
        global $log;

        $cwgBean = BeanFactory::getBean('CWG_CAPAWorkingGroup', $bean->id);
        $parentData = CapaWorkingGroupHelper::getParentData($cwgBean->parent_type, $cwgBean->parent_id);
        $displayName = $parentData['first_name'] . " " . $parentData['last_name'];

        $bean->full_name_non_db = "
            <a href='index.php?module=CWG_CAPAWorkingGroup&action=DetailView&record={$bean->id}'>
                <span class='sugar_field'>{$displayName}</span>
            </a>";

        // For subpanels which uses the name column instead of full_name_non_db
        $bean->name = $bean->full_name_non_db;
    }
}


?>