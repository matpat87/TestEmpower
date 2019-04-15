<?php

	class SalesActivityStatisticsQuery
	{
    public function get_select_query()
		{
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

      return $sql;
		}


		public function get_from_query()
		{
      global $current_user;

      $sql .= " FROM users LEFT JOIN users_cstm ON users.id = users_cstm.id_c WHERE users.deleted = 0 AND users.status = 'Active' ";
      $sql .= $this->filterResultsQuery($sql);

      return $sql;
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

    public function filterResultsQuery($sql) {
      
      // Filter Assigned To - Start
      $arrayUserIDs = [];
      $whereUserIDs = $_REQUEST['assigned_to_basic'];

      if($whereUserIDs) {
        foreach ($whereUserIDs as $key => $value) {
          array_push($arrayUserIDs, "'" . $value . "'");
        }

        $stringUserIDs = implode(', ', $arrayUserIDs);
      }

      if(!$current_user->is_admin) {
        if(!$stringUserIDs) {
          $sql .= " AND users.id = '".$current_user->id."'";
        } else {
          $sql .= " AND users.id IN (".$stringUserIDs.")";
        }
      } else {
        if($stringUserIDs) {
          $sql .= " AND users.id IN (".$stringUserIDs.")";
        }
      }
      // Filter Assigned To - End

      return $sql;
    }
  }
?>