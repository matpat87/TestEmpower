<?php

	class SalesActivityReportQuery
	{
		public function get_select_query()
		{
      global $app_list_strings;

			return <<<EOF
SELECT DISTINCT(activity.id) AS 'id',
activity.module_name AS 'activity_name_c',
CONCAT(activity.type, ' (', activity.status, ')') AS ' status_c',
CONCAT(u.first_name, ' ', u.last_name) AS 'assigned_to_name_c',
activity.date AS 'date_start_c',
activity.name AS 'name',
CASE
  WHEN activity.parent_type = 'Leads'
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      CONCAT(leads.account_name, ' (', accounts.account_type, ')'),
      "N/A"
    ) AS activity_account_name
    FROM leads 
    LEFT JOIN accounts
      ON accounts.id = leads.account_id
    WHERE activity.parent_id = leads.id 
      AND leads.deleted = 0
      AND accounts.deleted = 0
  )
  WHEN activity.parent_type = 'Contacts'
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      CONCAT(accounts.name, ' (', accounts.account_type, ')'),
      "N/A"
    ) AS activity_account_name
    FROM accounts
    LEFT JOIN accounts_contacts 
      ON accounts.id = accounts_contacts.account_id
    WHERE accounts_contacts.contact_id = activity.parent_id
      AND accounts.deleted = 0
      AND accounts_contacts.deleted = 0
      ORDER BY accounts_contacts.date_modified DESC
      LIMIT 1
  )
  WHEN activity.parent_type = 'Opportunities'
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      CONCAT(accounts.name, ' (', accounts.account_type, ')'),
      "N/A"
    ) AS activity_account_name
    FROM accounts
    LEFT JOIN accounts_opportunities 
      ON accounts.id = accounts_opportunities.account_id
    WHERE accounts_opportunities.opportunity_id = activity.parent_id
      AND accounts.deleted = 0
      AND accounts_opportunities.deleted = 0
  )
  WHEN activity.parent_type = 'Cases'
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      CONCAT(accounts.name, ' (', accounts.account_type, ')'),
      "N/A"
    ) AS activity_account_name
    FROM accounts
    LEFT JOIN cases 
      ON accounts.id = cases.account_id
    WHERE cases.id = activity.parent_id
      AND accounts.deleted = 0
      AND cases.deleted = 0
  )
  WHEN activity.parent_type = 'Accounts' 
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      CONCAT(accounts.name, ' (', accounts.account_type, ')'),
      "N/A"
    ) AS activity_account_name
    FROM accounts
    WHERE activity.parent_id = accounts.id
      AND deleted = 0
  )
  ELSE "N/A"
END AS 'account_name_c',
a.shipping_address_city AS 'shipping_address_city_c', 
a.shipping_address_state AS 'shipping_address_state_c', 
CASE 
  WHEN activity.parent_type = 'Leads' 
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      TRIM(CONCAT(CONCAT("{$app_list_strings['moduleList']['Leads']}", " - "), CONCAT(first_name, ' ', last_name))),
      "N/A"
    ) AS related_to_name
    FROM leads 
    WHERE deleted = 0 
    AND activity.parent_id = leads.id
  )
  WHEN activity.parent_type = 'Contacts' 
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      TRIM(CONCAT(CONCAT("{$app_list_strings['moduleList']['Contacts']}", " - "), CONCAT(first_name, ' ', last_name))),
      "N/A"
    ) AS related_to_name
    FROM contacts 
    WHERE deleted = 0 
    AND activity.parent_id = contacts.id
  )
  WHEN activity.parent_type = 'Opportunities' 
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      TRIM(CONCAT(CONCAT("{$app_list_strings['moduleList']['Opportunities']}", " - "), name)),
      "N/A"
    ) AS related_to_name
    FROM opportunities 
    WHERE deleted = 0 
    AND activity.parent_id = opportunities.id
  )
  WHEN activity.parent_type = 'Cases'
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      TRIM(CONCAT(CONCAT("{$app_list_strings['moduleList']['Cases']}", " - "), name)),
      "N/A"
    ) AS related_to_name
    FROM cases 
    WHERE deleted = 0 
    AND activity.parent_id = cases.id
  )
  WHEN activity.parent_type = 'Accounts' 
  THEN (
    SELECT IF(
      activity.parent_id != '' AND activity.parent_id IS NOT NULL,
      TRIM(CONCAT(CONCAT("{$app_list_strings['moduleList']['Accounts']}", " - "), name)),
      "N/A"
    ) AS related_to_name
    FROM accounts 
    WHERE deleted = 0 
    AND activity.parent_id = accounts.id
  )
  ELSE "N/A"
