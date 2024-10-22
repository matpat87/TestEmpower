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

require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class DSBTN_Distribution extends Basic
{
    public $new_schema = true;
    public $module_dir = 'DSBTN_Distribution';
    public $object_name = 'DSBTN_Distribution';
    public $table_name = 'dsbtn_distribution';
    public $importable = false;

    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }

    function create_new_list_query($order_by, $where, $filter = array(),
        $params = array(), $show_deleted = 0, $join_type = '',
        $return_array = false, $parentbean = null, $singleSelect = false,
        $ifListForExport = false
    ) 
    {
        global $db, $log, $module_name, $app, $current_user;

        // Disable out-of-the-box security groups filter as Distro data will be retrieved by way of TR - Distro access rights
        if (! $current_user->is_admin) {
            $_REQUEST['disable_security_groups_filter'] = true;
        }

        $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);
        
        if((! isset($_REQUEST['entryPoint'])) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'index' || $_REQUEST['action'] == 'Popup')
        {
            $query['select'] = str_replace("SELECT dsbtn_distribution.id", "SELECT DISTINCT(dsbtn_distributionitems_cstm.id_c) AS id, ", $query['select']);
            $query['select'] = str_replace("dsbtn_distribution.assigned_user_id", "dsbtn_distributionitems.assigned_user_id", $query['select']);

            $leftJoinDistroItemsQuery = " LEFT JOIN dsbtn_distributionitems_cstm ON dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = dsbtn_distribution.id LEFT JOIN dsbtn_distributionitems ON dsbtn_distributionitems_cstm.id_c = dsbtn_distributionitems.id AND dsbtn_distributionitems.deleted = 0";
            $query['from'] = str_replace("LEFT JOIN  users", "{$leftJoinDistroItemsQuery} LEFT JOIN  users", $query['from']);
            $query['from'] = str_replace("dsbtn_distribution.assigned_user_id", "dsbtn_distributionitems.assigned_user_id", $query['from']);
            
            $select = $query['select'];

            #Colormatch #305 - move the count of Distro Items to Select query
            $select .= ',tblTotal.total_items custom_total_items_non_db
                        ,tr_technicalrequests.id as custom_technical_request_id_non_db
                        ,tr_technicalrequests_cstm.technicalrequests_number_c as custom_technical_request_number_non_db
                        ,tr_technicalrequests_cstm.version_c as custom_technical_request_version_non_db
                        ,tr_technicalrequests.name as custom_technical_request_product_name_non_db
                        ,dsbtn_distributionitems_cstm.distribution_item_c as distro_item_non_db
                        ,dsbtn_distributionitems_cstm.qty_c as distro_item_qty_non_db
                        ,dsbtn_distributionitems_cstm.shipping_method_c as distro_item_delivery_method_non_db
                        ,dsbtn_distributionitems_cstm.status_c as distro_item_status_non_db
                        ,opportunities_cstm.oppid_c as custom_opportunity_number_non_db
                        ,dsbtn_distributionitems_cstm.id_c as distro_item_id_non_db
                        ';
            $query['select'] = $select;

            $from = $query['from'];
            
            //adding Total Items column
            $from .= ' left join (select count(*) as total_items,
                        dsbtn_distribution_id_c
                        from dsbtn_distributionitems as di 
                        inner join dsbtn_distributionitems_cstm as dic on dic.id_c = di.id
                        where di.deleted = 0 group by dic.dsbtn_distribution_id_c) tblTotal
                            on tblTotal.dsbtn_distribution_id_c = dsbtn_distribution.id ';

            //adding Technical Request
            $from .= ' left join tr_technicalrequests  
                            on dsbtn_distribution_cstm.tr_technicalrequests_id_c =  tr_technicalrequests.id
                                and tr_technicalrequests.deleted = 0
                        left join tr_technicalrequests_cstm
                            on tr_technicalrequests.id = tr_technicalrequests_cstm.id_c ';

            $from .= ' left join tr_technicalrequests_opportunities_c
                            on tr_technicalrequests.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                            and tr_technicalrequests_opportunities_c.deleted = 0
                        left join opportunities
                            on tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida = opportunities.id 
                            and opportunities.deleted = 0
                        left join opportunities_cstm
                            on opportunities.id = opportunities_cstm.id_c ';

            if ($_REQUEST['action'] == 'Popup') {
                
                //Colormatch #305 - if Detailview came from Sec Groups, do not execute Ralph's logic to retrieve all distro
                $field_to_name = (isset($_REQUEST['field_to_name'])) ? $_REQUEST['field_to_name'] : array();
                if(!in_array('securitygroups', $field_to_name)){
                    // Retrieve from custom session set in TR_TechnicalRequests view.detail.php
                    if ($_SESSION['tr_opportunity_id']) {
                        $query['where'] .= " AND opportunities.id = '{$_SESSION['tr_opportunity_id']}'";
                    } else {
                        $query['where'] .= " AND 1=0";
                    }

                    if ($_SESSION['tr_id']) {
                        $contactIdsWhereIn = $this->retrieveTRDistroContacts($_SESSION['tr_id']);

                        if ($contactIdsWhereIn) {
                            //$query['where'] .= " AND dsbtn_distribution_cstm.contact_id_c NOT IN ({$contactIdsWhereIn})";
                        }
                    } else {
                        $query['where'] .= " AND 1=0";
                    }
                }

                //Colormatch #305 - uncomment Group By since count is in select statement
                //$query['where'] = " {$query['where']} GROUP BY dsbtn_distribution_cstm.distribution_number_c ";
            }

            $query['from'] = $from;

            //echo '$from: ' . $from . '<br/>';

            // Filter query results based on logged user's Distro - TR Security Group Account Access
            if (! $current_user->is_admin) {
                if (SecurityGroupHelper::checkIfUserExistsInAccountOrDivisionAccessSecurityGroup()) {
                    $query['from'] = "{$query['from']} 
                        LEFT JOIN securitygroups_records
                                ON securitygroups_records.record_id = tr_technicalrequests.id
                                AND securitygroups_records.module = 'TR_TechnicalRequests'
                                AND securitygroups_records.deleted = 0
                        LEFT JOIN securitygroups
                                ON securitygroups.id = securitygroups_records.securitygroup_id
                                AND securitygroups.deleted = 0
                        LEFT JOIN securitygroups_cstm
                                ON securitygroups.id = securitygroups_cstm.id_c
                        LEFT JOIN securitygroups_users
                            ON securitygroups.id = securitygroups_users.securitygroup_id
                                AND securitygroups_users.deleted = 0
                    ";

                    $query['where'] = "{$query['where']}
                        AND securitygroups_cstm.type_c IN ('Account Access', 'Division Access')
                        AND securitygroups_users.user_id = '{$current_user->id}'
                    ";
                }
            }

            $trNumberSearchRequest = ($_REQUEST['searchFormTab'] == 'basic_search') ? $_REQUEST['custom_technical_request_number_non_db_basic'] : $_REQUEST['custom_technical_request_number_non_db_advanced'];
            $explodedTrSearchQuery = explode(".", $trNumberSearchRequest); // Ex. 504.01
            $trNumberSearchQuery = $explodedTrSearchQuery[0];
            $trVersionSearchQuery = $explodedTrSearchQuery[1];

            if ($trNumberSearchQuery) {
                $query['where'] = str_replace("custom_technical_request_number_non_db like '{$trNumberSearchRequest}%'", "tr_technicalrequests_cstm.technicalrequests_number_c like '{$trNumberSearchQuery}%'", $query['where']);
                $query['where'] = ($trVersionSearchQuery) ? str_replace("dsbtn_distribution.deleted=0", "dsbtn_distribution.deleted=0 AND tr_technicalrequests_cstm.version_c LIKE '%{$trVersionSearchQuery}%'", $query['where']) : $query['where'];
            } else {
                $query['where'] = str_replace('custom_technical_request_number_non_db', 'tr_technicalrequests_cstm.technicalrequests_number_c', $query['where']);
            }

            $distroNumberSearchRequest = ($_REQUEST['searchFormTab'] == 'basic_search') ? $_REQUEST['distribution_number_c_basic'] : $_REQUEST['distribution_number_c_advanced'];
            $query['where'] = str_replace("dsbtn_distribution_cstm.distribution_number_c = {$distroNumberSearchRequest}", "dsbtn_distribution_cstm.distribution_number_c like '{$distroNumberSearchRequest}%'", $query['where']);
            
            $query['where'] = str_replace('custom_technical_request_product_name_non_db', 'tr_technicalrequests.name', $query['where']);
            $query['where'] = str_replace("dsbtn_distribution.assigned_user_id", "dsbtn_distributionitems.assigned_user_id", $query['where']);
            $query['where'] = str_replace("custom_opportunity_number_non_db", "opportunities_cstm.oppid_c", $query['where']);
            $query['where'] = str_replace('distro_item_non_db', 'dsbtn_distributionitems_cstm.distribution_item_c', $query['where']);
            $query['where'] = str_replace("distro_item_status_non_db", "dsbtn_distributionitems_cstm.status_c", $query['where']);
            $query['where'] = str_replace("dsbtn_distribution.deleted=0", "dsbtn_distribution.deleted=0 AND dsbtn_distributionitems.deleted = 0", $query['where']);
        }  else {
            if (! $return_array && ((isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'export') || $_REQUEST['action'] == 'MassUpdate')) {
                $query = str_replace(
                    'FROM dsbtn_distribution',
                    'FROM dsbtn_distribution
                    LEFT JOIN dsbtn_distributionitems_cstm 
                        ON dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = dsbtn_distribution.id 
                    LEFT JOIN dsbtn_distributionitems 
                        ON dsbtn_distributionitems_cstm.id_c = dsbtn_distributionitems.id
                        AND dsbtn_distributionitems.deleted = 0
                    ',
                    $query
                );

                $query = str_replace(
                    'where', 
                    'LEFT JOIN tr_technicalrequests_cstm
                        ON jt5.id = tr_technicalrequests_cstm.id_c
                    LEFT JOIN tr_technicalrequests_opportunities_c
                        ON jt5.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                        AND tr_technicalrequests_opportunities_c.deleted = 0
                    LEFT JOIN opportunities
                        ON tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida = opportunities.id 
                        AND opportunities.deleted = 0
                    LEFT JOIN opportunities_cstm
                        ON opportunities.id = opportunities_cstm.id_c where',
                    $query
                );

                if ($_REQUEST['action'] == 'MassUpdate') {
                    $query = str_replace('FROM dsbtn_distribution', ',dsbtn_distributionitems_cstm.id_c AS id FROM dsbtn_distribution', $query);
                }
                
                $query = str_replace('custom_technical_request_number_non_db', 'tr_technicalrequests_cstm.technicalrequests_number_c', $query);
                $query = str_replace('custom_technical_request_product_name_non_db', 'tr_technicalrequests.name', $query);
                $query = str_replace('dsbtn_distribution.assigned_user_id', 'dsbtn_distributionitems.assigned_user_id', $query);
                $query = str_replace('custom_opportunity_number_non_db', 'opportunities_cstm.oppid_c', $query);
                $query = str_replace('distro_item_non_db', 'dsbtn_distributionitems_cstm.distribution_item_c', $query);
                $query = str_replace("distro_item_status_non_db", "dsbtn_distributionitems_cstm.status_c", $query);
                $query = str_replace("dsbtn_distribution.deleted=0", "dsbtn_distribution.deleted=0 AND dsbtn_distributionitems.deleted = 0", $query);

                // Blank Export Fix as WHERE references dsbtn_distribution.id but IDs are from dsbtn_distributionitems
                $query = str_replace("dsbtn_distribution.id in", "dsbtn_distributionitems.id in", $query);

                $query = str_replace("ORDER BY", "AND dsbtn_distributionitems.deleted = 0 ORDER BY", $query);

                if (isset($_REQUEST['current_post']) && $_REQUEST['current_post']) {
                    $whereArray = json_decode(html_entity_decode($_REQUEST['current_post']),true);

                    $trNumberSearchRequest = ($whereArray['searchFormTab'] == 'basic_search') ? $whereArray['custom_technical_request_number_non_db_basic'] : $whereArray['custom_technical_request_number_non_db_advanced'];
                    $explodedTrSearchQuery = explode(".", $trNumberSearchRequest); // Ex. 504.01
                    $trNumberSearchQuery = $explodedTrSearchQuery[0];
                    $trVersionSearchQuery = $explodedTrSearchQuery[1];

                    if ($trNumberSearchQuery) {
                        $query = str_replace("tr_technicalrequests_cstm.technicalrequests_number_c like '{$trNumberSearchRequest}%'", "tr_technicalrequests_cstm.technicalrequests_number_c like '{$trNumberSearchQuery}%'", $query);
                        $query = ($trVersionSearchQuery) ? str_replace("dsbtn_distribution.deleted=0", "dsbtn_distribution.deleted=0 AND tr_technicalrequests_cstm.version_c LIKE '%{$trVersionSearchQuery}%'", $query) : $query;
                    }
                }
            }
        }
        

        return $query;
    }
    
    public function retrieveTRDistroContacts($technicalRequestId)
    {
        global $db;

        $query = "SELECT contact_id_c AS contact_id
            FROM dsbtn_distribution
            LEFT JOIN dsbtn_distribution_cstm 
                ON dsbtn_distribution.id = dsbtn_distribution_cstm.id_c
            LEFT JOIN tr_technicalrequests 
                ON tr_technicalrequests.id = dsbtn_distribution_cstm.tr_technicalrequests_id_c
            WHERE tr_technicalrequests.id = '{$technicalRequestId}'
                AND dsbtn_distribution.deleted = 0
                AND tr_technicalrequests.deleted = 0";
        
        $result = $db->query($query);
        $array = [];

        while( $row = $db->fetchByAssoc($result)) {
            array_push($array, "'{$row['contact_id']}'");
        }
        
        return implode(', ', $array);
    }

    public function mark_deleted($id)
    {
        global $log;

        if (! (isset($_REQUEST['massupdate']) && $_REQUEST['massupdate'])) {
            // If not mass update (Triggered from Detailview -> Delete Action), fetch Distro Items and delete those before deleting the Distribution
            
            $moduleName = $this->module_dir;

            $distroBean = BeanFactory::getBean($moduleName, $id);

            if ($distroBean && $distroBean->id) {
                $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}'", false, 0);

                if (isset($distroItemBeanList) && count($distroItemBeanList) > 0) {
                    foreach ($distroItemBeanList as $distroItemBean) {
                        custom_mark_deleted($distroItemBean->module_dir, $distroItemBean->id);
                    }
                }
            }
        } else {
            // If Mass Update, Fetch Distro Item Bean and retrieve Distro Bean to retrieve full Distro Items list
            // If Distro Items list count is less than or equal to 1 (meaning this is the last distro item related to the distro), delete Distro
            // Note: You cannot delete the entire distro if a Distro item is still related to the module as it may cause floating Distro items which will bloat the DB

            $moduleName = 'DSBTN_DistributionItems';

            $distroItemBean = BeanFactory::getBean($moduleName, $id);
            $distroBean = BeanFactory::getBean($this->module_dir, $distroItemBean->dsbtn_distribution_id_c);

            if ($distroBean && $distroBean->id) {
                $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}'", false, 0);

                if (isset($distroItemBeanList) && count($distroItemBeanList) <= 1) {
                    custom_mark_deleted($distroBean->module_dir, $distroBean->id);
                }
            }
        }
        
        // Override core mark_deleted function
        // custom_mark_deleted can be found on custom_utils.php
        if ($moduleName && $id) {
            custom_mark_deleted($moduleName, $id);
        }
    }
}
