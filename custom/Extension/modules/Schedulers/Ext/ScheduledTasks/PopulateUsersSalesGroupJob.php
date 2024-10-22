<?php

class PopulateUsersSalesGroupJob implements RunnableSchedulerJob
{
  	public function run($arguments)
  	{
		global $app_list_strings, $db, $log;

		$sql = "SELECT users.id, users_cstm.sales_group_c FROM users
				LEFT JOIN users_cstm
					ON users.id = users_cstm.id_c
				WHERE users.deleted = 0
					AND (users_cstm.sales_group_c != '' AND users_cstm.sales_group_c IS NOT NULL)";
		
		$result = $db->query($sql);

		$log->fatal("Populate Users Sales Group - START");

		while ($row = $db->fetchByAssoc($result)) {
			$userBean = BeanFactory::getBean('Users', $row['id']);
			$salesGroupUserBean = BeanFactory::getBean('Users');
			
			if (isset($userBean) && $userBean->id) {
				switch ($userBean->sales_group_c) {
					case 'MD':
						// No user needed here but added for data reference that 'MD' is one of the values assigned to some users
						break;
					case 'TeamGroselak':
						$salesGroupUserBean = $salesGroupUserBean->retrieve_by_string_fields(['user_name' => 'MGROSELAK'], false, true);
						break;
					case 'TeamGitto':
						$salesGroupUserBean = $salesGroupUserBean->retrieve_by_string_fields(['user_name' => 'GGITTO'], false, true);
						break;
					case 'TeamTyler':
						$salesGroupUserBean = $salesGroupUserBean->retrieve_by_string_fields(['user_name' => 'CTYLER'], false, true);
						break;
					default:
						break;
				}

				if ($salesGroupUserBean && $salesGroupUserBean->id) {
					$log->fatal("Username: {$userBean->user_name}");
					$log->fatal("Old Value: {$userBean->sales_group_c}");
					$log->fatal("New Value: {$salesGroupUserBean->id}");
					
					$userBean->sales_group_c = $salesGroupUserBean->id;
					$userBean->save(false);
				}
			}
		}

		$log->fatal("Populate Users Sales Group - END");

		return true;
  	}

	public function setJob(SchedulersJob $job)
	{
		$this->job = $job;
	}
}