<?php

	class BudgetReportQuery
	{
		public function get_select_query()
		{
			return <<<EOF
        SELECT  accounts.name AS 'account_name_non_db', accounts_cstm.cust_num_c AS 'customer_number_non_db', 
                accounts_cstm.cur_year_month1_c AS 'january_non_db', accounts_cstm.cur_year_month2_c AS 'february_non_db',
                accounts_cstm.cur_year_month3_c AS 'march_non_db', accounts_cstm.cur_year_month4_c AS 'april_non_db',
                accounts_cstm.cur_year_month5_c AS 'may_non_db', accounts_cstm.cur_year_month6_c AS 'june_non_db',
                accounts_cstm.cur_year_month7_c AS 'july_non_db', accounts_cstm.cur_year_month8_c AS 'august_non_db',
                accounts_cstm.cur_year_month9_c AS 'september_non_db', accounts_cstm.cur_year_month10_c AS 'october_non_db',
                accounts_cstm.cur_year_month11_c AS 'november_non_db', accounts_cstm.cur_year_month12_c AS 'december_non_db',
                COALESCE(SUM(
                  accounts_cstm.cur_year_month1_c + accounts_cstm.cur_year_month2_c + accounts_cstm.cur_year_month3_c + 
                  accounts_cstm.cur_year_month4_c + accounts_cstm.cur_year_month5_c + accounts_cstm.cur_year_month6_c +
                  accounts_cstm.cur_year_month7_c + accounts_cstm.cur_year_month8_c + accounts_cstm.cur_year_month9_c +
                  accounts_cstm.cur_year_month10_c + accounts_cstm.cur_year_month11_c + accounts_cstm.cur_year_month12_c
                ), 0) AS 'total_budget_non_db'
EOF;
		}


		public function get_from_query()
		{
			return <<<EOF
      FROM accounts
      LEFT JOIN accounts_cstm
        ON accounts.id = accounts_cstm.id_c
  
EOF;
		}

    public function retrieve_sales_group_user_list() {
      global $db, $current_user;

      $db = DBManagerFactory::getInstance();

      $sql = "SELECT users.id AS userID, CONCAT(first_name, ' ', last_name) AS userName FROM users WHERE employee_status = 'Active' AND deleted = 0";
      
      if(!$current_user->isAdmin()) {
        $sql .= " AND id = '".$current_user->id."'";
      }

      $sql .= " ORDER BY userName ASC";

      $result = $db->query($sql);
      $array = [];

      while($row = $db->fetchByAssoc($result)) {
        $array[$row['userID']] = $row['userName'];
      }

      return $array;
    }

    public function budgetReportSumQuery($data) {
      global $db, $current_user;

      $db = DBManagerFactory::getInstance();

      $sql = "SELECT  COALESCE(SUM(accounts_cstm.cur_year_month1_c)) AS 'january_non_db', COALESCE(SUM(accounts_cstm.cur_year_month2_c)) AS 'february_non_db',
                      COALESCE(SUM(accounts_cstm.cur_year_month3_c)) AS 'march_non_db', COALESCE(SUM(accounts_cstm.cur_year_month4_c)) AS 'april_non_db',
                      COALESCE(SUM(accounts_cstm.cur_year_month5_c)) AS 'may_non_db', COALESCE(SUM(accounts_cstm.cur_year_month6_c)) AS 'june_non_db',
                      COALESCE(SUM(accounts_cstm.cur_year_month7_c)) AS 'july_non_db', COALESCE(SUM(accounts_cstm.cur_year_month8_c)) AS 'august_non_db',
                      COALESCE(SUM(accounts_cstm.cur_year_month9_c)) AS 'september_non_db', COALESCE(SUM(accounts_cstm.cur_year_month10_c)) AS 'october_non_db',
                      COALESCE(SUM(accounts_cstm.cur_year_month11_c)) AS 'november_non_db', COALESCE(SUM(accounts_cstm.cur_year_month12_c)) AS 'december_non_db',
                      COALESCE(SUM(
                        accounts_cstm.cur_year_month1_c + accounts_cstm.cur_year_month2_c + accounts_cstm.cur_year_month3_c + 
                        accounts_cstm.cur_year_month4_c + accounts_cstm.cur_year_month5_c + accounts_cstm.cur_year_month6_c +
                        accounts_cstm.cur_year_month7_c + accounts_cstm.cur_year_month8_c + accounts_cstm.cur_year_month9_c +
                        accounts_cstm.cur_year_month10_c + accounts_cstm.cur_year_month11_c + accounts_cstm.cur_year_month12_c
                      ), 0) AS 'total_budget_non_db'
            FROM accounts
            LEFT JOIN accounts_cstm
              ON accounts.id = accounts_cstm.id_c";

      $arrayUserIDs = [];
      $where = $_REQUEST['assigned_user_id_basic'];
      if($where) {
        foreach ($where as $key => $value) {
           array_push($arrayUserIDs, "'" . $value . "'");
        }

        $stringUserIDs = implode(', ', $arrayUserIDs);
        
        $sql .= " WHERE accounts.assigned_user_id IN (".$stringUserIDs.")";
      } else {
        $customUserList = BudgetReportQuery::retrieve_sales_group_user_list();
        
        foreach ($customUserList as $key => $value) {
           array_push($arrayUserIDs, "'" . $key . "'");
        }

        $stringUserIDs = implode(', ', $arrayUserIDs);

        $sql .= " WHERE accounts.assigned_user_id IN (".$stringUserIDs.")";
      }

      $result = $db->query($sql);
      $row = $db->fetchByAssoc($result);
      
      $arraySum = [];

      foreach ($row as $key => $value) {
        array_push($arraySum, number_format($value, 2));
      }

      return $arraySum;
    }
	}

?>