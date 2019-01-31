<?php
	
	class AccountActivityReportQuery
	{
		public function get_select_query()
		{
			return <<<EOF
SELECT activity.id,
CONCAT(activity.type, ' (', activity.status, ')') AS ' custom_status',
CONCAT(u.first_name, ' ', u.last_name) AS 'custom_assigned_to',
DATE_FORMAT(activity.date,'%m/%d/%Y') AS 'date_start_c',
activity.name AS 'name',
a.name AS 'custom_account',
activity.parent_type AS 'custom_related_to',
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
      et.description
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
	}

?>