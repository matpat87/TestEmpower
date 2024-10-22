<?php

class DocumentsProcessRecordHook 
{
    public function handleRelatedToColumn(&$bean, $event, $arguments)
    {
        global $log;
        $docBean = BeanFactory::getBean('Documents', $bean->id);
        
        if (isset($docBean->parent_id)) {
            $parentBean = BeanFactory::getBean($docBean->parent_type, $docBean->parent_id);
            $bean->parent_name_non_db = "
                <a href='index.php?module={$parentBean->module_dir}&action=DetailView&record={$parentBean->id}'>
                    <span class='sugar_field'>{$parentBean->name}</span>
                </a>";
        }
    }
  
}