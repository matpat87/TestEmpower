<?php

include_once('include/SugarPHPMailer.php');
include_once('include/utils/db_utils.php');

require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

 /**
  * We add the method name to the $job_strings array.
  * This is the method that jobs for this scheduler will call.
  */
 $job_strings[] = 'customerIssueNoActivityNotification';

 /**
  * Example scheduled job to change any 'Planned' meetings older than a month
  * to 'Not Held'.
  * @return bool
  */

function customerIssueNoActivityNotification()
{

	global $db, $app_list_strings, $log;
   $threeDaysInactiveStatus = ['Draft', 'New', 'Approved', 'InProcess', 'CAPAReview', 'CAPAApproved', 'AwaitingInformation']; // customer issues of this status that have no activity for 30 days
   $thirtyDaysInactiveStatus = ['CAPAComplete']; // customer issues of this status that have no activity for 30 days
   $customerIssuesSql = "
        SELECT 
            *
        FROM
            cases
                LEFT JOIN
            cases_cstm ON cases.id = cases_cstm.id_c
        WHERE
            cases.deleted = 0
   ";
    
   $customerIssuesResult = $db->query($customerIssuesSql);
   $counter = 0;

    while($row = $db->fetchByAssoc($customerIssuesResult)) {
      
        $bean = BeanFactory::getBean('Cases', $row['id']);
        $dateDiff = Carbon::parse($row['date_modified'])->diffInDays(Carbon::today());
       

        if (in_array($bean->status, $threeDaysInactiveStatus) && $dateDiff >= 3) {
            // $lastNotificationDateDiff = isset($row['no_activity_email_date_c'])  && $row['no_activity_email_date_c'] != null 
            //     ? Carbon::parse($row['no_activity_email_date_c'])->diffInDays(Carbon::today())
            //     : 3; -- deprecated code 03/21/2022
            
            sendNotification($bean); // notify assigned user 
            updateNoActivityDate($bean);
            
        }
        
        if (in_array($bean->status, $thirtyDaysInactiveStatus) && $dateDiff >= 30) {
            // $lastNotificationDateDiff = isset($row['no_activity_email_date_c'])  && $row['no_activity_email_date_c'] != null 
            //     ? Carbon::parse($row['no_activity_email_date_c'])->diffInDays(Carbon::today())
            //     : 30; -- deprecated code 03/21/2022

            // notify assigned user 
            sendNotification($bean);
            updateNoActivityDate($bean);
        }
      
    }
   
   return true;
}

function sendNotification($customerIssueBean)
{
    global $app_list_strings, $log, $sugar_config, $current_user;
    
    $emailObj = new Email();
    $defaults = $emailObj->getSystemDefaultEmail();

    $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
    $recordURL = $sugar_config['site_url'] . '/index.php?module=Cases&action=DetailView&record=' . $customerIssueBean->id;
    $userBean = BeanFactory::getBean('Users', $customerIssueBean->assigned_user_id);
    $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $customerIssueBean->ci_customeritems_cases_1ci_customeritems_ida);
    

    $mail = new SugarPHPMailer();
    $mail->setMailerForSystem();
    $mail->From = $defaults['email'];
    $mail->FromName = $defaults['name'];
    
    $mail->AddAddress($userBean->emailAddress->getPrimaryAddress($userBean), $userBean->name);

    $mail->Subject = "EmpowerCRM Customer Issue #{$customerIssueBean->case_number} - {$customerIssueBean->name} - Reminder Notification";
    $mail->Body = from_html(
        "
        {$customQABanner}

        Hi {$userBean->name},
        <br><br>
     
        Customer Issue  <a href='{$recordURL}'>#{$customerIssueBean->case_number}</a> is waiting for your updates, please logon to Empower and provide an update or move it along to the next status if you are complete with your portion of the CAPA.
        <br><br>

        <p>
        Issue: {$customerIssueBean->name}<br>
        Site: {$app_list_strings['site_list'][$customerIssueBean->site_c]}<br>
        Status: ".$app_list_strings['status_list'][$customerIssueBean->status]."<br>
        Account Name: {$customerIssueBean->account_name}<br>
        Contact: {$customerIssueBean->contact_created_by_name}<br>
        Due Date: {$customerIssueBean->due_date_c}<br>
        Department: {$app_list_strings['ci_department_list'][$customerIssueBean->ci_department_c]}<br>
        Severity: {$app_list_strings['ci_severity_list'][$customerIssueBean->priority]}<br>
        </p>

        If you have received this email in error please contact Admin for assistance.<br><br>

        Thanks,
        <br>
        {$defaults['name']}
        <br>"
    );

    $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
    $mail->isHTML(true);
    $mail->prepForOutbound();

    $mail->Send();
    // $log->fatal("MAILED: {$customerIssueBean->id} Status: {$customerIssueBean->status}");
}

function updateNoActivityDate($customerIssueBean)
{
    global $log, $db;

    $date = Carbon::today()->toDateString();
    $updateSQL = "UPDATE cases_cstm SET no_activity_email_date_c = '{$date}' WHERE id_c = '{$customerIssueBean->id}' ";
    $db->query($updateSQL);
}