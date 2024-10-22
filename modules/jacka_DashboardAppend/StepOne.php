<?php
    /**
     * Created using PhpStorm.
     * User: shad
     * Date: 8/23/16
     * Time: 11:43 PM
     * File Name: StepOne.php
     * Project: jackal_dashboards
     */

    global $app_list_strings, $current_user;
    require_once('modules/jckl_DashboardTemplates/DeploymentUtilities.php');


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

        $dashboard_utilities = new jckl_DashboardTemplatesDeploymentUtilities();
        $deploy_options = $dashboard_utilities->getDeploymentOptions();
        $sugar_smarty = new Sugar_Smarty();

        $sugar_smarty->assign('MOD', $mod_strings);
        $sugar_smarty->assign('APP', $app_strings);
        $sugar_smarty->assign('APP_LIST', $app_list_strings);
        $sugar_smarty->assign('DEPLOY_OPTIONS', $deploy_options);
        $sugar_smarty->assign('TEMPLATE_ID', $_REQUEST['template']);
        $sugar_smarty->assign('NEXT_STEP', '2');
        $sugar_smarty->assign('ACTION', 'Deploy');
        $sugar_smarty->assign('MODULE', 'jacka_DashboardAppend');

        echo $sugar_smarty->fetch('modules/jacka_DashboardAppend/StepOne.tpl');

    }