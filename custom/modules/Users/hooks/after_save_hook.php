<?php
	class UsersAfterSaveHook {
		public function newUserDefaultRole($bean, $event, $arguments)
		{
            if ( ! $bean->fetched_row['id'] ) {
                $userBean = BeanFactory::getBean('Users', $bean->id);
                $aclRolesBean = BeanFactory::getBean('ACLRoles');
                
                /*
                * retrieve_by_string_fields params
                * An array of field names to the desired value
                * Whether or not the results should be HTML encoded
                * Whether or not to add the deleted filter
                */
                $noAccessRoleBean = $aclRolesBean->retrieve_by_string_fields(
                    array( 'name' => 'No Access' ),
                    false,
                    true
                );

                if ($noAccessRoleBean->load_relationship('users')) {
                    $noAccessRoleBean->users->add($userBean);
                }
                
                $defaultImplicitSettingsBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
                    array( 'name' => 'Default Implicit Settings' ),
                    false,
                    true
                );
                
                if ($defaultImplicitSettingsBean->load_relationship('users')) {
                    $defaultImplicitSettingsBean->users->add($userBean);
                }
            }
		}

        // Hook to create a new Outbound Email Account for new users
        public function handleNewUserOutboundEmailAccount($bean, $event, $arguments)
        {
            // Only proceed if the user is new
            if (! $bean->fetched_row['id']) {
                $userBean = BeanFactory::getBean('Users', $bean->id);

                // Check if the user already has an Outbound Email Account
                $emailAccountBean = BeanFactory::getBean('OutboundEmailAccounts')->retrieve_by_string_fields(
                    array( 'user_id' => $bean->id, 'name' => "{$bean->full_name} Outbound Email Setup" ),
                    false,
                    true
                );

                // Return if the user already has an Outbound Email Account
                if ($emailAccountBean && $emailAccountBean->id) {
                    return;
                }

                // Set the full name of the user as it is blank for new users
                $bean->full_name = ($bean->first_name) ? "{$bean->first_name} {$bean->last_name}" : $bean->last_name;

                // Create a new Outbound Email Account for the user
                $emailAccountBean = BeanFactory::newBean('OutboundEmailAccounts');
                $emailAccountBean->name = "{$bean->full_name} Outbound Email Setup";
                $emailAccountBean->type = 'user';
                $emailAccountBean->user_id = $bean->id;
                $emailAccountBean->smtp_from_name = $bean->full_name;
                $emailAccountBean->smtp_from_addr = $bean->emailAddress->getPrimaryAddress($bean);
                $emailAccountBean->mail_sendtype = 'SMTP';
                $emailAccountBean->mail_smtptype = 'other';
                $emailAccountBean->mail_smtpserver = '172.16.22.23';
                $emailAccountBean->mail_smtpport = '25';
                $emailAccountBean->mail_smtpuser = $bean->full_name;
                $emailAccountBean->mail_smtpauth_req = 0;
                $emailAccountBean->mail_smtpssl = 0;
                $emailAccountBean->assigned_user_id = $bean->id;
                $emailAccountBean->save();
            }
        }
	}
?>