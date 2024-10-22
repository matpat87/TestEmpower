<?php
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

class EmailNotificationHelper
{
    public static function notifyOnItemComplete(
        $distroItemBean, 
        $recipients = [], 
        $ccRecipients = [], 
        $customDataBeans = [])
    {
        global $app_list_strings, $log, $sugar_config, $current_user;
    
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

        $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
        
        
        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        
        self::attachMailRecipients($mail, $recipients);

        if (array_key_exists('trBean', $customDataBeans) && $customDataBeans['trBean']->id) {
            
            $recordURL = "<a href='{$sugar_config['site_url']}/index.php?module={$customDataBeans['trBean']->module_name}&action=DetailView&record={$customDataBeans['trBean']->id}'>{$sugar_config['site_url']}/index.php?module={$customDataBeans['trBean']->module_name}&action=DetailView&record={$customDataBeans['trBean']->id}</a>";

            // SUBJECT
            $distroItemName = DistributionHelper::GetDistributionItemLabel($distroItemBean->distribution_item_c);

            $trBeanNumber = $customDataBeans['trBean']->technicalrequests_number_c;
            $trStatusValue = TechnicalRequestHelper::get_status($customDataBeans['trBean']->approval_stage)[$customDataBeans['trBean']->status];
            $submittedBy = $customDataBeans['trBean']->created_by_name ?? $current_user->name;
            $dateEntered = handleRetrieveBeanDateEntered($customDataBeans['trBean']);
            $customDateEnteredFormat = $dateEntered ? date("Y-m-d", strtotime($dateEntered)) : date("Y-m-d");

            // Needed since $bean->assigned_user_name still shows the old assigned user
            $newAssignedUserBean = BeanFactory::getBean('Users', $customDataBeans['trBean']->assigned_user_id);
            $newAssignedUserName = $newAssignedUserBean ? $newAssignedUserBean->name : '';

            $techRequestUpdates =  $customDataBeans['trBean']->technical_request_update ? nl2br($customDataBeans['trBean']->technical_request_update) : '';

            $mail->Subject = "EmpowerCRM Technical Request #{$trBeanNumber} - {$distroItemName} Complete";
            
            $techRequestUpdatesBodyContent = $techRequestUpdates 
            ? "<tr><td><br></td></tr>
            <tr>
                <td>Technical Request Update<td>
                <td>{$techRequestUpdates}<td>
            </tr>" : "";

            $tableInformation = "
                <table>
                    <tbody>
                        <tr>
                            <td>TR #<td>
                            <td>{$customDataBeans['trBean']->technicalrequests_number_c}<td>
                        </tr>
    
                        <tr>
                            <td>Version #<td>
                            <td>{$customDataBeans['trBean']->version_c}<td>
                        </tr>
    
                        <tr>
                            <td>Product Name<td>
                            <td>{$customDataBeans['trBean']->name}<td>
                        </tr>
    
                        <tr>
                            <td>Type<td>
                            <td>{$app_list_strings['tr_technicalrequests_type_dom'][$customDataBeans['trBean']->type]}<td>
                        </tr>
    
                        <tr>
                            <td>Site<td>
                            <td>{$app_list_strings['lab_site_list'][$customDataBeans['trBean']->site]}<td>
                        </tr>
    
                        <tr>
                            <td>Stage<td>
                            <td>{$app_list_strings['approval_stage_list'][$customDataBeans['trBean']->approval_stage]}<td>
                        </tr>
    
                        <tr>
                            <td>Status<td>
                            <td>{$trStatusValue}<td>
                        </tr>
    
                        <tr>
                            <td>Account<td>
                            <td>{$customDataBeans['trBean']->tr_technicalrequests_accounts_name}<td>
                        </tr>
    
                        <tr>
                            <td>Opportunity<td>
                            <td>{$customDataBeans['trBean']->tr_technicalrequests_opportunities_name}<td>
                        </tr>
    
                        <tr>
                            <td>Required Completion Date<td>
                            <td>{$customDataBeans['trBean']->req_completion_date_c}<td>
                        </tr>
    
                        <tr>
                            <td>Submitted By<td>
                            <td>{$submittedBy}<td>
                        </tr>
    
                        <tr>
                            <td>Submitted Date<td>
                            <td>{$customDateEnteredFormat}<td>
                        </tr>
    
                        <tr>
                            <td>Assigned To<td>
                            <td>{$newAssignedUserName}<td>
                        </tr>
    
                        {$techRequestUpdatesBodyContent}
                    </tbody>
                </table>
                <br>
            ";
        }


        $body = "
            {$customQABanner}
            
            Hello,
            <br><br>
            The Technical Request has been updated by {$current_user->name}.<br>
            <br><br>
            {$tableInformation}

            Click here to access the record: {$recordURL}
            <br><br>
            Thanks,
            <br>
            {$mail->FromName}
            <br>
        ";

        $mail->Body = from_html($body);
        
        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
        $mail->prepForOutbound();
        $mail->Send();
    }

    private function attachMailRecipients($mail, $recipients)
    {
        if (count($recipients) > 0) {
            foreach ($recipients as $userBean) {
                $mail->AddAddress($userBean->emailAddress->getPrimaryAddress($userBean), $userBean->name);
            }
        }

        return $mail;
    }
}