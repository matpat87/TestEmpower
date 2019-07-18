<?php

	class SalesActivityReportQuery
	{
		public function get_select_query()
		{
			return <<<EOF
SELECT activity.id,
CONCAT(activity.type, ' (', activity.status, ')') AS ' status_c',
CONCAT(u.first_name, ' ', u.last_name) AS 'assigned_to_name_c',
activity.date AS 'date_start_c',
activity.name AS 'name',
IF(a.name != '', a.name, 'N/A') AS 'account_name_c',
a.shipping_address_city AS 'shipping_address_city_c', 
a.shipping_address_state AS 'shipping_address_state_c', 
IF(activity.parent_type != '', activity.parent_type, 'N/A') AS 'related_to_c',
activity.description 
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
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      description
    FROM
      calls 
    WHERE deleted = 0) 
    UNION
    (SELECT 
      id,
      NAME,
      'Appointment' AS 'type',
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      description
    FROM
      meetings 
    WHERE deleted = 0) 
    UNION
    (SELECT 
      id,
      NAME,
      'Task' AS 'type',
      STATUS,
      assigned_user_id,
      date_start AS 'date',
      parent_id,
      parent_type,
      description
    FROM
      tasks 
    WHERE deleted = 0) 
    UNION
    (SELECT 
      e.id,
      e.NAME,
      'Email' AS 'type',
      e.STATUS,
      e.assigned_user_id,
      e.date_entered AS 'date',
      e.parent_id,
      e.parent_type,
      SUBSTRING_INDEX(et.description, "From:", 1)
    FROM emails as e
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
EOF;
		}

    public function retrieveActivityStatusList() {
      global $app_list_strings;

      $appointmentStatusList = $app_list_strings['meeting_status_dom'];
      $callStatusList = $app_list_strings['call_status_dom'];
      $taskStatusList = $app_list_strings['task_status_dom'];
      $emailStatusList = [
        'draft'  => 'Email - Draft',
        'read'   => 'Email - Read',
        'sent'   => 'Email - Sent',
        'unread' => 'Email - Unread',
      ];

      foreach ($appointmentStatusList as $key => $value) {
        $appointmentStatusList[$key] = 'Appointment / Call - '. $value;
      }

      foreach ($callStatusList as $key => $value) {
        $callStatusList[$key] = 'Appointment / Call - '. $value;
      }

      foreach ($taskStatusList as $key => $value) {
        $taskStatusList[$key] = 'Task - '. $value;
      }

      $activitiesStatusList = array_merge($appointmentStatusList, $callStatusList, $emailStatusList, $taskStatusList);
      return $activitiesStatusList;
    }
	}

?>