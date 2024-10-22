<?php

require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

class CasesBeforeSaveHook 
{


    function status_update_append_before_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        $status = "";
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");

        if ($bean->status_update_c != "") {
            $conjunction = "<br/>";
           

            $status = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
            $status .= '<div style="font-size: 12pt; line-height: 1">'. nl2br($bean->status_update_c) .'</div>';

            // $this->send_email($bean);

            if($bean->status_update_log_c != "") {
                $status .= "$conjunction " . $bean->status_update_log_c;
            }

            $bean->status_update_log_c = $status;
            // $bean->status_update_c = "";
        } else {
            // On edit, the field becomes blank by default and triggers an audit change when saved as empty if it previously had a value
            // Need to set it on the backend to set value based on fetched_row to prevent incorrect audit log
            $bean->status_update_c = $bean->fetched_row['status_update_c'];
        }
    }

    protected function send_email($customerIssueBean)
    {
        global $app_list_strings, $log, $sugar_config;

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $recordURL = $sugar_config['site_url'] . '/index.php?module=Cases&action=DetailView&record=' . $customerIssueBean->id;
        $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
        $recipients = array();

        // CAPA COORDINATOR(S)
        $capaCoordinators = CustomerIssuesHelper::getWorkgroupUsers($customerIssueBean, 'CAPACoordinator');

        // Sales Person(s)
        $salesPersons = CustomerIssuesHelper::getWorkgroupUsers($customerIssueBean, 'SalesPerson');

        $recipients = array_merge($capaCoordinators, $salesPersons);
        

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];

        $mail->Subject = 'EmpowerCRM Customer Issue Update';

        $mail->Body = from_html(
            "
            {$customQABanner}
            
            Hi,
            <br><br>

            There is a new Status update for <a href='{$recordURL}'>Customer Issue #".$customerIssueBean->case_number."</a>
            <br><br>

            <p>Status: ".$app_list_strings['status_list'][$customerIssueBean->status]."<br>
            Due Date: {$customerIssuesBean->due_date_c}<br>
            Site: {$app_list_strings['site_list'][$customerIssueBean->site_c]}<br>
            Source: {$app_list_strings['source_list'][$customerIssueBean->source_c]}<br>
            Type: {$app_list_strings['ci_type_list'][$customerIssueBean->ci_type_c]}<br>
            Status Update:<br>
            {$customerIssueBean->status_update_c}</p>


            Thanks,
            <br>
            {$defaults['name']}
            <br>"
        );

        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
        $mail->prepForOutbound();

        foreach ($recipients as $key => $recipient) {
            $mail->AddAddress($recipient->emailAddress->getPrimaryAddress($recipient), $recipient->name);
        }

        $mail->Send();
    }

    public function set_status_close_on_verify(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['InternalAuditor']) ?? null;

        // When current user is the Site Internal Auditor (of the issue)
        if (($bean->fetched_row['verified_status_c'] != $bean->verified_status_c) && $bean->verified_status_c == 'Approved' && isset($capaUserBean) && $capaUserBean[0]->id == $current_user->id) {
           $bean->status = 'Closed';
           $bean->close_date_c = Carbon::now(); // when status is Closed also set the closed_date_c of the Customer Issue
        } else {
            // Do not Verify issue
            $bean->verified_status_c = $bean->verified_status_c;
        }

        
    }
    
    public function handleDateClosed(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        
        if ($bean->fetched_row['status'] != $bean->status && $bean->status == 'Closed') {
            $bean->close_date_c = Carbon::now();
        }
    }

    public function handleAssignedUserOnRejectedAuditStatus(&$bean, $event, $arguments)
    {
        global $log, $db;

        $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['DepartmentManager']) ?? null;

        if (!empty($capaUserBean) && $bean->fetched_row['verified_status_c'] != $bean->verified_status_c && $bean->verified_status_c == 'Rejected') {
            // Set assigned user to the Customer Issue's Department Manager
            $assignedUserID = (is_array($capaUserBean)) ? $capaUserBean[0]->id : $capaUserBean->id;
            $bean->assigned_user_id = $assignedUserID;
            
            // $updateSQL = "UPDATE cases SET assigned_user_id = '{$assignedUserID}' WHERE id = '{$bean->id}' ";
            // $db->query($updateSQL);
            $bean->status = 'InProcess';

        }
    }
  
}

?>