<?php
  class PWG_ProjectWorkgroupProcessRecordHook
  {
    public function processCustomColumnStyle($bean, $event, $arguments)
    {
        $pwgBean = BeanFactory::getBean('PWG_ProjectWorkgroup', $bean->id);

        if ($pwgBean) $dataBean = BeanFactory::getBean($pwgBean->parent_type, $pwgBean->parent_id);
        
        if ($pwgBean && $dataBean) {
            $bean->parent_name_non_db = "
            <a href='index.php?module={$pwgBean->parent_type}&action=DetailView&record={$pwgBean->parent_id}'>
                <span class='sugar_field'>{$dataBean->name}</span>
            </a>";
            $bean->parent_type_non_db = ($pwgBean->parent_type == 'PWG_ProjectWorkgroup') 
              ? 'Project Workgroup'
              : 'Project';
        }
    }
  }
?>