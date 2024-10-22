<?php
    /**
     * Created using PhpStorm.
     * User: shad
     * Date: 8/23/16
     * Time: 11:43 PM
     * File Name: StepOne.php
     * Project: jackal_dashboards
     */

    global $app_list_strings;
    require_once('modules/jckl_DashboardTemplates/DeploymentUtilities.php');

    $dashboard_utilities = new jckl_DashboardTemplatesDeploymentUtilities();

    $deploy_type = $_REQUEST['deploy_type'];
    $select_list = $dashboard_utilities->getDeployType($deploy_type);
    $sugar_smarty = new Sugar_Smarty();

    $sugar_smarty->assign('MOD', $mod_strings);
    $sugar_smarty->assign('APP', $app_strings);
    $sugar_smarty->assign('APP_LIST', $app_list_strings);
    $sugar_smarty->assign('SELECTIONS', $select_list);
    $sugar_smarty->assign('TEMPLATE_ID', $_REQUEST['template']);
    $sugar_smarty->assign('NEXT_STEP', 'commit');
    $sugar_smarty->assign('ACTION', 'Deploy');
    $sugar_smarty->assign('MODULE', 'jckl_DashboardTemplates');
    $sugar_smarty->assign('DEPLOY_TYPE', $deploy_type);


    echo $sugar_smarty->fetch('modules/jckl_DashboardTemplates/StepTwo.tpl');