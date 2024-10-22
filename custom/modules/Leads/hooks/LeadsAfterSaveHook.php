<?php

class LeadsAfterSaveHook
{
    function send_email_acknowledgement(&$bean, $event, $arguments)
    {   
        // If new record with division epolin and is assigned to Joseph Chen
        if ( ! $bean->fetched_row['id'] && $bean->division_c == 'Epolin') {
           $userBean = BeanFactory::getBean('Users', $bean->assigned_user_id);

           if ($userBean->user_name == 'JCHEN')
           $this->send_email($bean, $userBean);
        }
    }

    private function send_email($bean, $user)
    {
        global $sugar_config;

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $user->emailAddress->getPrimaryAddress($user) ?? $defaults['email'];
        $mail->FromName = $user->name ?? $defaults['name'];

        $mail->Subject = 'EmpowerCRM Thank you for your interest in Epolin!';

        $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';

        $mail->Body = from_html(
            "
            {$customQABanner}
            
            Dear {$bean->name}:
            <br><br>

            Thank you for your interest in our products.
            <br><br>

            Our sales department will be in contact with you shortly to review your application.
            <br><br>

            Best regards,
            <br>
            {$user->first_name}
            <br>
            <b>{$user->name}</b>, Epolin Sales, Mobile: (732) 829-9298
            <br>
            358-364 Adams St., Newark, NJ 07105 (973) 465-9495 ext 305
            <br>
            <img src='https://empower.chromacolors.com/public/epolin-signature.png' width='96' height='48'>
            <br>"
        );

        $mail->AddAddress($bean->email1);
        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
        $mail->prepForOutbound();
        $mail->Send();

    }
}