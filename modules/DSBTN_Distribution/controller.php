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

require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class DSBTN_DistributionController extends SugarController
{
    public function action_is_contact_exist()
    {
        global $log;
        $result = array('success' => true, 'data' => array());
        $is_exist = false;
        $distribution_detail = array();
        $tr_id_param = (isset($_REQUEST['tr_id'])) ? $_REQUEST['tr_id'] : '';
        $contact_id_param = (isset($_REQUEST['contact_id'])) ? $_REQUEST['contact_id'] : '';
        $distribution_id_param = (isset($_REQUEST['distribution_id'])) ? $_REQUEST['distribution_id'] : '';

        if(!empty($tr_id_param))
        {
            if(TechnicalRequestHelper::is_id_exists($tr_id_param))
            {
                $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $tr_id_param);

                $distroBean = BeanFactory::getBean('DSBTN_Distribution');
                $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$tr_bean->id}'", false, 0);
                
                if(isset($distroBeanList) && is_array($distroBeanList) && count($distroBeanList) > 0) {
                    foreach($distroBeanList as $distroBeanKey => $distroBean)
                    {
                        $is_distribution_id = (empty($distribution_id_param) || (!empty($distribution_id_param) && $distroBeanKey != $distribution_id_param));
                        if($is_distribution_id && $distroBean->id !== $distribution_id_param && $distroBean->contact_id_c == $contact_id_param)
                        {
                            $distribution_detail = array('distro_num' => $distroBean->distribution_number_c, 'tr_name' => $tr_bean->name);
                            $is_exist = true;
                        }
                    }
                }
            }
        }

        $result['data']['distribution_detail'] = $distribution_detail;
        $result['data']['is_exist'] = $is_exist;
        
        echo json_encode($result);
    }

    public function action_retrieve_contact_distribution_items()
    {
        echo DistributionHelper::GetDistributionItemsEditView('DistributionContact', $_REQUEST['contact_id'], $_REQUEST['tr_id']);
    }

    public function action_get_tr_details(){
        $result = array('success' => false, 'data' => array());
        $tr_id_param = (isset($_REQUEST['tr_id'])) ? $_REQUEST['tr_id'] : '';

        if(!empty($tr_id_param))
        {
            $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $tr_id_param);

            if(!empty($tr_bean->id))
            {
                $result['success'] = true;
                $result['data']['contact_c'] = $tr_bean->contact_c;
                $result['data']['contact_id1_c'] = $tr_bean->contact_id1_c;
            }
        }

        echo json_encode($result);
    }

    public function action_get_tr_site_colormatch_coordinator()
    {
        $result = array('success' => false, 'data' => array());
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['tr_id']);
        $siteColormatchCoordinatorBean = BeanFactory::newBean('Users');

        if ($trBean->id && $trBean->site) {
            $workGroupColormatchCoordinatorList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatchCoordinator' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteColormatchCoordinatorBean = (!empty($workGroupColormatchCoordinatorList) && count($workGroupColormatchCoordinatorList) > 0) ? BeanFactory::getBean('Users', $workGroupColormatchCoordinatorList[0]->parent_id) : null;
        }
        
        if(! empty($trBean->id)) {
            $result['success'] = true;
            $result['data']['site_colormatch_coordinator_id'] = $siteColormatchCoordinatorBean->id;
            $result['data']['site_colormatch_coordinator_name'] = $siteColormatchCoordinatorBean->name;
        }

        echo json_encode($result);
    }

      /**
       * @author Glai Obido
         * Ontrack #1696
         * Handle Change TR on Create Distro
         * Distro Items dropdown should depend on parent TR => type
         * Triggered from ajax request in custom/DSBTN_Distribution/js/edit.js: handleDistroItemsDropdownFiltering
         */
    public function action_retrieve_dsbtn_items_dropdown_list()
    {
        echo DistributionHelper::GetDistributionItemsEditView('DSBTN_Distribution', $_REQUEST['tr_id']);
    }
    
}	