END AS 'related_to_c',
activity.highlights_c,
activity.description,
activity.type_c_nondb,
activity.management_update,
activity.status AS 'activity_status_nondb' 
EOF;
		}


		public function get_from_query()
		{
			return <<<EOF
FROM
  (
    (SELECT 
      id,
      NAME,
      'Call' AS 'type',
      'Calls' AS 'module_name',
      "N/A" AS 'type_c_nondb',
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      highlights_c,
      calls_cstm.management_update_c as management_update,
      sales_activity_c AS 'description'
    FROM
      calls 
    LEFT JOIN calls_cstm
      ON calls.id = calls_cstm.id_c
    WHERE deleted = 0) 
    UNION
    (SELECT 
      id,
      NAME,
      'Meeting' AS 'type',
      'Meetings' AS 'module_name',
      meeting_type_c AS 'type_c_nondb',
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      highlights_c,
      meetings_cstm.management_update_c as management_update,
      sales_activity_c AS 'description'
    FROM
      meetings 
    LEFT JOIN meetings_cstm
      ON meetings.id = meetings_cstm.id_c
    WHERE deleted = 0) 
    UNION
    (SELECT 
      id,
      NAME,
      'Task' AS 'type',
      'Tasks' AS 'module_name',
      "N/A" AS 'type_c_nondb',
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      highlights_c,
      tasks_cstm.management_update_c as management_update,
      description
    FROM
      tasks 
    LEFT JOIN tasks_cstm
      ON tasks.id = tasks_cstm.id_c
    WHERE deleted = 0) 
    UNION
    (SELECT 
      e.id,
      e.NAME,
      'Email' AS 'type',
      'Emails' AS 'module_name',
      "N/A" AS 'type_c_nondb',
      e.STATUS,
      e.assigned_user_id,
      e.date_entered AS 'date',
      e.parent_id,
      e.parent_type,
      emails_cstm.management_update_c as management_update,
      highlights_c,
      CASE
        WHEN LOCATE('From:', et.description) > 0 THEN SUBSTRING_INDEX(et.description, "From:", 1)
        WHEN LOCATE('----', et.description) > 0 THEN SUBSTRING_INDEX(et.description, "----", 1)
        WHEN LOCATE('____', et.description) > 0 THEN SUBSTRING_INDEX(et.description, "____", 1)
        WHEN LOCATE('<http', et.description) > 0 THEN SUBSTRING_INDEX(et.description, "<http", 1)
        ELSE et.description
      END
    FROM emails as e
    LEFT JOIN emails_cstm
      ON e.id = emails_cstm.id_c
    INNER join emails_text as et
      ON et.deleted = 0
        AND et.email_id = e.id
    WHERE e.deleted = 0)
  ) AS activity 
  LEFT JOIN leads AS l 
    ON l.id = activity.parent_id 
    AND activity.parent_type = 'Leads' 
  LEFT JOIN opportunities AS o 
    ON o.id = activity.parent_id 
    AND activity.parent_type = 'Opportunities' 
  LEFT JOIN calls_contacts AS cc 
    ON cc.call_id = activity.id 
  LEFT JOIN meetings_contacts AS mc 
    ON mc.meeting_id = activity.id 
  LEFT JOIN contacts AS c 
    ON c.id = cc.contact_id 
    OR c.id = mc.contact_id
  LEFT JOIN cases AS cs
    ON cs.id = activity.parent_id
    AND activity.parent_type = 'Cases'
EOF;
		}

    public function retrieveActivityStatusList() {
      global $app_list_strings;

      $appointmentStatusList = $app_list_strings['meeting_status_dom'];
      $callStatusList = $app_list_strings['call_status_dom'];
      $taskStatusList = $app_list_strings['task_status_dom'];
      $emailStatusList = [
        'draft'  => 'Draft - Email',
        'read'   => 'Read - Email',
        'sent'   => 'Sent - Email',
        'unread' => 'Unread - Email',
      ];

      foreach ($appointmentStatusList as $key => $value) {
        $appointmentStatusList[$key] = "{$value} - Meeting or Call";
      }

      foreach ($callStatusList as $key => $value) {
        $callStatusList[$key] = "{$value} - Meeting or Call";
      }

      foreach ($taskStatusList as $key => $value) {
        $taskStatusList[$key] = "{$value} - Task";
      }

      $activitiesStatusList = array_merge($appointmentStatusList, $callStatusList, $emailStatusList, $taskStatusList);
      return $activitiesStatusList;
    }


    public function retrieveActivityTypeList()
    {
      global $app_list_strings, $log;

      $customList = [];
      $activityTypeList = $app_list_strings['activity_type_list'];
      $meetingTypeList = $app_list_strings['meeting_type_list'];
      
      foreach ($activityTypeList as $key => $type) {
        if ($key == 'Meeting') {
          foreach ($meetingTypeList as $meetingTypeKey => $meetingTypeValue) {
            if ($meetingTypeKey != "") {
              $customList["{$key}_{$meetingTypeKey}"] = "Meeting - {$meetingTypeValue}";

            }
          }
          continue;
        } else {
          $customList[$key] = $type;

        }

      }
      return $customList;
    }
	}

  

?>