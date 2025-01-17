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

$dictionary['CI_CustomerItems'] = array(
    'table' => 'ci_customeritems',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array (
  'budget_apr' => 
  array (
    'required' => false,
    'name' => 'budget_apr',
    'vname' => 'LBL_BUDGET_APR',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'currency_id' => 
  array (
    'required' => false,
    'name' => 'currency_id',
    'vname' => 'LBL_CURRENCY',
    'type' => 'currency_id',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 36,
    'size' => '20',
    'dbType' => 'id',
    'studio' => 'visible',
    'function' => 
    array (
      'name' => 'getCurrencyDropDown',
      'returns' => 'html',
    ),
  ),
  'budget_aug' => 
  array (
    'required' => false,
    'name' => 'budget_aug',
    'vname' => 'LBL_BUDGET_AUG',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_jan' => 
  array (
    'required' => false,
    'name' => 'budget_jan',
    'vname' => 'LBL_BUDGET_JAN',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_feb' => 
  array (
    'required' => false,
    'name' => 'budget_feb',
    'vname' => 'LBL_BUDGET_FEB',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_mar' => 
  array (
    'required' => false,
    'name' => 'budget_mar',
    'vname' => 'LBL_BUDGET_MAR',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_may' => 
  array (
    'required' => false,
    'name' => 'budget_may',
    'vname' => 'LBL_BUDGET_MAY',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_jun' => 
  array (
    'required' => false,
    'name' => 'budget_jun',
    'vname' => 'LBL_BUDGET_JUN',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_jul' => 
  array (
    'required' => false,
    'name' => 'budget_jul',
    'vname' => 'LBL_BUDGET_JUL',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_sep' => 
  array (
    'required' => false,
    'name' => 'budget_sep',
    'vname' => 'LBL_BUDGET_SEP',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_oct' => 
  array (
    'required' => false,
    'name' => 'budget_oct',
    'vname' => 'LBL_BUDGET_OCT',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_nov' => 
  array (
    'required' => false,
    'name' => 'budget_nov',
    'vname' => 'LBL_BUDGET_NOV',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_dec' => 
  array (
    'required' => false,
    'name' => 'budget_dec',
    'vname' => 'LBL_BUDGET_DEC',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_01_jan' => 
  array (
    'required' => false,
    'name' => 'budget_cost_01_jan',
    'vname' => 'LBL_BUDGET_COST_01_JAN',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_02_feb' => 
  array (
    'required' => false,
    'name' => 'budget_cost_02_feb',
    'vname' => 'LBL_BUDGET_COST_02_FEB',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_03_mar' => 
  array (
    'required' => false,
    'name' => 'budget_cost_03_mar',
    'vname' => 'LBL_BUDGET_COST_03_MAR',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_04_apr' => 
  array (
    'required' => false,
    'name' => 'budget_cost_04_apr',
    'vname' => 'LBL_BUDGET_COST_04_APR',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_05_may' => 
  array (
    'required' => false,
    'name' => 'budget_cost_05_may',
    'vname' => 'LBL_BUDGET_COST_05_MAY',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_06_jun' => 
  array (
    'required' => false,
    'name' => 'budget_cost_06_jun',
    'vname' => 'LBL_BUDGET_COST_06_JUN',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_07_jul' => 
  array (
    'required' => false,
    'name' => 'budget_cost_07_jul',
    'vname' => 'LBL_BUDGET_COST_07_JUL',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_08_aug' => 
  array (
    'required' => false,
    'name' => 'budget_cost_08_aug',
    'vname' => 'LBL_BUDGET_COST_08_AUG',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_09_sep' => 
  array (
    'required' => false,
    'name' => 'budget_cost_09_sep',
    'vname' => 'LBL_BUDGET_COST_09_SEP',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_10_oct' => 
  array (
    'required' => false,
    'name' => 'budget_cost_10_oct',
    'vname' => 'LBL_BUDGET_COST_10_OCT',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_11_nov' => 
  array (
    'required' => false,
    'name' => 'budget_cost_11_nov',
    'vname' => 'LBL_BUDGET_COST_11_NOV',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'budget_cost_12_dec' => 
  array (
    'required' => false,
    'name' => 'budget_cost_12_dec',
    'vname' => 'LBL_BUDGET_COST_12_DEC',
    'type' => 'currency',
    'massupdate' => 0,
    'default' => 0.0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'volume_01_jan' => 
  array (
    'required' => false,
    'name' => 'volume_01_jan',
    'vname' => 'LBL_VOLUME_01_JAN',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_02_feb' => 
  array (
    'required' => false,
    'name' => 'volume_02_feb',
    'vname' => 'LBL_VOLUME_02_FEB',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_03_mar' => 
  array (
    'required' => false,
    'name' => 'volume_03_mar',
    'vname' => 'LBL_VOLUME_03_MAR',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_04_apr' => 
  array (
    'required' => false,
    'name' => 'volume_04_apr',
    'vname' => 'LBL_VOLUME_04_APR',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_05_may' => 
  array (
    'required' => false,
    'name' => 'volume_05_may',
    'vname' => 'LBL_VOLUME_05_MAY',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_06_jun' => 
  array (
    'required' => false,
    'name' => 'volume_06_jun',
    'vname' => 'LBL_VOLUME_06_JUN',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_07_jul' => 
  array (
    'required' => false,
    'name' => 'volume_07_jul',
    'vname' => 'LBL_VOLUME_07_JUL',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_08_aug' => 
  array (
    'required' => false,
    'name' => 'volume_08_aug',
    'vname' => 'LBL_VOLUME_08_AUG',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_09_sep' => 
  array (
    'required' => false,
    'name' => 'volume_09_sep',
    'vname' => 'LBL_VOLUME_09_SEP',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_10_oct' => 
  array (
    'required' => false,
    'name' => 'volume_10_oct',
    'vname' => 'LBL_VOLUME_10_OCT',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_11_nov' => 
  array (
    'required' => false,
    'name' => 'volume_11_nov',
    'vname' => 'LBL_VOLUME_11_NOV',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'volume_12_dec' => 
  array (
    'required' => false,
    'name' => 'volume_12_dec',
    'vname' => 'LBL_VOLUME_12_DEC',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '10',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => 0,
    'max' => 9999999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 0,
      'max' => 9999999999,
    ),
  ),
  'weight_per_gal' => 
  array (
    'required' => false,
    'name' => 'weight_per_gal',
    'vname' => 'LBL_WEIGHT_PER_GAL',
    'type' => 'decimal',
    'massupdate' => 0,
    'default' => '0.00',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => '2',
  ),
  'weight' => 
  array (
    'required' => true,
    'name' => 'weight',
    'vname' => 'LBL_WEIGHT',
    'type' => 'decimal',
    'massupdate' => 0,
    'default' => '0.00',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => '2',
  ),
  'url' => 
  array (
    'required' => false,
    'name' => 'url',
    'vname' => 'LBL_URL',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '25',
    'size' => '20',
  ),
  'unit_measure' => 
  array (
    'required' => false,
    'name' => 'unit_measure',
    'vname' => 'LBL_UNIT_MEASURE',
    'type' => 'enum',
    'massupdate' => '1',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'weight_unit_measure_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'type' => 
  array (
    'required' => false,
    'name' => 'type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'product_type_dom',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'status' => 
  array (
    'required' => false,
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'product_status_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'product_image' => 
  array (
    'required' => false,
    'name' => 'product_image',
    'vname' => 'LBL_PRODUCT_IMAGE',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => 'File name associated with the note (attachment)',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '255',
    'size' => '20',
  ),
  'price' => 
  array (
    'required' => false,
    'name' => 'price',
    'vname' => 'LBL_PRICE',
    'type' => 'currency',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'part_number' => 
  array (
    'required' => true,
    'name' => 'part_number',
    'vname' => 'LBL_PART_NUMBER',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '25',
    'size' => '20',
  ),
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'link' => true,
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'full_text_search' => 
    array (
      'boost' => 3,
    ),
    'required' => true,
    'importable' => 'required',
    'duplicate_merge' => 'disabled',
    'merge_filter' => 'disabled',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'size' => '20',
  ),
  'material_cost_type' => 
  array (
    'required' => false,
    'name' => 'material_cost_type',
    'vname' => 'LBL_MATERIAL_COST_TYPE',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '3',
    'size' => '20',
  ),
  'margin' => 
  array (
    'required' => false,
    'name' => 'margin',
    'vname' => 'LBL_MARGIN',
    'type' => 'float',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => '2',
  ),
  'maincode' => 
  array (
    'required' => true,
    'name' => 'maincode',
    'vname' => 'LBL_MAINCODE',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'product_code_dom',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'location' => 
  array (
    'required' => false,
    'name' => 'location',
    'vname' => 'LBL_LOCATION',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '3',
    'size' => '20',
  ),
  'division' => 
  array (
    'required' => true,
    'name' => 'division',
    'vname' => 'LBL_DIVISION',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'user_division_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'cost' => 
  array (
    'required' => false,
    'name' => 'cost',
    'vname' => 'LBL_COST',
    'type' => 'currency',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 26,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 6,
  ),
  'container' => 
  array (
    'required' => false,
    'name' => 'container',
    'vname' => 'LBL_CONTAINER',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'product_container_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'company_no' => 
  array (
    'required' => false,
    'name' => 'company_no',
    'vname' => 'LBL_COMPANY_NO',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'erp_id_dom',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'category' => 
  array (
    'required' => false,
    'name' => 'category',
    'vname' => 'LBL_CATEGORY',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'product_category_dom',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'cas' => 
  array (
    'required' => false,
    'name' => 'cas',
    'vname' => 'LBL_CAS',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '30',
    'size' => '20',
  ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('CI_CustomerItems', 'CI_CustomerItems', array('basic','assignable','security_groups'));