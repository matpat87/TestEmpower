<?php

	class SalesActivityReportQuery
	{
		public function get_select_query()
		{
			return <<<EOF
SELECT activity.id,
CONCAT(activity.type, ' (', activity.status, ')') AS ' status_c',
CONCAT(u.first_name, ' ', u.last_name) AS 'assigned_to_name_c',
activity.date 'date_start_c',
activity.name AS 'name',
a.name AS 'account_name_c',
activity.parent_type AS 'related_to_c',
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
      id,
      NAME,
      'Email' AS 'type',
      STATUS,
      assigned_user_id,
      date_entered AS 'date',
      '' AS parent_id,
      '' AS parent_type,
      '' as description
    FROM
      emails 
    WHERE deleted = 0)
  ) AS activity 
  LEFT JOIN accounts AS a 
    ON a.id = activity.parent_id 
    AND activity.parent_type = 'Accounts' 
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