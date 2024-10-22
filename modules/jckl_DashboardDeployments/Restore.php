<?php
    /**
     * Created using PhpStorm.
     * User: shad
     * Date: 10/6/16
     * Time: 3:20 PM
     * File Name: Restore.php
     * Project: jackal_dashboards
     */

    global $app_list_strings, $current_user, $sugar_config;

    /**
     * Validate License
     */

    require_once('modules/jckl_DashboardTemplates/license/OutfittersLicense.php');
    $validate_license = OutfittersLicense::isValid('jckl_DashboardTemplates');
    if($validate_license !== true) {
        if(is_admin($current_user)) {
            SugarApplication::appendErrorMessage('Dashboard Copy Manager is no longer active due to the following reason: '.$validate_license.' Please revalidate license in Admin');
        }
        echo '<h2><p class="error">Dashboard Copy Manager is no longer active</p></h2><p class="error">Please renew your subscription or check your license configuration.</p>';

        //functionality may be altered here in response to the key failing to validate
    } else {



        require_once('modules/jckl_DashboardDeployments/jckl_DashboardDeployments.php');

        $record_id = $_REQUEST['record'];

        $deployment = new jckl_DashboardDeployments();
        $deployment->retrieve($record_id);

        $user = new User();
        $user->retrieve($deployment->assigned_user_id);
        $user_name = $user->first_name . ' ' . $user->last_name;

        if ($_REQUEST['confirm']) {

            $deployment->restore();

            header('Location: '. $sugar_config['site_url'] . '/index.php?module=jckl_DashboardDeployments&action=DetailView&record='.$record_id);

        } else {
            $sugar_smarty = new Sugar_Smarty();

            $sugar_smarty->assign('MOD', $mod_strings);
            $sugar_smarty->assign('APP', $app_strings);
            $sugar_smarty->assign('APP_LIST', $app_list_strings);
            $sugar_smarty->assign('DEPLOYMENT_ID', $record_id);
            $sugar_smarty->assign('ACTION', 'Restore');
            $sugar_smarty->assign('MODULE', 'jckl_DashboardDeployments');
            $sugar_smarty->assign('USER_NAME', $user_name);
            echo $sugar_smarty->fetch('modules/jckl_DashboardDeployments/Restore.tpl');

        }
    }

