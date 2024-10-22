<?php

class SoftDeleteRelatedBeansJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db, $log;

    $decodedArguments = json_decode(html_entity_decode($arguments), 1);
    $recordId = $decodedArguments['record_id'];
    $moduleName = $decodedArguments['module_name'];
    $userId = $decodedArguments['user_id'];

    // For security groups, directly set deleted = 1 on DB query instead of running default mark_deleted core function
    if ($moduleName == 'SecurityGroups') {
      $softDeleteSecGroupRecordsSQL = "UPDATE securitygroups_records 
          SET 
              deleted = 1, 
              modified_user_id = '{$userId}', 
              date_modified = NOW() 
          WHERE securitygroup_id = '{$recordId}' AND deleted = 0;
      ";

      $softDeleteSecGroupACLRolesSQL = "UPDATE securitygroups_acl_roles 
          SET 
              deleted = 1, 
              date_modified = NOW() 
          WHERE securitygroup_id = '{$recordId}' AND deleted = 0;
      ";

      $softDeleteSecGroupUsersSQL = "UPDATE securitygroups_users 
          SET 
              deleted = 1, 
              date_modified = NOW() 
          WHERE securitygroup_id = '{$recordId}' AND deleted = 0;
      ";

      $db->query($softDeleteSecGroupRecordsSQL);
      $db->query($softDeleteSecGroupACLRolesSQL);
      $db->query($softDeleteSecGroupUsersSQL);
    } else {
      // Use get_full_list as passing id on getBean does not work on deleted = 1 records and retrieve_by_string_fields does not work as well
      $tableName = BeanFactory::getBean($moduleName)->table_name;
      $beanList = BeanFactory::getBean($moduleName)->get_full_list("{$tableName}.id" ,"{$tableName}.id = '{$recordId}'", false, 1);
      $bean = (isset($beanList) && count($beanList) > 0) 
        ? $beanList[0] 
        : BeanFactory::getBean($moduleName);
      
      if (! $bean->id) {
        $log->fatal("[SoftDeleteRelatedBeansJob] Unable to retrieve Bean Record: [{$moduleName}][$recordId]");
        
        return false;
      }

      // Codes here are from core mark_deleted function -- START
      // call the custom business logic
      $custom_logic_arguments['id'] = $recordId;
      $bean->call_custom_logic("before_delete", $custom_logic_arguments);
      $bean->mark_relationships_deleted($recordId);

      // This does not work when triggered via Scheduler
      // SugarRelationship::resaveRelatedBeans();

      $bean->deleteFiles();

      // call the custom business logic
      $bean->call_custom_logic("after_delete", $custom_logic_arguments);
      // Codes here are from core mark_deleted function -- END
    }
    
    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}