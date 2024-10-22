<?php
    handleVerifyBeforeRequire('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');

    class ManageTimelyNotif
    {
        public $currentBean;
        public $dateDiffInDays;
        
        function __construct($regulatory_id, $dateDiffInDays = 0)
        {
            $this->currentBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $regulatory_id);
            $this->dateDiffInDays = $dateDiffInDays;
        }

        public function process()
        {
            global $sugar_config, $app_list_strings;

            $recordURL = $sugar_config['site_url'] . '/index.php?module=RRQ_RegulatoryRequests&action=DetailView&record=' . $this->currentBean->id;
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">** This is a test from the Empower QA System **</span><br><br>' : '';
            $status = $app_list_strings['reg_req_statuses'][$this->currentBean->status_c];

            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = "EmpowerCRM Regulatory Request #{$this->currentBean->id_num_c} - Slow Moving";
            $this->attachRecipients($mail);

            // Mail Content
            $mail->Body = from_html(
				"
                {$customQABanner}

                <p>Hi {$this->currentBean->assigned_user_name}, <br/><br/>
                Please review the below regulatory request as it has been in its current status for {$this->dateDiffInDays} Days! <br/>
                Module: Regulatory Requests <br/>
                ID: {$this->currentBean->id_num_c} <br/>
                Status: {$status} <br/>
                Required Date: {$this->currentBean->req_date_c} <br/>
                Account: {$this->currentBean->accounts_rrq_regulatoryrequests_1_name} <br/>
                Contact: {$this->currentBean->contacts_rrq_regulatoryrequests_1_name} <br/>
                </p>

                <p>Click here to access the record: <a href='{$recordURL}'>{$recordURL}</a></p>
                Thanks,
                <br>
                {$defaults['name']}
                <br>"
			);

            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
			$mail->prepForOutbound();
            $mail->Send();
	
        }

        protected function attachRecipients($mail)
        {
            $recipientsArray = [];
           
            $regulatoryManagerUserBean = $this->getRegulatoryManager();
            
            // Awaiting more information – Assigned To & Regulatory Manager – Should be Creator based on workflow
            if (in_array($this->currentBean->status_c, ['awaiting_more_info', 'new', 'in_process', 'assigned', 'waiting_on_supplier'])) {
                if(!empty($this->currentBean->user_id1_c)){
                    $recipientUserBean = BeanFactory::getBean('Users', $this->currentBean->user_id1_c);
                    $recipientsArray[] = $recipientUserBean;
                }

                if (!empty($regulatoryManagerUserBean)) {
                    $recipientsArray[] = $regulatoryManagerUserBean; // Regulatory Manager
                }
                
            }
            foreach($recipientsArray as $recipient) {
                $mail->AddAddress($recipient->emailAddress->getPrimaryAddress($recipient), $recipient->name);
            }
            
            
        }

        public function getRegulatoryManager()
        {
            global $current_user;

            $regulatoryManager = null;

            // Case: If on RR Create, use the division of the current logged user
            if (!($this->currentBean->id)) {
                $this->currentBean->division_c = $current_user->division_c;
            }
            $assignedUserBean = BeanFactory::getBean('Users', $this->currentBean->assigned_user_id);
            
            $aclRolesBean = BeanFactory::getBean('ACLRoles')->retrieve_by_string_fields(
                [ 'division' => $this->currentBean->division_c, 'name' => 'Regulatory Manager' ],
                false,
                true
            );
            
            if ($aclRolesBean) {
                $regulatoryManagerBeans = $aclRolesBean->get_linked_beans(
                    'users', 'Users', array(), 0, -1,0,
                    "users.status = 'Active'"
                );   

                $regulatoryManager = $regulatoryManagerBeans ? $regulatoryManagerBeans[0] : null;
            }

            return $regulatoryManager;
        }

        public function processAssignedUserEmailNotifications($ccUserBeans = [])
        {
            global $current_user, $sugar_config, $app_list_strings;

            $moduleName = $app_list_strings['moduleList'][$this->currentBean->module_dir];
		    $assignedUserBean = BeanFactory::getBean('Users', $this->currentBean->assigned_user_id);
		    $createdByUserBean = BeanFactory::getBean('Users', $this->currentBean->created_by);

            // Format Dates: date_entered & req_date_c
            $requiredDate = empty($this->currentBean->req_date_c) ? "" : Carbon\Carbon::parse($this->currentBean->req_date_c)->toDateString();
            $dateEntered = Carbon\Carbon::parse($this->currentBean->date_entered)->toDateString();

            if ($current_user->id == $assignedUserBean->id || ! $assignedUserBean->id) {
                return true;
            }

            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            
            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = "EmpowerCRM Assigned {$moduleName}";

            $customQABanner = $sugar_config['isQA'] ? '<span style="color:red">***This is a test from the Empower QA System***</span>' : '';
            $recordUrl = "{$sugar_config['site_url']}/index.php?module=RRQ_RegulatoryRequests&action=DetailView&record={$this->currentBean->id}";

            $body = "
                {$customQABanner}
                <p>Hello, {$assignedUserBean->name}.</p>
                <p><b>{$current_user->name}</b> has assigned a(n) {$moduleName} to you.</p>
                <div>
                    <span>RR #: {$this->currentBean->id_num_c}</span><br/>
                    <span>Status: {$app_list_strings['reg_req_statuses'][$this->currentBean->status_c]}</span><br/>
                    <span>Account: {$this->currentBean->accounts_rrq_regulatoryrequests_1_name}</span><br/>
                    <span>Required Date: {$requiredDate}</span><br/>
                    <span>Submitted By: {$createdByUserBean->full_name}</span><br/>
                    <span>Submitted Date: {$dateEntered}</span><br/>
                    <span>Assigned To: {$this->currentBean->assigned_user_name}</span><br/>
                </div>
                <p>You may <a target='_blank' rel='noopener noreferrer' href='{$recordUrl}'>review this {$moduleName}</a>
            ";

            $mail->Body = from_html($body);
            $mail->AddAddress($assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean), $assignedUserBean->name);
            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
            $mail->prepForOutbound();

            // Check if notification needs CC recipients
            if (!empty($ccUserBeans)) {
                foreach ($ccUserBeans as $userBean) {
                    $mail->addCC($userBean->emailAddress->getPrimaryAddress($userBean));
                }
            }


		    $mail->Send();

        }

    } // end of class

        

  
?>