<?php
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

class CapaWorkflowHook
{
	public function handleAssignedToUser($bean, $event, $arguments)
	{
        global $log, $db;
        
        $capaUserBean = null;
        
        // If status has been updated or Department has been updated or record has no existing assigned user
        if ($bean->fetched_row['status'] !== $bean->status || ($bean->ci_department_c != $bean->fetched_row['ci_department_c'])|| (! $bean->fetched_row['assigned_user_id'])) {
            switch ($bean->status) {
                // When status == Draft, should send notification to related Account's assigned to User & Sales Mgr of Sales Rep
                case 'Draft':
                    $capaUserBean = CapaWorkingGroupHelper::getCapaUsers($bean, ['QualityControlManager']) ?? null;
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
                $db->query($updateSQL);
            }
        }
	}
}
