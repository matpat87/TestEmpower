<?php
  require_once('custom/include/Carbon/src/Carbon/Carbon.php');
  use Carbon\Carbon;
  
	class SalesActivityStatisticsQuery
	{
    public function get_select_query()
		{
      global $log;

      $tableList = SalesActivityStatisticsQuery::retrieveTableListToQuery();
      $lastTableListData = $tableList ? end($tableList) : '';
      
      $dateFrom = (isset($_REQUEST['date_from_basic']) && $_REQUEST['date_from_basic']) 
        ? Carbon::parse($_REQUEST['date_from_basic'])->format('Y-m-d') 
        : '';

      $dateTo = (isset($_REQUEST['date_to_basic']) && $_REQUEST['date_to_basic']) 
        ? Carbon::parse($_REQUEST['date_to_basic'])->format('Y-m-d') 
        : '';

      $sql = "SELECT TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) AS user_non_db, ";

      foreach ($tableList as $key => $table) {
        $append = " ";

        if($table != $lastTableListData) {
          $append = ", ";
        }
        
        switch ($table) {
          case 'leads':
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
              {$this->selectCountAuditField($table, ['status'], $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'accounts':
          case 'contacts':
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'cases':
            $additionalAndConditionForStatus = "AND {$table}_audit.before_value_string = 'Draft' AND {$table}_audit.after_value_string = 'New'";

            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
              {$this->selectCountAuditField($table, ['status'], $dateFrom, $dateTo, $additionalAndConditionForStatus)}
              {$this->selectCountAuditField($table, ['status_update_c'], $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'opportunities':
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
              {$this->selectCountAuditField($table, ['sales_stage', 'status_c', 'next_step_temp_c'], $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'tr_technicalrequests':
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
              {$this->selectCountAuditField($table, ['approval_stage', 'status', 'technical_request_update'], $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'calls':
          case 'meetings':
          case 'tasks':            
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
              {$this->selectCountAuditField($table, ['status'], $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'notes':
            $additionalAndConditionForParentTypeEmails = "AND {$table}.description <> '' AND {$table}.description IS NOT NULL AND {$table}.parent_type = 'Emails'";
            $additionalAndConditionForParentTypeNotEmails = "AND {$table}.parent_type <> 'Emails'";

            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo, $additionalAndConditionForParentTypeEmails)}
              {$this->selectCountCreated($table, $dateFrom, $dateTo, $additionalAndConditionForParentTypeNotEmails, true)}
            ) AS {$table}_non_db {$append}";
            break;
          case 'emails':
            $sql .= "(
              {$this->selectCountCreated($table, $dateFrom, $dateTo)}
            ) AS {$table}_non_db {$append}";
            break;
          default:
            break;
        }
      }

      return $sql;
		}


		public function get_from_query()
		{
  
      // $sql .= " FROM users LEFT JOIN users_cstm ON users.id = users_cstm.id_c WHERE users.deleted = 0 AND users.status = 'Active' ";
      $sql .= " FROM users LEFT JOIN users_cstm ON users.id = users_cstm.id_c WHERE users.deleted = 0 ";
      $filteredSQL = $this->filterResultsQuery($sql);

      return $filteredSQL;
    }

    public function retrieveTableListToQuery() {
      global $sugar_config, $db;
      
      $db = DBManagerFactory::getInstance();
      $dbName = $sugar_config['dbconfig']['db_name'];
  
      $arrayOfTableNames = [
        "'leads'", "'accounts'", "'contacts'", "'cases'", "'opportunities'", "'tr_technicalrequests'", 
        "'notes'", "'calls'", "'meetings'", "'tasks'", "'emails'"
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
      } else {
        $usersDropdownList = getUserRepresentativesForReports();

        foreach ($usersDropdownList as $key => $value) {
          array_push($arrayUserIDs, "'" . $key . "'");
        }
      }

      $stringUserIDs = implode(', ', $arrayUserIDs);

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

    public function filterDates($table, $columnName, $greaterThanOrEqualTo, $dateFromOrTo)
    {
      return "
        AND DATE_FORMAT({$table}.{$columnName}, '%Y-%m-%d') {$greaterThanOrEqualTo} IF('{$dateFromOrTo}' <> '', '{$dateFromOrTo}', DATE_FORMAT({$table}.{$columnName}, '%Y-%m-%d'))
      ";
    }

    public function selectCountCreated($table, $dateFrom, $dateTo, $additionalAndCondition = '', $appendPlusSign = false)
    {
      $plus = ($appendPlusSign) ? '+' : '';

      return "
        {$plus}
        SUM(
          (
            SELECT COUNT({$table}.id) FROM {$table} 
            WHERE {$table}.deleted = 0 
              AND {$table}.created_by = users.id
              {$additionalAndCondition}
              {$this->filterDates($table, 'date_entered', '>=', $dateFrom)}
              {$this->filterDates($table, 'date_entered', '<=', $dateTo)}
          )
        )
      ";
    }
    
    public function selectCountAuditField($table, $fieldsArray, $dateFrom, $dateTo, $additionalAndCondition = '')
    { 
      $formattedFieldsArray = [];

      foreach ($fieldsArray as $key => $value) {
        array_push($formattedFieldsArray, "'{$value}'");
      }

      $implodedFieldsArray = implode(', ', $formattedFieldsArray);

      return "
        +
        SUM(
          (
            SELECT COUNT({$table}.id) FROM {$table} 
            INNER JOIN {$table}_audit
              ON {$table}.id = {$table}_audit.parent_id
            WHERE {$table}.deleted = 0 
              AND {$table}_audit.created_by = users.id
              AND {$table}_audit.field_name IN ({$implodedFieldsArray})
              {$additionalAndCondition}
              {$this->filterDates("{$table}_audit", 'date_created', '>=', $dateFrom)}
              {$this->filterDates("{$table}_audit", 'date_created', '<=', $dateTo)}
          )
        )
      ";
    }

    public function selectCountActivitiesWithAuditField($table, $fieldName, $dateFrom, $dateTo, $additionalAndCondition = '')
    {
      $activities = ['calls', 'tasks', 'meetings', 'emails', 'notes'];

      $activityCountWithAudit = " ";

      if (in_array($table, ['leads', 'accounts', 'contacts', 'cases', 'opportunities', 'tr_technicalrequests'])) {
        foreach ($activities as $activity) {
          $activityCountWithAudit .= "
            +
            SUM(
              (
                SELECT COUNT({$activity}.id) FROM {$activity}
                INNER JOIN {$table}
                  ON {$table}.id = {$activity}.parent_id
                  AND {$table}.deleted = 0
                WHERE {$activity}.deleted = 0 
                  AND {$activity}.created_by = users.id
                  {$this->filterDates($activity, 'date_entered', '>=', $dateFrom)}
                  {$this->filterDates($activity, 'date_entered', '<=', $dateTo)}
              )
            )
            +
            SUM(
              (
                SELECT COUNT({$activity}.id) FROM {$activity}
                INNER JOIN {$table}
                  ON {$table}.id = {$activity}.parent_id
                  AND {$table}.deleted = 0
                INNER JOIN {$activity}_audit
                  ON {$activity}.id = {$activity}_audit.parent_id
                WHERE {$activity}.deleted = 0 
                  AND {$activity}_audit.created_by = users.id
                  AND {$activity}_audit.field_name = '{$fieldName}'
                  {$additionalAndCondition}
                  {$this->filterDates("{$activity}_audit", 'date_created', '>=', $dateFrom)}
                  {$this->filterDates("{$activity}_audit", 'date_created', '<=', $dateTo)}
              )
            )
          ";
        }
      }

      return $activityCountWithAudit;
    }
  }
?>