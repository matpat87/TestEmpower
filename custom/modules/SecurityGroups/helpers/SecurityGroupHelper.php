<?php

class SecurityGroupHelper {

  // Retrieve user account access security group (Ex. DCampbell)
  public function retrieveSecGroupAcctAccessBean($userId, $type)
  {
		return BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
			array(
				'assigned_user_id' => $userId,
				'type_c' => $type
			), false, true
		);
  }
  
	public function retrieveSecurityGroupsRelationshipList()
	{
		global $db;

		$array = [];
		$sql = "SELECT relationship_name FROM relationships WHERE lhs_module = 'SecurityGroups' AND deleted = 0";
		$result = $db->query($sql);

		while ($row = $db->fetchByAssoc($result)) {
			array_push($array, $row['relationship_name']);
		}

		return $array;
  }
  
	public function checkIfRecordExistsInSecurityGroup($securityGroupId, $recordId, $module)
	{
		global $db;

		$query = "SELECT count(*) FROM securitygroups_records WHERE securitygroup_id = '{$securityGroupId}' AND record_id = '{$recordId}' AND module = '{$module}' AND deleted = 0";
		$result = $db->getOne($query);
		
		return ($result) ? true : false;
  }
  
  public function insertOrDeleteSecurityGroupRecord($action, $securityGroupId, $recordId, $module, $eventLogId)
	{
		global $db, $timedate;

		if ($action == 'insert' && (! self::checkIfRecordExistsInSecurityGroup($securityGroupId, $recordId, $module))) {
			$newId = create_guid();
			$timeDateNow = $timedate->getNow()->asDb();

			$query = "INSERT INTO securitygroups_records (id, securitygroup_id, record_id, module, date_modified, modified_user_id, created_by, deleted)
								VALUES ('{$newId}', '{$securityGroupId}', '{$recordId}', '{$module}', '{$timeDateNow}', NULL, NULL, 0)";
		}

		if ($action == 'delete' && (self::checkIfRecordExistsInSecurityGroup($securityGroupId, $recordId, $module))) {
			$query = "DELETE FROM securitygroups_records WHERE securitygroup_id = '{$securityGroupId}' AND record_id = '{$recordId}' AND module = '{$module}' AND deleted = 0";
		}
    
    if ($query) {
      $db->query($query);
      $securityGroupId ? self::createSecurityGroupRecordLog($securityGroupId, $recordId, $module, $action, $eventLogId) : '';
    }
  }
  
  public function insertOrDeleteAccountChildModuleSecurityGroups($action, $accountId, $securityGroupId, $eventLogId, $isAssignedUserUpdatable, $assignmentType = 'Sales', $prevAssignedUserId = null, $prevSamId = null, $prevMdmId = null)
  {
    global $db, $log;

    $excludedIds = [];
    $excludedModules = ['Accounts', 'Users', 'SecurityGroups', 'MKT_Markets', 'MKT_NewMarkets', 'COMP_Competition', 'AOS_Products', 'Documents', 'Campaigns', 'Bugs', 'Employees', 'AURL_ActivityUserReassignmentsLog', 'SGRL_SecurityGroupRecordsLog', 'SecurityGroups'];

    $accountBean = BeanFactory::getBean('Accounts', $accountId);
    
    if ($isAssignedUserUpdatable) {
      $assignedUserUpdatableModules = ['Contacts', 'Opportunities', 'Meetings', 'Calls', 'Tasks']; // GO: exluded 'Cases' for now to fix bug on #1245

      foreach ($assignedUserUpdatableModules as $module) {
        $arrayOfIdsToUndergoMassAssignedUserUpdate[$module] = [];
      }

      if (is_object($accountBean->users_accounts_1users_ida)) {
				$retrieveSAMQuery = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$accountBean->users_accounts_1_name}'";
				$strategicAccountManagerId = $db->getOne($retrieveSAMQuery);
			} else {
				$strategicAccountManagerId = $accountBean->users_accounts_1users_ida;
      }
      
      if (is_object($accountBean->users_accounts_2users_ida)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$accountBean->users_accounts_2_name}'";
				$marketDevelopmentManagerId = $db->getOne($query);
			} else {
				$marketDevelopmentManagerId = $accountBean->users_accounts_2users_ida;
			}
    }

    $arrayOfSecurityGroupRelationships = self::retrieveSecurityGroupsRelationshipList();

    $massInsertArray = [];
    $massDeleteArray = [];
    $massInsertSecurityGroupRecordLogArray = [];
    
    if ($action == 'insert') {
       self::handleMassInsertDataPreparation($massInsertArray, $securityGroupId, $accountId, 'Accounts', $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);

       self::handleChildModuleReassignmentAndSecurityGroupInheritance($excludedModules, $accountBean, $arrayOfSecurityGroupRelationships, $excludedIds, $action, $massInsertArray, $massDeleteArray,$massInsertSecurityGroupRecordLogArray, $securityGroupId, $eventLogId, $isAssignedUserUpdatable, $assignedUserUpdatableModules, $arrayOfIdsToUndergoMassAssignedUserUpdate, $assignmentType, $prevAssignedUserId, $prevSamId, $prevMdmId);

       if (isset($massInsertArray) && count($massInsertArray) > 0) {
        $implodedValues = implode(',', $massInsertArray);

        if (isset($implodedValues) && $implodedValues) {
          $insertSQL = "INSERT INTO securitygroups_records (id, securitygroup_id, record_id, module, date_modified, modified_user_id, created_by, deleted)
          VALUES {$implodedValues}";

          $db->query($insertSQL);
        }
      }
    }

    if ($action == 'delete') {
      self::handleMassDeleteDataPreparation($massDeleteArray, $securityGroupId, $accountId, 'Accounts', $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);
      
      self::handleChildModuleReassignmentAndSecurityGroupInheritance($excludedModules, $accountBean, $arrayOfSecurityGroupRelationships, $excludedIds, $action, $massInsertArray, $massDeleteArray, $massInsertSecurityGroupRecordLogArray, $securityGroupId, $eventLogId, $isAssignedUserUpdatable, $assignedUserUpdatableModules, $arrayOfIdsToUndergoMassAssignedUserUpdate, $assignmentType, $prevAssignedUserId, $prevSamId, $prevMdmId);

      if (isset($massDeleteArray) && count($massDeleteArray) > 0) {
        foreach ($massDeleteArray as $key => $value) {
          $implodedValues = implode(',', $value);

          if (isset($implodedValues) && $implodedValues) {
            $deleteSQL = "DELETE FROM securitygroups_records WHERE securitygroups_records.securitygroup_id = '{$securityGroupId}' AND securitygroups_records.module = '{$key}' AND securitygroups_records.deleted = 0 AND securitygroups_records.record_id IN ({$implodedValues})";

            $db->query($deleteSQL);
          }
        }
      }
    }

    if (isset($massInsertSecurityGroupRecordLogArray) && count($massInsertSecurityGroupRecordLogArray) > 0) {
      $implodedValues = implode(',', $massInsertSecurityGroupRecordLogArray);

      if (isset($implodedValues) && $implodedValues) {
        $insertSecurityGroupRecordLogSQL = "INSERT INTO sgrl_securitygrouprecordslog (
          id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, module, secgroup_id, record_id, action, secgroup_name, record_name, secgroup_type, event_log_id
        )
        VALUES {$implodedValues}";
  
        $db->query($insertSecurityGroupRecordLogSQL);
      }
    }

    if ($isAssignedUserUpdatable) {
      switch ($assignmentType) {
        case 'Sales':
          $newAssignedUserId = $accountBean->assigned_user_id;
          break;
        case 'SAM':
          $newAssignedUserId = $strategicAccountManagerId;
          break;
        case 'MDM':
          $newAssignedUserId = $marketDevelopmentManagerId;
          break;
        default:
          $newAssignedUserId = null;
          break;
      }
      
      (isset($newAssignedUserId) && $newAssignedUserId)
        ? self::updateAssignedUserRecords($arrayOfIdsToUndergoMassAssignedUserUpdate, $newAssignedUserId, $eventLogId) 
        : '';
    }
  }

  public function setArrayOfIdsToUndergoMassAssignedUserUpdate($array, $moduleName, $moduleId)
  {
    $moduleBean = BeanFactory::getBean($moduleName, $moduleId);

    switch ($moduleName) {
      case 'Opportunities':
        if (stripos($moduleBean->sales_stage, 'Closed') === false) array_push($array[$moduleName], "'{$moduleId}'");
        break;
      case 'Cases':
        if ($moduleBean->status !== 'Closed') array_push($array[$moduleName], "'{$moduleId}'");
        break;
      case 'Meetings':
      case 'Calls':
        if ($moduleBean->status !== 'Held') array_push($array[$moduleName], "'{$moduleId}'");
        break;
      case 'Tasks':
        if ($moduleBean->status !== 'Completed') array_push($array[$moduleName], "'{$moduleId}'");
        break;
      case 'Contacts':
        array_push($array[$moduleName], "'{$moduleId}'");
        break;
      default:
        break;
    }

    return $array;
  }
  
  public function updateAssignedUserRecords($arrayOfIdsToUndergoMassAssignedUserUpdate, $newAssignedUserId, $eventLogId)
  {
    global $db, $timedate;

    if ($arrayOfIdsToUndergoMassAssignedUserUpdate) {
      $excludedRecordIds = [];

      foreach ($arrayOfIdsToUndergoMassAssignedUserUpdate as $parentKey => $parentValue) {
        if (! $parentValue) continue;
  
        $tableName = strtolower($parentKey);
        $implodedIds = implode(',', $parentValue);

        foreach ($parentValue as $recordId) {
          if (! in_array($recordId, $excludedRecordIds)) {
            self::createActivityUserReassignmentLog($parentKey, str_replace("'", "", $recordId), $newAssignedUserId, $eventLogId);
            array_push($excludedRecordIds, $recordId);
          }
        }

        $updateQuery = "UPDATE {$tableName} SET assigned_user_id = '{$newAssignedUserId}' WHERE id IN ({$implodedIds}) AND deleted = 0";
        $db->query($updateQuery);
      }
    }
  }

  public function createSecurityGroupRecordLog($securityGroupId, $recordId, $module, $action, $eventLogId)
  {
    global $app_list_strings;
    
    if ($module == 'Users') {
      return false;
    }

    $recordBean = BeanFactory::getBean($module, $recordId);
    $recordName = (isset($recordBean->first_name) && $recordBean->first_name) ? trim("{$recordBean->first_name} {$recordBean->last_name}") : $recordBean->name;

    $secGroupBean = BeanFactory::getBean('SecurityGroups', $securityGroupId);

    if ($recordBean && $secGroupBean) {
      $securityGroupRecordLogBean = BeanFactory::newBean('SGRL_SecurityGroupRecordsLog');
      $securityGroupRecordLogBean->secgroup_id = $securityGroupId;
      $securityGroupRecordLogBean->secgroup_name = $secGroupBean->name;
      $securityGroupRecordLogBean->secgroup_type = $app_list_strings['sec_group_type_dom'][$secGroupBean->type_c];
      $securityGroupRecordLogBean->record_name = $recordName;
      $securityGroupRecordLogBean->record_id = $recordId;
      $securityGroupRecordLogBean->event_log_id = $eventLogId;
      $securityGroupRecordLogBean->module = $module;
      $securityGroupRecordLogBean->action = $action;
      $securityGroupRecordLogBean->save();
    }
  }

  public function createActivityUserReassignmentLog($module, $recordId, $newAssignedUserId, $eventLogId)
  {
    $recordBean = BeanFactory::getBean($module, $recordId);
    $recordName = (isset($recordBean->first_name) && $recordBean->first_name) ? trim("{$recordBean->first_name} {$recordBean->last_name}") : $recordBean->name;

    $oldAssignedUserBean = BeanFactory::getBean('Users', $recordBean->assigned_user_id);
    $newAssignedUserBean = BeanFactory::getBean('Users', $newAssignedUserId);

    if ($recordBean && $oldAssignedUserBean->id !== $newAssignedUserBean->id) {
      $activityUserReassignmentLogBean = BeanFactory::newBean('AURL_ActivityUserReassignmentsLog');
      $activityUserReassignmentLogBean->record_id = $recordId;
      $activityUserReassignmentLogBean->record_name = $recordName;
      $activityUserReassignmentLogBean->old_assigned_user_id = $oldAssignedUserBean ? $oldAssignedUserBean->id : '';
      $activityUserReassignmentLogBean->old_assigned_user_name = $oldAssignedUserBean ? trim("{$oldAssignedUserBean->first_name} {$oldAssignedUserBean->last_name}") : '';
      $activityUserReassignmentLogBean->new_assigned_user_id = $newAssignedUserBean ? $newAssignedUserBean->id : '';
      $activityUserReassignmentLogBean->new_assigned_user_name = $newAssignedUserBean ? trim("{$newAssignedUserBean->first_name} {$newAssignedUserBean->last_name}") : '';
      $activityUserReassignmentLogBean->event_log_id = $eventLogId;
      $activityUserReassignmentLogBean->module = $module;
      $activityUserReassignmentLogBean->save();
    }
  }

  //OnTrack #1177
  public function selectDefaultSecurityGroups($module = 'All'){
    $result = array();
    global $db;

    $query = "SELECT securitygroup_id,
                module
            FROM securitygroups_default
            where deleted = 0";
    $data = $db->query($query);
    
    while($rowData = $db->fetchByAssoc($data)){

        if($rowData['module'] == $module 
            || $rowData['module'] == 'All'){
            $result[] = $rowData;
        }
    }

    return $result;
  }

  // Function is used to determine if user exists in any Account or Division Access Security Group
  public function checkIfUserExistsInAccountOrDivisionAccessSecurityGroup($userBean = null)
  {
    global $db, $current_user;

    $selectedUserBean = ($userBean && $userBean->id && $current_user->id != $userBean->id) ? $userBean : $current_user;

    $query = "SELECT count(*) FROM securitygroups 
      LEFT JOIN securitygroups_cstm
        ON securitygroups.id = securitygroups_cstm.id_c
      LEFT JOIN securitygroups_users
        ON securitygroups.id = securitygroups_users.securitygroup_id
        AND securitygroups_users.deleted = 0
      WHERE securitygroups.deleted = 0
        AND securitygroups_cstm.type_c IN ('Account Access', 'Division Access') 
        AND securitygroups_users.user_id = '{$selectedUserBean->id}'";
    $result = $db->getOne($query);

    return ($result) ? true : false;
  }

  public function handleChildModuleReassignmentAndSecurityGroupInheritance($excludedModules, &$bean, $arrayOfSecurityGroupRelationships, &$excludedIds, $action, &$massInsertArray, &$massDeleteArray, &$massInsertSecurityGroupRecordLogArray, $securityGroupId, $eventLogId, $isAssignedUserUpdatable, $assignedUserUpdatableModules, &$arrayOfIdsToUndergoMassAssignedUserUpdate, $assignmentType = 'Sales', $prevAssignedUserId = null, $prevSamId = null, $prevMdmId = null, $recursionLevel = 0)
  {    
    $relationships = $bean->get_linked_fields();

    if (isset($relationships) && count($relationships) > 0) {
      foreach ($relationships as $relationshipKey => $relationshipValue) {
        if (in_array($relationshipValue['module'], $excludedModules)) {
          continue;
        }

        if ($bean->load_relationship($relationshipKey) && $bean->$relationshipKey->get()) {
          foreach ($bean->$relationshipKey->get() as $childRelationshipKey => $childRelationshipValue) {

            $childBeanName = $relationshipValue['module'] ?? ucfirst($relationshipValue['name']);
            $childBean = BeanFactory::getBean($childBeanName, $childRelationshipValue);
            $lowerCaseModuleName = strtolower($childBeanName);
            $securityGroupRelationshipName = "securitygroups_{$lowerCaseModuleName}";

            if (! $childBean->id) continue;

            $childUserBean = BeanFactory::getBean('Users', $childBean->assigned_user_id);
            $proceedChildReassignmentProcess = false;

            if (in_array($securityGroupRelationshipName, $arrayOfSecurityGroupRelationships) && (! in_array($childBean->id, $excludedIds))) {
              if ($action == 'insert') {
                self::handleMassInsertDataPreparation($massInsertArray, $securityGroupId, $childBean->id, $childBeanName, $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);
              }

              if ($action == 'delete') {
                self::handleMassDeleteDataPreparation($massDeleteArray, $securityGroupId, $childBean->id, $childBeanName, $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);
              }

              if ($isAssignedUserUpdatable && in_array($childBeanName, $assignedUserUpdatableModules) && (! in_array("'{$childBean->id}'", $arrayOfIdsToUndergoMassAssignedUserUpdate[$childBeanName]))) {
                switch ($assignmentType) {
                  case 'Sales':
                    $proceedChildReassignmentProcess = ($childBean->assigned_user_id == $prevAssignedUserId) ? true : false;
                    break;
                  case 'SAM':
                    $proceedChildReassignmentProcess = ($childBean->assigned_user_id == $prevSamId) ? true : false;
                    break;
                  case 'MDM':
                    $proceedChildReassignmentProcess = ($childBean->assigned_user_id == $prevMdmId) ? true : false;
                    break;
                  default:
                    $proceedChildReassignmentProcess = false;
                    break;
                }

                if ($proceedChildReassignmentProcess) {
                  $arrayOfIdsToUndergoMassAssignedUserUpdate = self::setArrayOfIdsToUndergoMassAssignedUserUpdate($arrayOfIdsToUndergoMassAssignedUserUpdate, $childBeanName, $childBean->id);
                }
              }
            }
          }
        }
      }

      // Special cases where some modules can't fetch the respective relationship as it uses field type "Relate" instead of creating one-to-many relationship
      self::handleRelateFieldSecurityGroupInheritance($bean, $action, $massInsertArray, $massDeleteArray, $securityGroupId, $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);

      // Need to loop relationships again to make sure the function fully finishes before recurring
      foreach ($relationships as $relationshipKey => $relationshipValue) {
        if (in_array($relationshipValue['module'], $excludedModules)) {
          continue;
        }

        if ($bean->load_relationship($relationshipKey) && $bean->$relationshipKey->get()) {
          foreach ($bean->$relationshipKey->get() as $childRelationshipKey => $childRelationshipValue) {

            $childBeanName = $relationshipValue['module'] ?? ucfirst($relationshipValue['name']);
            $childBean = BeanFactory::getBean($childBeanName, $childRelationshipValue);
            $lowerCaseModuleName = strtolower($childBeanName);
            $securityGroupRelationshipName = "securitygroups_{$lowerCaseModuleName}";

            if (! $childBean->id) continue;

            if ($recursionLevel < 1) {
              self::handleChildModuleReassignmentAndSecurityGroupInheritance($excludedModules, $childBean, $arrayOfSecurityGroupRelationships, $excludedIds, $action, $massInsertArray, $massDeleteArray, $massInsertSecurityGroupRecordLogArray, $securityGroupId, $eventLogId, $isAssignedUserUpdatable, $assignedUserUpdatableModules, $arrayOfIdsToUndergoMassAssignedUserUpdate, $assignmentType, $prevAssignedUserId, $prevSamId, $prevMdmId, $recursionLevel + 1);
            }
          }
        }
      }
    }
  }

  public function handleRelateFieldSecurityGroupInheritance(&$bean, $action, &$massInsertArray, &$massDeleteArray, $securityGroupId, $eventLogId, &$excludedIds, &$massInsertSecurityGroupRecordLogArray)
  {
    switch ($bean->module_dir) {
      case 'TR_TechnicalRequests':
        $distroBean = BeanFactory::getBean('DSBTN_Distribution');
        $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$bean->id}'", false, 0);

        if ($distroBeanList != null && count($distroBeanList) > 0) {
          foreach ($distroBeanList as $distroBean) {
            if ($action == 'insert') {
              self::handleMassInsertDataPreparation($massInsertArray, $securityGroupId, $distroBean->id, $distroBean->module_dir, $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);
            }

            if ($action == 'delete') {
              self::handleMassDeleteDataPreparation($massDeleteArray, $securityGroupId, $distroBean->id, $distroBean->module_dir, $eventLogId, $excludedIds, $massInsertSecurityGroupRecordLogArray);
            }
          }
        }
        break;
      default:
        break;
    }
  }
  
  public function handleMassInsertDataPreparation(&$massInsertArray, $securityGroupId, $recordId, $module, $eventLogId, &$excludedIds, &$massInsertSecurityGroupRecordLogArray)
	{
		global $timedate;

		if (! self::checkIfRecordExistsInSecurityGroup($securityGroupId, $recordId, $module)) {
			$newId = create_guid();
      $timeDateNow = $timedate->getNow()->asDb();
      
      $formattedInsertString = implode(',', [
        "'{$newId}'", "'{$securityGroupId}'", "'{$recordId}'", "'{$module}'", "'{$timeDateNow}'", "NULL", "NULL", 0
      ]);

      $massInsertArray[] = "({$formattedInsertString})";

      self::handleMassInsertSecurityGroupRecordLog($massInsertSecurityGroupRecordLogArray, 'insert', $securityGroupId, $recordId, $module, $eventLogId);
    }

    array_push($excludedIds, $recordId);

    return $massInsertArray;
  }

  public function handleMassDeleteDataPreparation(&$massDeleteArray, $securityGroupId, $recordId, $module, $eventLogId, &$excludedIds, &$massInsertSecurityGroupRecordLogArray)
	{
		if (self::checkIfRecordExistsInSecurityGroup($securityGroupId, $recordId, $module)) {
      $massDeleteArray[$module][] = "'{$recordId}'";

      self::handleMassInsertSecurityGroupRecordLog($massInsertSecurityGroupRecordLogArray, 'delete', $securityGroupId, $recordId, $module, $eventLogId);
    }

    array_push($excludedIds, $recordId);

    return $massDeleteArray;
  }

  public function handleMassInsertSecurityGroupRecordLog(&$massInsertSecurityGroupRecordLogArray, $action, $securityGroupId, $recordId, $module, $eventLogId)
  {
    global $current_user, $timedate, $app_list_strings;

    if ($module == 'Users') {
      return false;
    }

    $recordBean = BeanFactory::getBean($module, $recordId);

    if (! $recordBean->id) {
      return false;
    }

    $recordName = (isset($recordBean->first_name) && $recordBean->first_name) 
      ? trim("{$recordBean->first_name} {$recordBean->last_name}") 
      : $recordBean->name;

    $secGroupBean = BeanFactory::getBean('SecurityGroups', $securityGroupId);

    if (! $secGroupBean->id) {
      return false;
    }

    $newId = create_guid();
    $timeDateNow = $timedate->getNow()->asDb();
    
    $formattedInsertString = implode(',', [
      "'{$newId}'", "NULL", "'{$timeDateNow}'", "'{$timeDateNow}'", "'{$current_user->id}'", "'{$current_user->id}'", "NULL", 0, "NULL", "'{$module}'", "'{$secGroupBean->id}'", "'{$recordBean->id}'", "'{$action}'", "'{$secGroupBean->name}'", "'{$recordName}'", "'{$app_list_strings['sec_group_type_dom'][$secGroupBean->type_c]}'", "'{$eventLogId}'"
    ]);

    $massInsertSecurityGroupRecordLogArray[] = "({$formattedInsertString})";
  }

  // Used on SecurityGroupFormBase.php under handleSave function and SecurityGroupsController class (controller.php) under action_check_if_duplicate_exists function
  public static function handleDuplicateCheck($postData, $prefix = ''): array
  {
      global $db, $log;

      $response = ['data' => ['isDuplicate' => false, 'duplicateRecordId' => null]];
      $fieldsToCheck = ['name', 'type_c', 'site_c', 'division_c'];
      $queryConditions = '';

      foreach ($fieldsToCheck as $field) {
          if (! empty($prefix)) {
              $fieldVal = (! empty($postData[$prefix . $field])) ? $postData[$prefix . $field] : '';
          } else {
              $fieldVal = (! empty($postData[$field])) ? $postData[$field] : '';
          }

          if (! empty($fieldVal)) {
              $queryConditions .= " AND {$field} = {$db->quoted($fieldVal)}";
          } else {
              $queryConditions .= " AND ({$field} IS NULL OR {$field} = {$db->quoted($fieldVal)})";
          }
      }

      if (! empty($queryConditions)) {
          $query = "
                SELECT id 
                FROM securitygroups 
                LEFT JOIN securitygroups_cstm 
                    ON securitygroups.id = securitygroups_cstm.id_c 
                WHERE deleted != 1 {$queryConditions}
            ";

          // Need to exclude from duplicate check if editing the same record
          if (! empty($postData['record'])) {
              $query .= " AND id != '{$postData['record']}'";
          }

          $duplicateSecurityGroupId = $db->getOne($query);
          $response['data']['isDuplicate'] = (bool) $duplicateSecurityGroupId;
          $response['data']['duplicateRecordId'] = $duplicateSecurityGroupId;
      }

      return $response;
  }
}