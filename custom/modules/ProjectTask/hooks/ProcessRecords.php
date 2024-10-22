<?php
  class ProjectTaskProcessRecordHook
  {
    public function processCustomColumnStyle($bean, $event, $arguments)
    {
        $projectTaskBean = BeanFactory::getBean('ProjectTask', $bean->id);

        if ($projectTaskBean) $dataBean = BeanFactory::getBean($projectTaskBean->parent_type, $projectTaskBean->parent_id);
        
        if ($projectTaskBean && $dataBean) {
            $bean->parent_name_non_db = "
            <a href='index.php?module={$projectTaskBean->parent_type}&action=DetailView&record={$projectTaskBean->parent_id}'>
                <span class='sugar_field'>{$dataBean->name}</span>
            </a>";
            $bean->parent_type_non_db = ($projectTaskBean->parent_type == 'PWG_ProjectWorkgroup') 
              ? 'Project Workgroup'
              : 'Project';
        }
    }
  }
?>