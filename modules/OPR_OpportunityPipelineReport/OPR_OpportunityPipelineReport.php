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


class OPR_OpportunityPipelineReport extends Basic
{
    public $new_schema = true;
    public $module_dir = 'OPR_OpportunityPipelineReport';
    public $object_name = 'OPR_OpportunityPipelineReport';
    public $table_name = 'opr_opportunitypipelinereport';
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

    function create_new_list_query($order_by,
        $where,
        $filter = array(),
        $params = array(),
        $show_deleted = 0,
        $join_type = '',
        $return_array = false,
        $parentbean = null,
        $singleSelect = false,
        $ifListForExport = false)
    { 
        $return_array = Array();

        $return_array['select'] = getSelectQueryForOpportunityPipeline();   
        $return_array['from'] = getFromQueryrForOpportunityPipeline();
        $return_array['where'] = " where a.deleted = 0 order by ";
        $return_array['order_by'] = ' a.name asc';
        $contains = false;

        if(!empty($where))
        {
            if(strpos($where, 'opr_opportunitypipelinereport_cstm.sales_representative_c') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.sales_representative_c", "u.id", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.account_c') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.account_c", "a.id", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.sales_stage_c') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.sales_stage_c", "o.sales_stage", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.market_c') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.market_c", "mm.id", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.type_c') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.type_c", "o.opportunity_type", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.amount_c =') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.amount_c =", "o.amount >=", $where);
                $contains = true;
            }

            if(strpos($where, "DATE_FORMAT(opr_opportunitypipelinereport_cstm.date_from_c,'%Y-%m-%d') =") !== false)
            {
                $where = string_replace_all("DATE_FORMAT(opr_opportunitypipelinereport_cstm.date_from_c,'%Y-%m-%d') =", "o.date_closed >=", $where);
                $contains = true;
            }

            if(strpos($where, "DATE_FORMAT(opr_opportunitypipelinereport_cstm.date_to_c,'%Y-%m-%d') =") !== false)
            {
                $where = string_replace_all("DATE_FORMAT(opr_opportunitypipelinereport_cstm.date_to_c,'%Y-%m-%d') =", "o.date_closed <=", $where);
                $contains = true;
            }

            if(strpos($where, 'opr_opportunitypipelinereport_cstm.probability_c =') !== false)
            {
                $where = string_replace_all("opr_opportunitypipelinereport_cstm.probability_c =", "o.probability >=", $where);
                $contains = true;
            }

            if($contains)
            {
                $return_array['where'] = ' where ' . $where;
                $return_array['where'] .= ' order by ';
            }
        }

        // return parent::create_new_list_query($order_by, $where, $filter,
        //     $params, $show_deleted, $join_type,
        //     $return_array, $parentbean, $singleSelect,
        //     $ifListForExport);

        return $return_array;
    }
	
}
