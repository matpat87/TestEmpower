<?php
/**
 * Add a Login as button in DetailView
 *
 * @author Steven Kyamko <stevenkyamko@gmail.com>
 * @date 6/13/2018
 */

include_once('include/SugarPHPMailer.php');
require_once('include/json_config.php');
require_once('include/MVC/View/views/view.detail.php');
require_once('modules/Users/views/view.detail.php');
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

class CustomUsersViewDetail extends UsersViewDetail
{
    public function preDisplay()
    {
        global $current_user, $app_strings, $sugar_config;
        
        parent::preDisplay();
        
        if (is_admin($current_user) || ($GLOBALS['current_user']->isAdminForModule('Users')&& !$this->bean->is_admin)) {
            $this->dv->defs['templateMeta']['form']['buttons'][] = array('customCode' => '<input title="'.translate('LBL_RESEND_ACCOUNT_EMAIL','Users').'" class="button" LANGUAGE=javascript onclick="if(confirm(\''.translate('LBL_RESEND_ACCOUNT_MAIL_CONFIRM','Users').'\')) window.location=\'index.php?module=Users&action=DetailView&resend_email=true&record={$fields.id.value}\';" type="button" name="password" value="'.translate('LBL_RESEND_ACCOUNT_EMAIL','Users').'">"');

        }
        
    }

    public function display()
    {
        global $current_user, $app_strings, $sugar_config;
        parent::display();

        if (is_admin($current_user) && isset($_REQUEST['resend_email'])) {
            $this->resend_account_email();
        }
    }

    protected function resend_account_email()
    {
        global $sugar_config;

        // re-generate new User password
        $now = Carbon::now();
        $new_password = 'Welcome'.$now->year.'!';

        $userBean = BeanFactory::getBean('Users', $_REQUEST['record']);
        $userBean->setNewPassword($new_password);
        
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];

        $mail->Subject = 'EmpowerCRM New Empower Account';

        $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';

        $mail->Body = from_html(
            '
            '.$customQABanner.'
            
            Welcome to Empower!
            <br><br>

            A user account has been created for you!
            <br><br>

            You may access the Empower system by clicking the link ' . $sugar_config['site_url'] . '.
            If the link does not work please copy and paste it into the address bar of your browser.
            The Empower system supports both Firefox and Chrome browsers.
            <br><br>
            
            Your credentials are:
            <br>
            Username: '. $userBean->user_name .'
            <br>
            Password: '. $new_password .'
            
            <br><br>
            Your password must be changed upon logon as this is a generic password for all new user accounts.
            
            <br><br>
            If you have any issues please contact your local marketing representative.

            <br><br>
            Thank You!
            <br>
            Empower Support team'
        );

        $mail->AddAddress($userBean->email1);
        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
        $mail->prepForOutbound();
        $mail->Send();    
            
	}
}