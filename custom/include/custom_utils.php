<?php
	require_once('custom/include/custom_utils/Constants.php');
	require_once('custom/include/custom_utils/SalesActivityReportQuery.php');
	require_once('custom/include/custom_utils/BudgetReportQuery.php');
	require_once('custom/include/custom_utils/TimeAndDate.php');
	require_once('custom/include/custom_utils/OpportunityPipelineReport.php');
	require_once('custom/include/custom_utils/SalesActivityStatisticsQuery.php');
	require_once('custom/include/custom_utils/NumberHelper.php');
	require_once('custom/include/custom_utils/CustomMailNotification.php');

	require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

	function string_replace_all($find, $replace, $string)
	{
		$lastPos = 0;
		$positions = array();
		$replaceLength = strlen($find);

		while (($lastPos = strpos($string, $find, $lastPos))!== false) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + $replaceLength;
		}

		// Displays 3 and 10
		foreach ($positions as $value) {
		    $string = str_replace($find, $replace, $string);
		}

		return $string;
	}

	function convert_to_money($string_money)
	{
		return "$" . number_format($string_money, 2, '.', ',');
	}

	function get_dropdown_index($dropdown_name, $dropdown_value)
	{
		global $app_list_strings;

		$index = 1;
		$dropdown = array();

		if(!empty($app_list_strings) && $app_list_strings[$dropdown_name] != null)
		{
			$dropdown = $app_list_strings[$dropdown_name];
			$i = 1;

			foreach ($dropdown as $key => $value) {

				if($value == $dropdown_value) 
				{
					$index = $i;
				}

				$i++;
			}
		}

		return $index;
	}

	function getUserRepresentativesForReports()
	{
		global $current_user;
		return (! $current_user->is_admin) ? retrieveSalesGroupUsers() : retrieveUsersList();
	}

	function getAccountsForReports()
	{
		global $db, $current_user;

		$dropdown_data = array();
		$query = "";

		if($current_user->is_admin)
		{
			$query = "SELECT id, 
					name
				  FROM accounts
				  WHERE deleted = 0
				  ORDER by name asc";
		}
		else
		{
			$securityGroupBean = BeanFactory::getBean('SecurityGroups');
        	$security_groups_assiged = $securityGroupBean->retrieve_by_string_fields(array('assigned_user_id' => $current_user->id, 'type_c' => 'Sales Group'), false, true);

        	if(!empty($security_groups_assiged))
        	{
				$query = "SELECT a.id,
						a.name
                    FROM securitygroups AS s
                    INNER JOIN securitygroups_cstm AS sc
                        ON sc.id_c = s.id
                    INNER JOIN securitygroups_users AS su
                        ON su.securitygroup_id = s.id
                        AND su.deleted = 0
                    INNER JOIN users AS u
                        ON u.id = su.user_id
                        AND u.deleted = 0
                    INNER JOIN accounts as a
                    	ON a.assigned_user_id = u.id
                    WHERE s.deleted = 0
                        AND sc.type_c = 'Sales Group'
                        AND (s.assigned_user_id = '{$current_user->id}' OR u.id = '{$current_user->id}')
					ORDER by name asc";
        	}
        	else
        	{
        		$query = "SELECT id, 
					name
				  FROM accounts
				  WHERE deleted = 0
				  		AND assigned_user_id = '{$current_user->id}'
				  ORDER by name asc";
        	}
		}

		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$dropdown_data[$row['id']] = $row['name'];
    	}

		return $dropdown_data;
	}

	function getDivisionsForReports() {
		
		global $app_list_strings, $current_user, $db;

		// Set default value for divisionList to 'All'
		$divisionList['All'] = 'All';

		// Loop through division dropdown list (based from user module's division field)
		foreach ($app_list_strings['user_division_list'] as $key => $value) {
			// Add to divisionList if key is not empty
			if($key) {
				$divisionList[$key] = $value;
			}
		}
		
		return $divisionList;
	}

	function getDepartmentsForReports() {

		global $app_list_strings, $current_user, $db;

		// Set default value for departmentList to 'All'
		$departmentList['All'] = 'All';

		// Loop through department dropdown list (based from user module's department field)
		foreach ($app_list_strings['department_list'] as $key => $value) {
			// Add to departmentList if key is not empty
			if($key) {
				$departmentList[$key] = $value;
			}
		}
		
		return $departmentList;
	}
	function getSalesGroupForReports() {

		global $app_list_strings, $current_user, $db, $log;

		// Set default value for salesGroupList to 'All' if not in Users module
		// Force as blank when in users module as it gets saved to DB as opposed to just using it for filtering data
		if ($_REQUEST['module'] == 'Users') {
			$salesGroupList[''] = '';
		} else {
			$salesGroupList['All'] = 'All';
		}

		$securityGroupBean = BeanFactory::getBean('SecurityGroups');
        $securityGroupBeanList = $securityGroupBean->get_full_list("", "securitygroups_cstm.type_c = 'Sales Group'", false, 0);

        if ($securityGroupBeanList != null && count($securityGroupBeanList) > 0) {
          	foreach ($securityGroupBeanList as $key => $value) {
				$userBean = BeanFactory::getBean('Users', $value->assigned_user_id);

				if (isset($userBean) && $userBean->id) {
					$salesGroupList[$userBean->id] = "Team {$userBean->last_name}";
				}
			}
		}

		asort($salesGroupList);

		return $salesGroupList;
	}

	function retrieveStartAndEndOfWeekDates(): array {
		global $current_user, $timedate;

		// Retrieve logged user timezone
		$timezone = $timedate->getInstance()->userTimezone();

		// Retrieve logged user date format
		$userDateFormat = $timedate->getInstance()->get_date_format();

		// Retrieve current date based from user timezone
		$userDateNow = Carbon::now($timezone);

		// Set Start and End week of Carbon from Sunday to Saturday
		$userDateNow->setWeekStartsAt(Carbon::SUNDAY);
		$userDateNow->setWeekEndsAt(Carbon::SATURDAY);
		
		// Retrieve Start and End of week dates from Carbon with DB date format
		$dbFormatStartOfWeek = $userDateNow->startOfWeek()->toDateString();
		$dbFormatEndOfWeek = $userDateNow->endOfWeek()->toDateString();

		// Retrieve Start and End of week dates from Carbon with user format
		$startOfWeek = $userDateNow->startOfWeek()->format($userDateFormat);
		$endOfWeek = $userDateNow->endOfWeek()->format($userDateFormat);
		
		return [
			'dbFormatStartOfWeek' => $dbFormatStartOfWeek,
			'dbFormatEndOfWeek' 	=> $dbFormatEndOfWeek,
			'startOfWeek' 				=> $startOfWeek,
			'endOfWeek' 					=> $endOfWeek
		];
	}

	function retrieveUsersList() {
		global $db;

		$query = "SELECT u.id, TRIM(CONCAT(IFNULL(u.first_name, ''), ' ', IFNULL(u.last_name, ''))) AS name
		FROM users as u
		INNER JOIN users_cstm as uc
			ON uc.id_c = u.id
		WHERE u.deleted = 0
		ORDER by name ASC";
		
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
			$users[$row['id']] = $row['name'];
		}

		return $users;
	}
	
	function retrieveSalesGroupUsers($userId = null) {
		global $current_user;
		
		if (! $userId) {
			$salesGroupUsers[$current_user->id] = "{$current_user->first_name} {$current_user->last_name}";
		} else {
			$filteredUserBean = BeanFactory::getBean('Users', $userId);
			$salesGroupUsers[$filteredUserBean->id] = "{$filteredUserBean->first_name} {$filteredUserBean->last_name}";
		}
		
		$user = $filteredUserBean ?? $current_user;
		
		if (! $user->is_admin) {
			$salesGroupSecurityGroup = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
				array(
					'assigned_user_id' => $user->id, 
					'type_c' => 'Sales Group'
				), false, true
			) ?? [];
			
			$salesGroupUserIds = ($salesGroupSecurityGroup && $salesGroupSecurityGroup->load_relationship('users')) ? $salesGroupSecurityGroup->users->get() : [];
			
			foreach($salesGroupUserIds as $id) {
				$userBean = BeanFactory::getBean('Users', $id);
				$salesGroupUsers[$userBean->id] = "{$userBean->first_name} {$userBean->last_name}";
			}
		} else {
			$userBean = BeanFactory::getBean('Users');
			$userBeanList = $userBean->get_full_list();
			
			foreach ($userBeanList as $user) {
				$salesGroupUsers[$user->id] = $user->full_name;
			}
		}

		asort($salesGroupUsers);
		
		return $salesGroupUsers;
	}

	function sendEmail($subject, $body, $recipients)
	{
		global $sugar_config;

		$emailObj = new Email();
		$defaults = $emailObj->getSystemDefaultEmail();
		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
		$mail->From = $defaults['email'];
		$mail->FromName = $defaults['name'];

		$mail->Subject = $subject;

		$mail->Body = from_html($body);

		foreach ($recipients as $recipient) {
			$mail->AddAddress($recipient);
		}
		
		$mail->AddBCC($sugar_config['systemBCCEmailAddress']);
		$mail->isHTML(true);
		$mail->prepForOutbound();
		$mail->Send();
	}

	function retrieveActualHours($parentId, $parentType)
	{
		global $db;
		$query = "SELECT IF(time, SUM(time), 0) FROM times WHERE parent_id = '{$parentId}' AND parent_type = '{$parentType}' AND deleted = 0";
		return $db->getOne($query);
	}

	function custom_get_user_array($add_blank = true, $status = 'Active', $user_id = '', $use_real_name = false, $user_name_filter = '', $portal_filter = ' AND portal_only=0 ', $from_cache = true)
	{
			global $locale, $sugar_config, $current_user;

			if (empty($locale)) {
					$locale = new Localization();
			}

			if ($from_cache) {
					$key_name = $add_blank . $status . $user_id . $use_real_name . $user_name_filter . $portal_filter;
					$user_array = get_register_value('user_array', $key_name);
			}

			if (empty($user_array)) {
					$db = DBManagerFactory::getInstance();
					$temp_result = array();
					// Including deleted users for now.
					if (empty($status)) {
							$query = 'SELECT id, first_name, last_name, user_name FROM users WHERE 1=1' . $portal_filter;
					} else {
							$query = "SELECT id, first_name, last_name, user_name from users WHERE status='$status'" . $portal_filter;
					}
					/* BEGIN - SECURITY GROUPS */
					global $current_user, $sugar_config;
					if (!is_admin($current_user) && isset($sugar_config['securitysuite_filter_user_list']) && $sugar_config['securitysuite_filter_user_list'] == true) {
							require_once 'modules/SecurityGroups/SecurityGroup.php';
							$group_where = SecurityGroup::coreGetGroupUsersWhere($current_user->id);
							$query .= ' AND (' . $group_where . ') ';
					}
					/* END - SECURITY GROUPS */
					if (!empty($user_name_filter)) {
							$user_name_filter = $db->quote($user_name_filter);
							$query .= " AND user_name LIKE '$user_name_filter%' ";
					}
					if (!empty($user_id)) {
							$query .= " OR id='{$user_id}'";
					}

					//get the user preference for name formatting, to be used in order by
					$order_by_string = ' user_name ASC ';
					if (!empty($current_user) && !empty($current_user->id)) {
							$formatString = $current_user->getPreference('default_locale_name_format');

							//create the order by string based on position of first and last name in format string
							$order_by_string = ' user_name ASC ';
							$firstNamePos = strpos($formatString, 'f');
							$lastNamePos = strpos($formatString, 'l');
							if ($firstNamePos !== false || $lastNamePos !== false) {
									//its possible for first name to be skipped, check for this
									if ($firstNamePos === false) {
											$order_by_string = 'last_name ASC';
									} else {
											$order_by_string = ($lastNamePos < $firstNamePos) ? 'last_name, first_name ASC' : 'first_name, last_name ASC';
									}
							}
					}

					$query = $query . ' ORDER BY ' . $order_by_string;
					$GLOBALS['log']->debug("get_user_array query: $query");
					$result = $db->query($query, true, 'Error filling in user array: ');

					// Get the id and the name.
					while ($row = $db->fetchByAssoc($result)) {
							if ($use_real_name == true || showFullName()) {
									if (isset($row['last_name'])) { // cn: we will ALWAYS have both first_name and last_name (empty value if blank in db)
											$temp_result[$row['id']] = $locale->getLocaleFormattedName($row['first_name'], $row['last_name']);
									} else {
											$temp_result[$row['id']] = $row['user_name'];
									}
							} else {
									$temp_result[$row['id']] = $row['user_name'];
							}
					}

					if ($add_blank == true) {
						$temp_result[''] = 'Unassigned';
					}

					$user_array = $temp_result;

					if ($from_cache) {
							set_register_value('user_array', $key_name, $temp_result);
					}
			}

			return $user_array;
	}

	function formatDataArrayForWhereInQuery($dataArray)
	{
		if (! $dataArray) return false;

		$explodedDataArray = explode(',', $dataArray);
		$newDataArray = [];

		foreach ($explodedDataArray as $key => $value) {
			array_push($newDataArray, "'{$value}'");
		}

		return implode(', ', $newDataArray);
	}

	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
	
		array_multisort($sort_col, $dir, $arr);
    }
    
    function append_zero($number, $digits = 1)
    {
        $result = $number;
        if(!empty($number)){
            $result = str_pad($number, $digits, '0', STR_PAD_LEFT);
        }

        return $result;
	}
	
	function getUserDateTimeNow()
	{
		global $current_user, $timedate;

		// Retrieve logged user timezone
		$timezone = $timedate->getInstance()->userTimezone();

		// Retrieve logged user date format
		$userDateFormat = $timedate->getInstance()->get_date_format();

		// Retrieve current date based from user timezone
		return Carbon::now($timezone);
	}

	function retrieveUserByRoleSiteDivision($name, $site = null, $division = null)
	{
		$roleFilter = $division ? ['division' => $division, 'name' => $name] : ['name' => $name];

		$aclRolesBean = BeanFactory::getBean('ACLRoles')->retrieve_by_string_fields(
			$roleFilter,
			false,
			true
		);

		if ($aclRolesBean) {
            $userFilter = ($site)
                ? "(users_cstm.site_c LIKE '%^{$site}^%' OR users_cstm.site_c LIKE '%{$site}%') AND users.status = 'Active'"
                : "users.status = 'Active'";

			$userBean = $aclRolesBean->get_linked_beans(
				'users', 'Users', array(), 0, -1, 0,
                $userFilter
			);
		}
		
		return ($userBean != null && count($userBean) > 0) ? $userBean[0] : null;
	}

	function convertDateFormatToLoggedUserFormat($date)
    {
        global $timedate;

        // Retrieve logged user timezone
        $timezone = $timedate->getInstance()->userTimezone();

        // Retrieve logged user date format
        $userDateFormat = $timedate->getInstance()->get_date_format();

        // Convert date format to logged user date format
        return date_format(date_create($date), $userDateFormat);
    }

	// Retrieves all dropdown options and convert array to string for where in condition
	function handleArrayToWhereInFormatAll($array): string
	{
		// Fetch keys of array then implode with comma while wrapping key values with quotes
		return isset($array) && is_array($array) ? implode(', ', array_map(function($string) {
			return "'{$string}'";
		}, array_keys($array))) : '';
	}

	function getOpenSalesStagesForReports()
	{
		global $app_list_strings;

		$salesStages = [];

		foreach ($app_list_strings["sales_stage_dom"] as $key => $value) {
			if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
				$salesStages[$key] = $value;
			}
		}

		return $salesStages;
	}

	function handleAssignmentNotification($bean, $ccUserBeans = [], $customUrl = null)
	{
		global $current_user, $sugar_config, $app_list_strings;

		$moduleName = $app_list_strings['moduleList'][$bean->module_dir];
		$assignedUserBean = BeanFactory::getBean('Users', $bean->assigned_user_id);

		if ($current_user->id == $assignedUserBean->id || ! $assignedUserBean->id) {
			return true;
		}

		$emailObj = new Email();
		$defaults = $emailObj->getSystemDefaultEmail();
		
		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
		$mail->From = $defaults['email'];
		$mail->FromName = $defaults['name'];
		$mail->Subject = "EmpowerCRM Assigned {$moduleName}";

		$customQABanner = $sugar_config['isQA'] ? '<span style="color:red">***This is a test from the Empower QA System***</span>' : '';
		$recordUrl = $customUrl ?? "{$sugar_config['site_url']}/index.php?module=TRI_TechnicalRequestItems&action=DetailView&record={$bean->id}";

		$body = "
			{$customQABanner}

			<p><b>{$current_user->name}</b> has assigned a(n) {$moduleName} to <b>{$assignedUserBean->name}</b>.</p>
			<p>You may <a target='_blank' rel='noopener noreferrer' href='{$recordUrl}'>review this {$moduleName}</a>
		";

		$mail->Body = from_html($body);
		$mail->AddAddress($assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean), $assignedUserBean->name);
		$mail->AddBCC($sugar_config['systemBCCEmailAddress']);
		$mail->isHTML(true);
		$mail->prepForOutbound();

		// Check if notification needs CC recipients
		if (!empty($ccUserBeans)) {
			foreach ($ccUserBeans as $userBean) {
				$mail->addCC($userBean->emailAddress->getPrimaryAddress($userBean));
			}
		}


		$mail->Send();
	}

	function handleSurveyResponseNotification($bean, $ccUserBeans = [], $customUrl = null)
	{
		global $current_user, $sugar_config, $app_list_strings;

		$moduleName = $app_list_strings['moduleList'][$bean->module_dir];
		$assignedUserBean = BeanFactory::getBean('Users', $bean->assigned_user_id);

		if ($current_user->id == $assignedUserBean->id || ! $assignedUserBean->id) {
			return true;
		}

		$emailObj = new Email();
		$defaults = $emailObj->getSystemDefaultEmail();

		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
		$mail->From = $defaults['email'];
		$mail->FromName = $defaults['name'];
		$mail->Subject = "EmpowerCRM Survey Response";

		$customQABanner = $sugar_config['isQA'] ? '<span style="color:red">***This is a test from the Empower QA System***</span>' : '';
		$recordUrl = $customUrl ?? "{$sugar_config['site_url']}/index.php?module=Surveys&action=DetailView&record={$bean->id}";

		$body = "
			{$customQABanner}
			<p>Hi!</p>
			<p>A new response has been submitted to Survey #{$bean->survey_id_number_c} that is assigned to <b>{$assignedUserBean->name}</b>.</p>
			<p>You may <a target='_blank' rel='noopener noreferrer' href='{$recordUrl}'>review this {$moduleName}</a>
		";

		$mail->Body = from_html($body);
		$mail->AddAddress($assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean), $assignedUserBean->name);
		$mail->AddBCC($sugar_config['systemBCCEmailAddress']);
		$mail->isHTML(true);
		$mail->prepForOutbound();

		// Check if notification needs CC recipients
		if (!empty($ccUserBeans)) {
			foreach ($ccUserBeans as $userBean) {
				$mail->addCC($userBean->emailAddress->getPrimaryAddress($userBean));
			}
		}


		$mail->Send();
	}

	// Purpose of this function is to fetch the date_entered value by way of db query since $bean->date_entered is empty
	function handleRetrieveBeanDateEntered($bean)
	{
		global $db, $timedate;

		if (! $bean->id) {
			return;
		}

		// Retrieve logged user timezone
		$timezone = $timedate->getInstance()->userTimezone();
		$query = "SELECT date_entered FROM {$bean->table_name} WHERE id = '{$bean->id}'";

		return Carbon::parse($db->getOne($query))->setTimezone($timezone);
    }
    
	//OnTrack #1240
	function date_sort($a, $b) {
		return strtotime($a) - strtotime($b);
	}

	function custom_mark_deleted($moduleName, $recordId)
	{
		global $db, $current_user, $log;

		$bean = BeanFactory::getBean($moduleName, $recordId);

		if (! $bean->id) {
			$log->fatal("Custom Mark Deleted failed as module[{$moduleName}] bean record id[{$recordId}] does not exist!");
			return true;
		}

        // Direct DB update record to deleted = 1 -- START
        $softDeleteSQL = "UPDATE {$bean->table_name} 
            SET 
                deleted = 1, 
                modified_user_id = '{$current_user->id}', 
                date_modified = NOW() 
            WHERE id = '{$bean->id}' AND deleted = 0;
        ";
        
        $db->query($softDeleteSQL);
        // Direct DB update record to deleted = 1 -- END

        // Codes here are from core mark_deleted function -- START
        // Take the item off the recently viewed lists
        $tracker = new Tracker();
        $tracker->makeInvisibleForAll($bean->id);
        // Codes here are from core mark_deleted function -- END

        // Trigger scheduler job to delete related beans -- START
        $scheduledJob = new SchedulersJob();
        $scheduledJob->name = "Soft Delete Related Beans Job - [{$bean->module_dir}][{$bean->id}]";
        $scheduledJob->assigned_user_id = $current_user->id;
        $scheduledJob->target = "class::SoftDeleteRelatedBeansJob";
        $scheduledJob->requeue = true;
        $scheduledJob->retry_count = 5;
        $scheduledJob->data = json_encode([
            'record_id' => $bean->id,
            'module_name' => $bean->module_dir,
            'user_id' => $current_user->id
        ]);

		require_once 'include/SugarQueue/SugarJobQueue.php';

        $queue = new SugarJobQueue();
        $queue->submitJob($scheduledJob);
        // Trigger scheduler job to delete related beans -- END
	}

	/***
	 * Returns all (String) fields that are audited true
	 */
	function getAuditedFields($bean)
	{
		global $log;
		$auditedFields = [];

            foreach($bean->field_defs as $field => $def) {

                if (array_key_exists('audited', $def) && $def['audited'] === true) {
                    if ($def['type'] == 'relate' && $def['source'] == 'non-db') {
						$auditedFields[$def['id_name']] = $bean->field_defs[$def['id_name']];
                    } else {
                        $auditedFields[$field] = $def;
                    }
                }
            }

            return array_keys($auditedFields);
	}

	/**
	 * Helper function to iterate thru the TR audited = 1 fields and check if before and after values are changed
	 * @param Bean Technical Request
	 * @return Array of boolean value(s)
	 */
	function beanFieldValueChangeChecker($bean, $auditedOnly = false)
	{
		if ($bean && $bean->id) {
			$valueIsUpdated = []; // array of boolean values supplied when auditable field values are updated
			$beanAuditableFields = getAuditedFields($bean); // retrieves TR fields that are audited => 1

			if (isset($bean->rel_fields_before_value) && is_array($bean->rel_fields_before_value) && count($bean->rel_fields_before_value) > 0) {
				if (isset($beanAuditableFields) && is_array($beanAuditableFields) && count($beanAuditableFields) > 0) {
					foreach ($beanAuditableFields as $field){
						if (array_key_exists($field, $bean->rel_fields_before_value) && $bean->{$field} != $bean->rel_fields_before_value[$field]) {
							// if it's a relate field, compare the before id values and the after id values
							$valueIsUpdated[$field]= true;
							continue;
						} else if (!array_key_exists($field, $bean->rel_fields_before_value) && $bean->fetched_row[$field] != $bean->{$field}) {
							// if a regular or custom field that is NOT  in the rel_fields_before_value AND value has been updated
							$valueIsUpdated[$field]= true;
							continue;
						} else {
							$valueIsUpdated[$field]= false;
						}
					}

					return $valueIsUpdated;
				}
			}
		}

		return [false]; // return array with one value: FALSE; indicating bean has no audited = true field defs
	}

	/**
	 * Custom function that utilizes core db function getDataChanges($bean) from DBManager.php;
	 * Checks if bean field values including relate fields are updated on SAVE.
	 * @param SugarBean $bean (current module being saved)
	 * @return Array (associative) of boolean values: TRUE = field has been updated and FALSE if otherwise [ ...,field_name => BOOL value ]
	 * @author Glai Obido
	 */
	function handleBeanFieldValueChangeChecker($bean)
	{
		global $log;
		$db = DBManagerFactory::getInstance();

		$fieldChanges = $db->getDataChanges($bean); // Made use of a Core code function that retrieves field values that are changed (DBManager.php)
		$excludeFieldsForChecking = ['date_modified', 'modified_by_name', 'id', 'id_c', 'deleted']; // since these fields are always logged as updated even when user changes nothing and clicks save


		$valuesAreUpdatedBool = array_map(function($field) use ($bean, $excludeFieldsForChecking, $log) {
			$fieldName = $field['field_name'];
			if (in_array($fieldName, $excludeFieldsForChecking)) {
				$result[$fieldName] = 'not updated';
				$result = false;
			} elseif ($bean->field_defs[$fieldName]['type'] == 'relate' && array_key_exists($fieldName, $bean->rel_fields_before_value)) {
				$relateFieldId = $bean->field_defs[$fieldName]['id_name'];
				$result = ($bean->rel_fields_before_value[$relateFieldId] != $bean->{$relateFieldId})
					? true
					: false;
			} else {
				$result = true; // default since all fields in this array are checked as updated to begin with
			}

			return $result;
		}, $fieldChanges);

		// Code gap fix: check for $bean relate fields values where it's not included in the $fieldChanges result
		foreach ($bean->rel_fields_before_value as $fieldName => $beforeValue) {
			if ($bean->field_defs[$fieldName]['type'] == 'relate') {
				$relateFieldId = $bean->field_defs[$fieldName]['id_name'];
				$result = ($bean->rel_fields_before_value[$relateFieldId] != $bean->{$relateFieldId})
					? true
					: false;
				$valuesAreUpdatedBool[$relateFieldId] = $result;
			}
		}

		return $valuesAreUpdatedBool;
	}

	function customResinTypeSortedList()
	{
		global $app_list_strings;

        // Remove blank, DRY COLOR, and COMPOUND from list
        $arrayList = array_filter($app_list_strings['resin_type_list'], function($key) {
            return (! in_array($key, ['', '00', '01']));
        }, ARRAY_FILTER_USE_KEY);

        // Sort array by value
        asort($arrayList);

        // Recreate blank, DRY COLOR, and COMPOUND to another list
        $topOfArrayList[''] = $app_list_strings['resin_type_list'][''];
        $topOfArrayList['01'] = $app_list_strings['resin_type_list']['01'];
        $topOfArrayList['00'] = $app_list_strings['resin_type_list']['00'];

		// Merge arrays so that blank, DRY COLOR, and COMPOUND are top of list while rest of options are sorted ASC based on value
		// Had to use array union ($array1 + $array2) as opposed to array_merge as array union keeps the keys while merge overwrites it to 0, 1, 2,...
        $mergedArrayList = $topOfArrayList + $arrayList;

        // Set resin_type_list to new merge array to force dropdown list to use custom sorted list
        $app_list_strings['resin_type_list'] = $mergedArrayList;
	}

	// Custom function to check if file exists and confirm if file is not in get_included_files before triggering require_once
	function handleVerifyBeforeRequire($filePath)
	{
		$formattedPathname = realpath(dirname($filePath)) . '/' . basename($filePath);

		if (file_exists($formattedPathname) && (! in_array($formattedPathname, get_included_files()))) {
			require_once $formattedPathname;
		}
	}

	function checkUserRoleIs($role = [], $user = null)
	{
		global $current_user, $db, $log;

		$userRoles = [];
		if (empty($role)) {
			return [];
		}

		$user = isset($user) ? $user : $current_user;

		$user->load_relationship('aclroles');
		$loggedUserRoleIds = $user->aclroles->get();

		$implodedIds = implode(',', $loggedUserRoleIds);
		$implodeRoles = implode(',', $role);

		$roleIdsWhereIn = formatDataArrayForWhereInQuery($implodedIds);
		$roleNamesWhereIn = formatDataArrayForWhereInQuery($implodeRoles);

		$query = "SELECT name FROM acl_roles WHERE acl_roles.name IN ({$roleNamesWhereIn}) AND acl_roles.id IN ({$roleIdsWhereIn}) AND deleted = 0";
		// $result = $db->getOne($query);
		$result = $db->query($query);

		while ($row = $db->fetchByAssoc($result)) {
			$userRoles[] = $row['name'];
		}
		// return ($result) ? true : false;
		return $userRoles;

	}

	function retrieveUserBySecurityGroupTypeDivision($name, $type, $site = null, $division = null)
	{
		// Need to disable security groups filter as non-admin users are not able to access all security groups which results to not being able to fetch the user bean
		$_REQUEST['disable_security_groups_filter'] = true;

        $where = "securitygroups.name LIKE '%{$name}%' AND securitygroups_cstm.type_c = '{$type}'";

        $where = (isset($site) && $site)
            ? "{$where} AND securitygroups_cstm.site_c = '{$site}'"
            : $where;

		$where = (isset($division) && $division)
			? "{$where} AND securitygroups_cstm.division_c = '{$division}'"
			: $where;

		$securityGroupBean = BeanFactory::getBean('SecurityGroups');
		$securityGroupBeanList = $securityGroupBean->get_full_list(
			"securitygroups.date_entered ASC",
			$where,
			false,
			0
		);

		if (isset($securityGroupBeanList) && count($securityGroupBeanList) > 0) {
			$securityGroupBean = $securityGroupBeanList[0];
			$userBean = ($securityGroupBean && $securityGroupBean->id)
				? BeanFactory::getBean('Users', $securityGroupBean->assigned_user_id)
				: null;
		}

		return ($userBean && $userBean->id) ? $userBean : null;
	}

	function retrieveUserListByACLRole($nameArray, $site = null, $division = null, $currentValue = null): array
    {
        $userListArray = ['' => ''];

        $implodeNames = implode(',', $nameArray);
        $nameArrayWhereIn = formatDataArrayForWhereInQuery($implodeNames);

        $aclRoleBeanList = BeanFactory::getBean('ACLRoles')->get_full_list(
            '',
            "name IN ({$nameArrayWhereIn})",
            false,
            0
        );

        if (isset($aclRoleBeanList) && count($aclRoleBeanList) > 0) {
            $userFilter = ($site)
                ? "(users_cstm.site_c LIKE '%^{$site}^%' OR users_cstm.site_c LIKE '%{$site}%') AND users.status = 'Active'"
                : "users.status = 'Active'";

            $userFilter = ($division)
                ? "{$userFilter} AND division_c = '{$division}'"
                : $userFilter;

            $currentValueBean = BeanFactory::getBean('Users', $currentValue);

            if ($currentValueBean && $currentValueBean->id) {
                $userListArray[$currentValueBean->id] = $currentValueBean->full_name;
            }

            foreach ($aclRoleBeanList as $aclRole) {
                $userBeanList = $aclRole->get_linked_beans(
                    'users', 'Users', array(), 0, -1, 0,
                    $userFilter
                );

                if (isset($userBeanList) && count($userBeanList) > 0) {
                    foreach ($userBeanList as $user) {
                        $userListArray[$user->id] = $user->full_name;
                    }
                }
            }
        }

        asort($userListArray);

        return $userListArray;
    }

    // Used on return_authorization_number_c enum custom function and action_filter_return_authorization_by
    function retrieveReturnAuthorizationByUserList(): array
    {
        $usersList = [];
        // List will fetch Quality Control Manager and Plant Manager by way of Security Groups while Executive will be fetched by way of ACL Roles
        $secGroupNames = ['Quality Control Manager', 'Plant Manager'];

        foreach ($secGroupNames as $secGroupName) {
            $secGroupUsers = retrieveUsersBySecurityGroupTypeDivision($secGroupName, 'CAPAWorkingGroup', $_REQUEST['site'], $_REQUEST['division'], $_REQUEST['return_authorization_by']);
            $usersList = array_merge($usersList, $secGroupUsers);
        }

        // Data Array will then be merged and sorted by value
        $roleUserList = retrieveUserListByACLRole(['Executive'], $_REQUEST['site'], $_REQUEST['division'], $_REQUEST['return_authorization_by']);
        $usersList = array_merge($usersList, $roleUserList);

        // sort array by value with blank as first option
        asort($usersList);

        return $usersList;
    }

    function str_ireplace_first($search, $replace, $subject) {
        $pos = stripos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

	function get_dynamic_documents_related_to()
	{
		global $log, $app_list_strings;
        $result = array('' => '');


        $documentBean = BeanFactory::getBean('Documents');
        $fields = $documentBean->get_linked_fields();

        foreach ($fields as $link => $def) {
            $exclude = ['created_by_link', 'modified_user_link', 'assigned_user_link', 'SecurityGroups', 'revisions', 'contracts', 'so_savingopportunities_documents', 'bugs'];

            if (!in_array($link, $exclude) && !array_key_exists('side', $def)) {

                $module = array_key_exists('module', $def) ? $def['module'] : ucfirst($link);

				if (array_key_exists($module, $app_list_strings['moduleList'])) {
					$result[$module] = $app_list_strings['moduleList'][$module];

				}
            }

        }
		asort($result);
        return $result;

	}

	// Used to retrieve load_relationship name value between two modules
    // Codes pulled from Api\V8\BeanDecorator\BeanManager
    // Duplicated from core API code to cater empty $linkFieldName to return empty string instead of DomainException
    function customGetLinkedFieldName(\SugarBean $sourceBean, \SugarBean $relatedBean)
    {
        $linkedFields = $sourceBean->get_linked_fields();
        $relationship = \Relationship::retrieve_by_modules(
            $sourceBean->module_name,
            $relatedBean->module_name,
            $sourceBean->db
        );

        $linkFieldName = '';

        foreach ($linkedFields as $linkedField) {
            if ($linkedField['relationship'] === $relationship) {
                $linkFieldName = $linkedField['name'];
            }
        }

        return $linkFieldName;
    }

    // function to retrieve multiple retrieveUserBySecurityGroupTypeDivision()
    function retrieveUsersBySecurityGroupTypeDivision($name, $type, $site = null, $division = null, $currentValue = null)
    {
        global $current_user;
        $userList = [];
        $division = $division ?? $current_user->division_c;

        $secGroupFilter = ($site)
            ? "securitygroups_cstm.site_c = '{$site}' AND securitygroups_cstm.division_c = '{$division}'"
            : "securitygroups_cstm.division_c = '{$division}'";

        $securityGroupBeanList = BeanFactory::getBean('SecurityGroups')->get_full_list(
            '',
            "securitygroups.name LIKE '%{$name}%' AND securitygroups_cstm.type_c = '{$type}' AND {$secGroupFilter}",
            false,
            0
        );

        if (isset($securityGroupBeanList) && count($securityGroupBeanList) > 0) {
            foreach ($securityGroupBeanList as $securityGroupBean) {

                $currentValueBean = BeanFactory::getBean('Users', $currentValue);

                if ($currentValueBean && $currentValueBean->id) {
                    $userList[$currentValueBean->id] = $currentValueBean->full_name;
                }

                $userBean = BeanFactory::getBean('Users', $securityGroupBean->assigned_user_id);
                $userList[$userBean->id] = $userBean->full_name;
            }
        }



        return $userList;
    }

    function handleCheckIfTableExists($tableName)
    {
        global $sugar_config, $db;

        $dbName = $sugar_config['dbconfig']['db_name'];

        $query = "SELECT count(*) FROM information_schema.tables WHERE table_schema = '{$dbName}' AND table_name = '{$tableName}' LIMIT 1";
        $result = $db->getOne($query);

        return ($result) ? true : false;
    }
    
    /*
     * Ontrack #1705: Custom ListView Status Sorting: to sort status according to dropdown list order
     * Applied to modules: Customer Issues, Regulatory Requests, OnTrack, Product Master, Technical Requests
     * To apply to another module: add to $moduleDetails Array
     * */
    function customStatusSorting($listQueryResult = [])
    {
        global $app_list_strings, $log;
        
        $caseWhenString = 'CASE ';
        $module = $_REQUEST['module'];
        $moduleDetails = [
            'Cases' => array(
                'statusField' => 'cases.status',
                'listStringKey' => 'status_list',
                'requestSortColumnKey' => 'Cases2_CASE_ORDER_BY',
                'initialSortStatusList' => true
            ),
            'RRQ_RegulatoryRequests' => array(
                'statusField' => 'rrq_regulatoryrequests_cstm.status_c',
                'listStringKey' => 'reg_req_statuses',
                'requestSortColumnKey' => 'RRQ_RegulatoryRequests2_RRQ_REGULATORYREQUESTS_ORDER_BY',
                'initialSortStatusList' => true
            ),
            'OTR_OnTrack' => array(
                'statusField' => 'otr_ontrack.status',
                'listStringKey' => 'bug_status_dom',
                'requestSortColumnKey' => 'OTR_OnTrack2_OTR_ONTRACK_ORDER_BY',
                'initialSortStatusList' => false
            ),
            'AOS_Products' => array(
                'statusField' => 'aos_products_cstm.status_c',
                'listStringKey' => 'aos_products_status_list',
                'requestSortColumnKey' => 'AOS_Products2_AOS_PRODUCTS_ORDER_BY',
                'initialSortStatusList' => false
            ),
            'TR_TechnicalRequests' => array(
                'statusField' => 'tr_technicalrequests.status',
                'listStringKey' => 'tr_technicalrequests_status_list',
                'requestSortColumnKey' => 'TR_TechnicalRequests2_TR_TECHNICALREQUESTS_ORDER_BY',
                'initialSortStatusList' => false
            )
        ];
        
        if (is_array($listQueryResult) && !empty($_REQUEST['lvso']) && isset($_REQUEST[$moduleDetails[$module]['requestSortColumnKey']])) {
            $statusList = $app_list_strings[$moduleDetails[$module]['listStringKey']];
            
            if ($moduleDetails[$module]['initialSortStatusList']) {
                asort($statusList);
            }
            
            $count = 0;
            foreach($statusList as $key => $value) {
                $caseWhenString .= " WHEN {$moduleDetails[$module]['statusField']} = '{$key}' THEN {$count} ";
                $count++;
            }

            $caseWhenString .= " ELSE {$moduleDetails[$module]['statusField']} END AS custom_status_number ";
            $listQueryResult['select'] .= ", {$caseWhenString} ";
            $listQueryResult['order_by'] = " ORDER BY cast(custom_status_number AS UNSIGNED INTEGER) {$_REQUEST['lvso']} ";
        }
        
        
        return $listQueryResult;
       
        
    }
    
    function retrieveProductCategoryDropdown($bean)
    {
        global $app_list_strings, $log, $focus;
        
        $productCategoryList = get_product_categories();
        
        if (!empty($bean->id) && in_array($bean->object_name, ['AOS_Products', 'TR_TechnicalRequests'])) {
            $productCategoryId = $bean->product_category_c;
            
            // Special case: if Bean is AOS Products, check the bean->stage if it is NOT Production, then set product category to ''
            if ($bean->object_name == 'AOS_Products' && strtolower($bean->type) != "production") {
                $productCategoryId = '';
            }
            
            // if $producCategoryId is not in the array of keys for $productCategoryList, add it to the list
            if (!empty($productCategoryId) && !array_key_exists($productCategoryId, $productCategoryList)) {
                $productCategoryBean = BeanFactory::getBean('AOS_Product_Categories', $productCategoryId);
                $productCategoryList[$productCategoryId] = $productCategoryBean->name;
            }
        }
       
        return $productCategoryList;
    }
?>