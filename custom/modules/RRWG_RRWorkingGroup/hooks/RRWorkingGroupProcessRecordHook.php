<?php

require_once('custom/modules/RRWG_RRWorkingGroup/helpers/RRWorkingGroupHelper.php');

class RRWorkingGroupProcessRecordHook
{
    public function customNameColumn($bean, $event, $arguments)
    {
        global $log;

        $rrwgBean = BeanFactory::getBean('RRWG_RRWorkingGroup', $bean->id);
        $parentData = RRWorkingGroupHelper::getParentData($rrwgBean->parent_type, $rrwgBean->parent_id);
        $displayName = $parentData['first_name'] . " " . $parentData['last_name'];
        
        $bean->full_name_non_db = "
            <a href='index.php?module=RRWG_RRWorkingGroup&action=DetailView&record={$bean->id}'>
                <span class='sugar_field'>{$displayName}</span>
            </a>";

        // For subpanels which uses the name column instead of full_name_non_db
        $bean->name = $bean->full_name_non_db;
    }
}


?>