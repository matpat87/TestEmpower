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


class CI_CustomerItems_sugar extends Basic
{
    public $new_schema = true;
    public $module_dir = 'CI_CustomerItems';
    public $object_name = 'CI_CustomerItems';
    public $table_name = 'ci_customeritems';
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
    public $budget_apr;
    public $currency_id;
    public $budget_aug;
    public $budget_jan;
    public $budget_feb;
    public $budget_mar;
    public $budget_may;
    public $budget_jun;
    public $budget_jul;
    public $budget_sep;
    public $budget_oct;
    public $budget_nov;
    public $budget_dec;
    public $budget_cost_01_jan;
    public $budget_cost_02_feb;
    public $budget_cost_03_mar;
    public $budget_cost_04_apr;
    public $budget_cost_05_may;
    public $budget_cost_06_jun;
    public $budget_cost_07_jul;
    public $budget_cost_08_aug;
    public $budget_cost_09_sep;
    public $budget_cost_10_oct;
    public $budget_cost_11_nov;
    public $budget_cost_12_dec;
    public $volume_01_jan;
    public $volume_02_feb;
    public $volume_03_mar;
    public $volume_04_apr;
    public $volume_05_may;
    public $volume_06_jun;
    public $volume_07_jul;
    public $volume_08_aug;
    public $volume_09_sep;
    public $volume_10_oct;
    public $volume_11_nov;
    public $volume_12_dec;
    public $weight_per_gal;
    public $weight;
    public $url;
    public $unit_measure;
    public $type;
    public $status;
    public $product_image;
    public $price;
    public $part_number;
    public $material_cost_type;
    public $margin;
    public $maincode;
    public $location;
    public $division;
    public $cost;
    public $container;
    public $company_no;
    public $category;
    public $cas;
	
    function __construct(){
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AOS_Products_sugar(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }
    
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }
	
}