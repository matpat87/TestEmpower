<?php
  class TimeProcessRecordHook
  {
    public function processCustomColumnStyle($bean, $event, $arguments)
    {
      global $app_list_strings;

      if ($_REQUEST['action'] !== 'Save') {
        $timeBean = BeanFactory::getBean('Time', $bean->id);

        if ($timeBean) $dataBean = BeanFactory::getBean($timeBean->parent_type, $timeBean->parent_id);
        
        if ($timeBean && $dataBean) {

          if ($timeBean->parent_type == 'TRI_TechnicalRequestItems') {
            $dataBean->name = $app_list_strings['distro_item_list'][$dataBean->name];
          }
            
          $bean->parent_name_non_db = "
            <a href='index.php?module={$timeBean->parent_type}&action=DetailView&record={$timeBean->parent_id}'>
                <span class='sugar_field'>{$dataBean->name}</span>
            </a>";
        }
      }
    }
  }
?>