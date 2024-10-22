<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=MassPopulateUserOutboundEmailAccount
massPopulateUserOutboundEmailAccount();

// Function to Mass Populate User Outbound Email Account for all Active Users
function massPopulateUserOutboundEmailAccount()
{
    // Get all users with Active Status
    $userBean = BeanFactory::getBean('Users');
    $usersList = $userBean->get_full_list(array('status' => 'Active'));

    foreach ($usersList as $user) {
        // Check if the user already has an Outbound Email Account
        $emailAccountBean = BeanFactory::getBean('OutboundEmailAccounts')->retrieve_by_string_fields(
            array( 'user_id' => $user->id, 'name' => "{$user->full_name} Outbound Email Setup" ),
            false,
            true
        );

        // Return if the user already has an Outbound Email Account
        if ($emailAccountBean && $emailAccountBean->id) {
            continue;
        }

        // Create a new Outbound Email Account for the user
        $emailAccountBean = BeanFactory::newBean('OutboundEmailAccounts');
        $emailAccountBean->name = "{$user->full_name} Outbound Email Setup";
        $emailAccountBean->type = 'user';
        $emailAccountBean->user_id = $user->id;
        $emailAccountBean->smtp_from_name = $user->full_name;
        $emailAccountBean->smtp_from_addr = $user->emailAddress->getPrimaryAddress($user);
        $emailAccountBean->mail_sendtype = 'SMTP';
        $emailAccountBean->mail_smtptype = 'other';
        $emailAccountBean->mail_smtpserver = '172.16.22.23';
        $emailAccountBean->mail_smtpport = '25';
        $emailAccountBean->mail_smtpuser = $user->full_name;
        $emailAccountBean->mail_smtpauth_req = 0;
        $emailAccountBean->mail_smtpssl = 0;
        $emailAccountBean->assigned_user_id = $user->id;
        $emailAccountBean->save();
    }
}