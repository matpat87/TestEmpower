<?php

require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');

class TRWorkingGroupProcessRecordHook
{
    public function customNameColumn($bean, $event, $arguments)
    {
        global $log;

        $trwgBean = BeanFactory::getBean('TRWG_TRWorkingGroup', $bean->id);
        $parentData = TRWorkingGroupHelper::getParentData($trwgBean->parent_type, $trwgBean->parent_id);
        $displayName = $parentData['first_name'] . " " . $parentData['last_name'];
        
        $bean->full_name_non_db = "
            <a href='index.php?module=TRWG_TRWorkingGroup&action=DetailView&record={$bean->id}'>
                <span class='sugar_field'>{$displayName}</span>
            </a>";

        // For subpanels which uses the name column instead of full_name_non_db
        $bean->name = $bean->full_name_non_db;
    }
}


?>