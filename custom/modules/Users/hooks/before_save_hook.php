<?php

    include_once('include/SugarPHPMailer.php');

	class BeforeSaveHook {
		public function newUserWelcomeEmail($bean, $event, $arguments)
		{
            global $sugar_config;
            
            if(!$bean->fetched_row['id']) {
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];

                $mail->Subject = 'New Empower Account';

                $mail->Body = from_html(
                    'Welcome to Empower!
                    <br><br>

                    A user account has been created for you!
                    <br><br>

                    You may access the Empower system by clicking the link ' . $sugar_config['site_url'] . '.
                    If the link does not work please copy and paste it into the address bar of your browser.
                    The Empower system supports both Firefox and Chrome browsers.
                    <br><br>
                    
                    Your credentials are:
                    <br>
                    Username: '.$bean->user_name.'
                    <br>
                    Password: '.$_REQUEST['new_password'].'
                    
                    <br><br>
                    Your password must be changed upon logon as this is a generic password for all new user accounts.
                    
                    <br><br>
                    If you have any issues please contact your local marketing representative.

                    <br><br>
                    Thank You!
                    <br>
                    Empower Support team'
                );

                $mail->AddAddress($bean->email1);
                $mail->isHTML(true);
                $mail->prepForOutbound();
                $mail->Send();
            }
		}
	}
?>