<?php

class CustomMailNotification
{
    public $recipient_bean;
    public $module_name;
    public $fields_to_include = []; // array of bean fields to display on Email Body
    public $mail_subject = '';
    public $record_url = '';
    public $bean;
    public $for_assigned_user_only = true; // Boolean if email recipient is only the module assigned user
    public $recipients = []; // Array should be array of User Beans
    

    function __construct(&$bean, $fields)
    {
        global $app_list_strings, $sugar_config;

        $this->bean = $bean;
        $this->fields_to_include = array_merge([], $fields);
        $this->module_name = $app_list_strings['moduleList'][$this->bean->module_dir];
        $this->mail_subject = "EmpowerCRM Assigned {$this->module_name}";
        $this->record_url = "{$sugar_config['site_url']}/index.php?module={$this->bean->module_dir}&action=DetailView&record={$this->bean->id}";
    }

    /**
     * Set to FALSE when there are other users that are recipients of the Email Notification
     */
    public function setDefaultMailRecipient($bool)
    {
        $this->for_assigned_user_only = $bool;
    }
    
    /**
     * (SHOULD BE) Triggered when $for_assigned_user_only is FALSE
     * Array should be array of User Beans
     */
    public function setMailRecipients($recipientsArr)
    {
        $this->recipients = array_merge([], $recipientsArr);
    }

    public function process()
    {
        global $current_user, $log, $sugar_config;
        
        if ($this->bean->assigned_user_id == $current_user->id || ! $this->bean->assigned_user_id) {
            return true;
        }

        $emailObj = new Email();
		$defaults = $emailObj->getSystemDefaultEmail();
		
		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
		$mail->From = $defaults['email'];
		$mail->FromName = $defaults['name'];
        $mail->Subject = $this->mail_subject;
        $mail->Body = from_html($this->generateBody());
        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
		$mail->prepForOutbound();

        $this->handleRecipients($mail); // Should be before $mail->Send() - to attach recipient(s) to the mail object before send trigger

        $mail->Send();
    }

    private function generateBody()
    {
        global $sugar_config, $current_user;

        $moduleContent = '';
        $assignedUserBean = BeanFactory::getBean('Users', $this->bean->assigned_user_id);
        $customQABanner = $sugar_config['isQA'] ? '<span style="color:red">***This is a test from the Empower QA System***</span>' : '';

        if (!empty($this->fields_to_include)) {
            
            foreach ($this->fields_to_include as $idx => $fieldArr) {
                $moduleContent .= "<span>{$fieldArr['label']}:</span> <span>{$fieldArr['value']}</span></br>";
            }
        }

        $body = "
            {$customQABanner}
            <p>Hello,</p>
            <p><b>{$current_user->name}</b> has assigned a(n) {$this->module_name} to <b>{$assignedUserBean->name}</b>.</p>
            <p>{$moduleContent}<p>

            <p>You may <a target='_blank' rel='noopener noreferrer' href='{$this->record_url}'>review this module here</a></p>
        ";

        return $body;
    }

    private function handleRecipients($mail)
    {
        global $current_user;

        // Send only to the $bean's assigned user
        if ($this->for_assigned_user_only) {
            // $GLOBALS['log']->fatal('bean assigned user as recipient');
            $assignedUserBean = BeanFactory::getBean('Users', $this->bean->assigned_user_id);
            $mail->AddAddress($assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean), $assignedUserBean->name);
        } else {
            // $GLOBALS['log']->fatal('custom users recipient(s)');
            foreach ($this->recipients as $userBean) {
                $mail->AddAddress($userBean->emailAddress->getPrimaryAddress($userBean), $userBean->name);
            }
        }

    }

} /* End of Class */