<?php

class AccountHelper {
	function retrieveCurrentYTDBudget($bean) {
		$currentMonth = date('n');
		$currentYTDBudget = 0;
		
		for ($i=1 ; $i <= $currentMonth; $i++) {
			$field = 'cur_year_month' . $i . '_c';
			$currentYTDBudget += $bean->$field;
		}

		return $currentYTDBudget;
	}

	function retrieveCurrentMonthBudget($bean) {
		$currentMonth = date('n');
		$field = 'cur_year_month' . $currentMonth . '_c';
		$currentMonthBudget = $bean->$field;
		return $currentMonthBudget;
	}

    function retrieve_total_color_spend($account_id){
        $result = 0;
        $member_accounts = AccountHelper::retrieve_member_accounts($account_id);

        foreach($member_accounts as $account){
            $annual_revenue_potential_c = $account['annual_revenue_potential_c'] ?? 0;
            $result += $annual_revenue_potential_c;
        }

        return $result;
    }

    function retrieve_member_accounts($account_id){
        $result = array();
        global $db;

        $sql = "select a.id,
                    ac.annual_revenue_potential_c
                from accounts a
                left join accounts_cstm ac
                    on ac.id_c = a.id
                where a.parent_id = '{$account_id}' ";
        $data = $db->query($sql);

        while($row = $db->fetchByAssoc($data)){
            $result[] = $row;
        }

        return $result;
    }
}