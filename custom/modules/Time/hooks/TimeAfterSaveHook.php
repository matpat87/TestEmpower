<?php
	require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

  	class TimeAfterSaveHook
  	{
		public function saveOntrackActualHours($bean, $event, $arguments)
		{
			global $log, $db;

			if ($bean->parent_type == 'OTR_OnTrack') {
				$currentHrs = retrieveActualHours($bean->parent_id, $bean->parent_type);
				$sqlString = "UPDATE otr_ontrack_cstm SET actual_hours_worked_c = {$currentHrs} WHERE id_c='{$bean->parent_id}'";

				$db->query($sqlString);
			}
		}

		public function handleEmailNotification(&$bean, $event, $arguments)
		{
			global $sugar_config, $app_list_strings, $timedate;

			if ($bean->fetched_row['id']) {
				return;
			}

			$assignedUserBean = BeanFactory::getBean('Users', $bean->assigned_user_id);

			if (! $assignedUserBean->id) {
				return;
			}

			$reportsToBean = BeanFactory::getBean('Users', $assignedUserBean->reports_to_id);
			$reportsToBeanEmailAddress = $reportsToBean->emailAddress->getPrimaryAddress($reportsToBean);

			if (! $reportsToBean->id || ! $reportsToBeanEmailAddress) {
				return;
			}

			$parentBean = BeanFactory::getBean($bean->parent_type, $bean->parent_id);

			if (! $parentBean->id) {
				return;
			}

			$customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
			
			// Retrieve logged user timezone
			$timezone = $timedate->getInstance()->userTimezone();

			// Retrieve logged user date format
			$userDateFormat = $timedate->getInstance()->get_date_format();
			
			$formattedDateWorked = Carbon::parse($bean->date_worked)->format($userDateFormat);

			$moduleName = ($parentBean->module_dir == 'OTR_OnTrack') ? 'OnTrack' : $app_list_strings['moduleList'][$parentBean->module_dir];
			$dateEntered = handleRetrieveBeanDateEntered($bean);
			$formattedDateEntered = Carbon::parse($dateEntered)->format($userDateFormat);

			$timezone = $timedate->getInstance()->userTimezone();
			$dateModified = Carbon::parse($bean->date_modified)->setTimezone($timezone);
			$formattedDateModified = Carbon::parse($dateModified)->format($userDateFormat);

			$formattedDescription = nl2br($bean->description);
			
			$formattedRelatedModule = ($parentBean->module_dir == 'OTR_OnTrack') 
				? "{$app_list_strings['module_dropdown_list'][$parentBean->module_c]} - {$parentBean->name}"
				: "{$moduleName} - {$parentBean->name}";
				
			return sendEmail(
				"EmpowerCRM Time - Logged Entry for {$formattedRelatedModule}",
				"
					{$customQABanner}

					<p>
						<p><b>{$assignedUserBean->name}</b> has logged Time entry for {$formattedRelatedModule}.</p>
					</p>

					<p>
						Work Performed: {$bean->name}<br>
						Time: {$bean->time}<br>
						Related To: <a target='_blank' rel='noopener noreferrer' href='{$sugar_config['site_url']}/index.php?module={$parentBean->module_dir}&action=DetailView&record={$parentBean->id}'>{$formattedRelatedModule}</a><br>
						Date Worked: {$formattedDateWorked}<br>
						Worked By: {$assignedUserBean->name}<br>
						Date Created: {$formattedDateEntered}<br>
						Date Modified: {$formattedDateModified}<br>
						Description:<br>{$formattedDescription}
					</p>

					<p>You may <a target='_blank' rel='noopener noreferrer' href='{$sugar_config['site_url']}/index.php?module={$bean->module_dir}&action=DetailView&record={$bean->id}'>review this Time</a>.</p>
				",
				[ $reportsToBeanEmailAddress ]
			);
		}
	}
?>