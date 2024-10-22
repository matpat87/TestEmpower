<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class PA_PreventiveActionsController extends SugarController
{
    public function action_check_customerissue_status()
    {
        global $log, $app_list_strings;

        $customer_issue_id = $_REQUEST['customer_issue_id'];
        $return_arr = array('status' => null, 'ci_status_list' => $app_list_strings['status_list']);

        $customerIssueBean = BeanFactory::getBean('Cases', $customer_issue_id);

        if (isset($customerIssueBean->id)) {
            $return_arr['status'] = $customerIssueBean->status;
        }

        echo json_encode($return_arr);
    }
}