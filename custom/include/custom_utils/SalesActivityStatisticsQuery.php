<?php

	class SalesActivityStatisticsQuery
	{
    public function salesActivityStatisticsDataQuery() {
      global $db, $current_user;

      $db = DBManagerFactory::getInstance();

      $tableList = SalesActivityStatisticsQuery::retrieveTableListToQuery();
      $lastTableListData = $tableList ? end($tableList) : '';

      $sql = "SELECT TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) AS user, ";

      $assignedToArray = $_REQUEST['assigned_to_basic'] ?? array();
      $dateFrom = $_REQUEST['date_from_basic'] ?? '';
      $dateTo = $_REQUEST['date_to_basic'] ?? '';

      foreach ($tableList as $key => $value) {
        $append = " ";

        if($value != $lastTableListData) {
          $append = ", ";
        }

        $sql .= "(SELECT count(*) FROM ".$value." WHERE ".$value.".assigned_user_id = users.id AND ".$value.".deleted = 0) AS ".$value. $append;
      }

      $sql .= "FROM users
               WHERE users.deleted = 0
                AND users.status = 'Active' ";
      
      if($assignedToArray) {
        $arrayUserIDs = array();

        foreach ($assignedToArray as $key => $value) {
          array_push($arrayUserIDs, "'" . $value . "'");
        }

        $stringUserIDs = implode(', ', $arrayUserIDs);

        $sql .= "AND users.id IN (".$stringUserIDs.")";
      }
      
      $result = $db->query($sql); 
      $array = [];

      while($row = $db->fetchByAssoc($result)) {
        array_push($array, $row);
      }

      return $array;
      // $sql = "SELECT
      //           users.id,
      //           TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) AS user,
      //           (SELECT count(*) FROM leads WHERE leads.assigned_user_id = users.id AND leads.deleted = 0) AS leads,
      //           (SELECT count(*) FROM accounts WHERE accounts.assigned_user_id = users.id  AND accounts.deleted = 0) AS accounts,
      //           (SELECT count(*) FROM contacts WHERE contacts.assigned_user_id = users.id AND contacts.deleted = 0) AS contacts,
      //           (SELECT count(*) FROM cases WHERE cases.assigned_user_id = users.id AND cases.deleted = 0) AS cases,
      //           (SELECT count(*) FROM opportunities WHERE opportunities.assigned_user_id = users.id AND opportunities.deleted = 0) AS opportunities,
      //           (SELECT count(*) FROM tr_technicalrequests WHERE tr_technicalrequests.assigned_user_id = users.id AND tr_technicalrequests.deleted = 0) AS technical_requests,
      //           (SELECT count(*) FROM project WHERE project.assigned_user_id = users.id AND project.deleted = 0) AS projects,
      //           (SELECT count(*) FROM notes WHERE notes.assigned_user_id = users.id AND notes.deleted = 0) AS notes,
      //           (SELECT count(*) FROM calls WHERE calls.assigned_user_id = users.id AND calls.deleted = 0) AS calls,
      //           (SELECT count(*) FROM meetings WHERE meetings.assigned_user_id = users.id AND meetings.deleted = 0) AS appointments,
      //           (SELECT count(*) FROM tasks WHERE tasks.assigned_user_id = users.id AND tasks.deleted = 0) AS tasks,
      //           (SELECT count(*) FROM emails WHERE emails.assigned_user_id = users.id AND emails.deleted = 0) AS emails
      //         FROM users
      //         WHERE users.deleted = 0
      //           AND users.status = 'Active' ";
      
      // $sql .= "AND users.id IN ('66662b63-3252-75c2-7aca-5b3672345dbc', 'b0702afe-4329-5a08-1431-5af9ddd396a8')";

    }

    public function test() {
      return SalesActivityStatisticsQuery::retrieveTableListToQuery();
    }

    public function retrieveTableListToQuery() {
      global $sugar_config, $db;
      
      $db = DBManagerFactory::getInstance();
      $dbName = $sugar_config['dbconfig']['db_name'];
  
      $arrayOfTableNames = [
        "'leads'", "'accounts'", "'contacts'", "'cases'", "'opportunities'", "'tr_technicalrequests'", 
        "'project'", "'notes'", "'calls'", "'meetings'", "'tasks'", "'emails'"
      ];
  
      $stringTableNames = implode(', ', $arrayOfTableNames);
  
      $sql = "SELECT table_name FROM information_schema.tables
              WHERE table_schema = '".$dbName."'
              AND table_name IN (".$stringTableNames.")";
      
      $result = $db->query($sql);
      $array = [];

      while($row = $db->fetchByAssoc($result)) {
        array_push($array, $row['table_name']);
      }

      return $array;
      
    }
  }
?>