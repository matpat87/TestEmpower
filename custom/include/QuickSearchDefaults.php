<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

require_once('include/QuickSearchDefaults.php');

class QuickSearchDefaultsCustom extends QuickSearchDefaults
{
    function getQSParent($parent = 'Accounts') {
        global $app_strings;

        if ($parent == 'Accounts' || $parent == '**@**') {
            $method = 'cstm_get_account_array';
            $field_list = array('name', 'id', 'shipping_address_street');
        } else {
            $method = 'query';
            $field_list = array('name', 'id');
        }

        $qsParent = array(
                    'form' => $this->form_name,
                    'method' => $method,
                    'modules' => array($parent),
                    'group' => 'or',
                    'field_list' => $field_list,
                    'populate_list' => array('parent_name', 'parent_id'),
                    'required_list' => array('parent_id'),
                    'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
                    'order' => 'name',
                    'limit' => '30',
                    'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
                    );

        return $qsParent;
    }

    function getQSAccount($nameKey, $idKey, $billingKey = null, $shippingKey = null, $additionalFields = null) {

        global $app_strings;


        $field_list = array('name', 'id', 'shipping_address_street');
        $populate_list = array($nameKey, $idKey);
        if($billingKey != null) {
            $field_list = array_merge($field_list, array('billing_address_street', 'billing_address_city',
                                                           'billing_address_state', 'billing_address_postalcode', 'billing_address_country'));

            $populate_list = array_merge($populate_list, array($billingKey . "_address_street", $billingKey . "_address_city",
                                                                $billingKey . "_address_state", $billingKey . "_address_postalcode", $billingKey . "_address_country"));
        } //if

        if($shippingKey != null) {
            $field_list = array_merge($field_list, array('shipping_address_street', 'shipping_address_city',
                                                           'shipping_address_state', 'shipping_address_postalcode', 'shipping_address_country'));

            $populate_list = array_merge($populate_list, array($shippingKey . "_address_street", $shippingKey . "_address_city",
                                                                $shippingKey . "_address_state", $shippingKey . "_address_postalcode", $shippingKey . "_address_country"));
        }

        if(!empty($additionalFields) && is_array($additionalFields)) {
           $field_list = array_merge($field_list, array_keys($additionalFields));
           $populate_list = array_merge($populate_list, array_values($additionalFields));
        }

        $qsParent = array(
					'form' => $this->form_name,
                    'method' => 'cstm_get_account_array',
                    'modules' => array('Accounts'),
                    'group' => 'or',
                    'field_list' => $field_list,
                    'populate_list' => $populate_list,
                    'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
                    'required_list' => array($idKey),
                    'order' => 'name',
                    'limit' => '30',
                    'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
                    );

        return $qsParent;
    }
}
