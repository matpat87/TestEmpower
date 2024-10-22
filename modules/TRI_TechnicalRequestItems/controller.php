<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

class TRI_TechnicalRequestItemsController extends SugarController
{

    public function action_get_assigned_user()
    {
        global $current_user;

        $result['data'] = [
            'assigned_user_id' => $current_user->id,
            'assigned_user_name' => $current_user->name
        ];

        $recordId = isset($_REQUEST['record_id']) && $_REQUEST['record_id'] ? $_REQUEST['record_id'] : '';
        $trId = isset($_REQUEST['tr_id']) && $_REQUEST['tr_id'] ? $_REQUEST['tr_id'] : '';
        $trItemName = isset($_REQUEST['tr_item_name']) && $_REQUEST['tr_item_name'] ? $_REQUEST['tr_item_name'] : '';

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);
        $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $recordId);

        if (($trBean && $trBean->id) && $trItemName) {
            // If recordId is empty or assigned_user_id is empty or trItemName is different from the name of the record, then retrieve the assigned user
            if (! $recordId || ! $trItemBean->assigned_user_id || $trItemName != $trItemBean->name) {
                $assignedUserBean = TechnicalRequestItemsHelper::retrieveTRItemAssignedUser($trBean, $trItemName);
            } else {
                $assignedUserBean = BeanFactory::getBean('Users', $trItemBean->assigned_user_id);
            }

            $assignedUserId = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->id : $current_user->id;
            $assignedUserName = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->name : $current_user->name;

            $result['data'] = [
                'assigned_user_id' => $assignedUserId,
                'assigned_user_name' => $assignedUserName
            ];
        }

        echo json_encode($result);
    }

    public function action_get_due_date_and_est_completion_date()
    {
        $result['data'] = [
            'due_date' => '',
            'est_completion_date_c' => ''
        ];
        
        $trId = isset($_REQUEST['tr_id']) && $_REQUEST['tr_id'] ? $_REQUEST['tr_id'] : '';
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);

        if ($trBean && $trBean->id) {
            $result['data'] = [
                'due_date' => $trBean->req_completion_date_c,
                'est_completion_date_c' => $trBean->est_completion_date_c,
            ];
        }

        echo json_encode($result);
    }
}	

