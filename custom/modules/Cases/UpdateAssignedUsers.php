<?php
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Cases&action=UpdateAssignedUsers
updateAssignedUsers();
function updateAssignedUsers() 
{

	global $db, $app_list_strings, $log;

    $capaUserBean = null;
    $customerIssuesBean = BeanFactory::getBean('Cases');

    $beanList = $customerIssuesBean->get_full_list('', 'cases.id IS NOT NULL', false, 0);
    $counter = 0;

    foreach($beanList as $bean) {
        switch ($bean->status) 
        {      
            case 'Draft':
                $userBean = BeanFactory::getBean('Users', $bean->created_by);
                $capaUserBean = $userBean ? $userBean : null;
                break;
            case 'New':
                $workgroupUser = CapaWorkingGroupHelper::getCapaUsers($bean, ['QualityControlManager']);
                $capaUserBean = ($workgroupUser)
                    ? CapaWorkingGroupHelper::getCapaUsers($bean, ['QualityControlManager']) 
                    : retrieveUserBySecurityGroupTypeDivision('Quality Control Manager', 'CAPAWorkingGroup', $bean->site_c, $bean->division_c);
                break;
            case 'Approved':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['DepartmentManager']) ?? null;
                break;
            case 'InProcess':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['DepartmentManager']) ?? null;
                break;
            case 'CAPAReview':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['CAPACoordinator']) ?? null;
                break;
            case 'CAPAApproved':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['CAPACoordinator']) ?? null;
                break;
            case 'CAPAComplete':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['InternalAuditor']) ?? null;
                break;
            case 'Closed':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['CAPACoordinator']) ?? null;
                break;
            case 'AwaitingInformation':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['SalesPerson']) ?? null;
                break;
            case 'Rejected':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['CAPACoordinator']) ?? null;
                break;
            case 'Cancelled':
                $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['SalesPerson']) ?? null;
                break;
        }

        // Update Customer Issue when $capaUserBean has a value
        if ($capaUserBean != null) {
            $assignedUserID = (is_array($capaUserBean)) ? $capaUserBean[0]->id : $capaUserBean->id;
            $bean->assigned_user_id = $assignedUserID;

            $updateSQL = "UPDATE cases SET assigned_user_id = '{$assignedUserID}' WHERE id = '{$bean->id}' ";

            
            if ($assignedUserID != '') {
                
                echo '<pre>';
                    print_r($updateSQL);
                echo '</pre>';

                $db->query($updateSQL);
                $counter++;
            }
           
        }
    }
    
    echo '<pre>';
    echo "{$counter} records updated";
    echo '</pre>';
	// $db->query($sql);
}
