<?php

	class SalesActivityStatisticsQuery
	{
    public function get_select_query()
		{
      $tableList = SalesActivityStatisticsQuery::retrieveTableListToQuery();
      $lastTableListData = $tableList ? end($tableList) : '';

      $sql = "SELECT TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) AS user_non_db, ";

      foreach ($tableList as $key => $value) {
        $append = " ";

        if($value != $lastTableListData) {
          $append = ", ";
        }

        $sql .= "(SELECT count(*) FROM ".$value." WHERE ".$value.".assigned_user_id = users.id AND ".$value.".deleted = 0) AS ".$value. '_non_db' . $append;
      }

      return $sql;
		}


		public function get_from_query()
		{
      $sql .= " FROM users LEFT JOIN users_cstm ON users.id = users_cstm.id_c WHERE users.deleted = 0 AND users.status = 'Active' ";
      $filteredSQL = $this->filterResultsQuery($sql);

      return $filteredSQL;
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
      
      global $current_user;

      // Filter Division - Start
      $arrayDivisions = [];
      $whereDivisions = $_REQUEST['division_c_basic'];
      
      if($whereDivisions && !in_array("All", $whereDivisions)) {
        foreach ($whereDivisions as $key => $value) {
          array_push($arrayDivisions, "'" . $value . "'");
        }
      } else {
        $dropdownDivisionList = getDivisionsForReports();
          
        foreach ($dropdownDivisionList as $key => $value) {
          if($value != 'All') {
            array_push($arrayDivisions, "'" . $key . "'");
          }
        }
      }
      
      $stringDivisions = implode(', ', $arrayDivisions);

      if($stringDivisions) {
        $sql .= " AND users_cstm.division_c IN (".$stringDivisions.")";
      }

      // Filter Division - End

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

      // Filter Department - Start
      $arrayDepartments = [];
      $whereDepartments = $_REQUEST['department_basic'];
      
      if($whereDepartments && !in_array("All", $whereDepartments)) {
        foreach ($whereDepartments as $key => $value) {
          array_push($arrayDepartments, "'" . $value . "'");
        }
      } else {
        $dropdownDepartmentList = getDepartmentsForReports();
          
        foreach ($dropdownDepartmentList as $key => $value) {
          if($value != 'All') {
            array_push($arrayDepartments, "'" . $key . "'");
          }
        }
      }
      
      $stringDepartments = implode(', ', $arrayDepartments);

      if($stringDepartments) {
        $sql .= " AND users.department IN (".$stringDepartments.")";
      }

      // Filter Department - End

      // Filter Sales Group - Start
      $arraySalesGroups = [];
      $whereSalesGroups = $_REQUEST['sales_group_c_basic'];
      
      if($whereSalesGroups && !in_array("All", $whereSalesGroups)) {
        foreach ($whereSalesGroups as $key => $value) {
          array_push($arraySalesGroups, "'" . $value . "'");
        }
      } else {
        $dropdownSalesGroupList = getSalesGroupForReports();

        foreach ($dropdownSalesGroupList as $key => $value) {
          if($value != 'All') {
            array_push($arraySalesGroups, "'" . $key . "'");
          }
        }
      }
      
      $stringSalesGroups = implode(', ', $arraySalesGroups);
      if($stringSalesGroups) {
        $sql .= " AND users_cstm.sales_group_c IN (".$stringSalesGroups.")";
      }
      // Filter Sales Group - End

      return $sql;
    }
  }
?>