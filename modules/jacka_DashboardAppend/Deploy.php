<?php
/**
 * Created using PhpStorm.
 * User: shad
 * Date: 8/23/16
 * Time: 11:01 PM
 * File Name: Deploy.php
 * Project: jackal_dashboards
 */
global $sugar_config, $mod_strings;
require_once('modules/jckl_DashboardTemplates/jckl_DashboardTemplates.php');

$template = new jacka_DashboardAppend();
$template->retrieve($_REQUEST['template']);

$step = $_REQUEST['step'];

switch ($step) {
    case '1':
        include('StepOne.php');
        break;
    case '2':
        include('StepTwo.php');
        break;
    case 'commit':
        require_once('modules/jckl_DashboardTemplates/jckl_DashboardTemplates.php');
        $template = new jckl_DashboardTemplates();
        $results = $template->deploy($_POST['select_deployment_ids']);

        if ($results > 0) {
            $url = $sugar_config['site_url']
                .'/index.php?module=jckl_DashboardTemplates&action=DetailView&record='
                .$_REQUEST['template'];
            header('Location:'.$url);
        } else {
            echo $mod_strings['LBL_NONE_SELECTED'];
        }
        break;
    case 'append':
        require_once('modules/jckl_DashboardTemplates/jckl_DashboardTemplates.php');
        $deployer = new jckl_DashboardTemplates();
        $results = $deployer->appendDashboard($_POST['select_deployment_ids']);
        if ($results > 0) {

            $queryParams = array(
                'module' => 'jacka_DashboardAppend',
                'action' => 'DetailView',
                'record' => $_REQUEST['template']
            );
            $sa = new SugarApplication();
            $sa->redirect('index.php?' . http_build_query($queryParams));
        } else {
            echo $mod_strings['LBL_NONE_SELECTED'];
        }
        break;
    default:
        echo $mod_strings['LBL_NONE_SELECTED'];

}