<?php
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

require_once('modules/Home/QuickSearch.php');

class quicksearchQueryCustom extends quicksearchQuery
{
    /**
     * cstm_get_account_array
     *
     */
    public function cstm_get_account_array($args)
    {
        $args    = $this->prepareArguments($args);
        $args    = $this->updateQueryArguments($args);
        $data    = $this->getRawResults($args);
        $results = $this->prepareAccountResults($data, $args);

        return $this->getFilteredJsonResults($results);
    }

    /**
     * Returns search results with all fixes applied
     *
     * @param array $data
     * @param array $args
     * @return array
     */
    protected function prepareAccountResults($data, $args)
    {
        $results['totalCount'] = $count = count($data);
        $results['fields']     = array();

        for ($i = 0; $i < $count; $i++) {
            $field = array();
            $field['module'] = $data[$i]->object_name;

            $field = $this->overrideAccountId($field, $data[$i], $args);
            $field = $this->updateAccountName($field, $args);

            $results['fields'][$i] = $this->prepareField($field, $args);
        }

        return $results;
    }

    /**
     * Overrides contact_id and reports_to_id params (to 'id')
     *
     * @param array $result
     * @param object $data
     * @param array $args
     * @return array
     */
    protected function overrideAccountId($result, $data, $args)
    {
        foreach ($args['field_list'] as $field) {
            $result[$field] = $data->$field;
        }

        return $result;
    }

    /**
     * Updates search result with custom account name
     *
     * @param array $result
     * @param array $args
     * @return string
     */
    protected function updateAccountName($result, $args)
    {
        global $locale;

        if ($result['module'] == 'Account' && ! isset($result['shipping_address_street']) && ! $result['shipping_address_street']) {
            $accountBean = BeanFactory::getBean('Accounts', $result['id']);
            $result['shipping_address_street'] = $accountBean->shipping_address_street;
        }
        
        $result[$args['field_list'][0]] = $result['shipping_address_street'] ? $result['name'] . " ({$result['shipping_address_street']})" : $result['name'];

        return $result;
    }

    /**
     * Internal function to construct where clauses
     *
     * @param Object $focus
     * @param array $args
     * @return string
     */
    protected function constructWhere($focus, $args)
    {
        global $db, $locale, $current_user;

        $table = $focus->getTableName();
        if (!empty($table)) {
            $table_prefix = $db->getValidDBName($table).".";
        } else {
            $table_prefix = '';
        }
        $conditionArray = array();

        if (!isset($args['conditions']) || !is_array($args['conditions'])) {
            $args['conditions'] = array();
        }

        foreach($args['conditions'] as $condition)
        {
            if (isset($condition['op'])) {
                $operator = $condition['op'];
            } else {
                $operator = null;
            }

            switch ($operator)
            {
                case self::CONDITION_CONTAINS:
                    array_push(
                        $conditionArray,
                        sprintf(
                            "%s like '%%%s%%'",
                            $table_prefix . $db->getValidDBName($condition['name']),
                            $db->quote($condition['value']
                    )));
                    break;

                case self::CONDITION_LIKE_CUSTOM:
                    $like = '';
                    if (!empty($condition['begin'])) {
                        $like .= $db->quote($condition['begin']);
                    }
                    $like .= $db->quote($condition['value']);

                    if (!empty($condition['end'])) {
                        $like .= $db->quote($condition['end']);
                    }

                    if ($focus instanceof Person){
                        $nameFormat = $locale->getLocaleFormatMacro($current_user);

                        if (strpos($nameFormat,'l') > strpos($nameFormat,'f')) {
                            array_push(
                                $conditionArray,
                                $db->concat($table, array('first_name','last_name')) . " like '$like'"
                            );
                        } else {
                            array_push(
                                $conditionArray,
                                $db->concat($table, array('last_name','first_name')) . " like '$like'"
                            );
                        }
                    }
                    else {
                        array_push(
                            $conditionArray,
                            $table_prefix . $db->getValidDBName($condition['name']) . sprintf(" like '%s'", $like)
                        );
                    }
                    break;

                case self::CONDITION_EQUAL:
                    if ($condition['value']) {
                        array_push(
                            $conditionArray,
                            sprintf("(%s = '%s')", $db->getValidDBName($condition['name']), $db->quote($condition['value']))
                            );
                    }
                    break;

                default:
                    array_push(
                        $conditionArray,
                        $table_prefix.$db->getValidDBName($condition['name']) . sprintf(" like '%s%%'", $db->quote($condition['value']))
                    );
            }
        }

        $whereClauseArray = array();
        if (!empty($conditionArray)) {
            $whereClauseArray[] = sprintf('(%s)', implode(" {$args['group']} ", $conditionArray));
        }
        if(!empty($this->extra_where)) {
            $whereClauseArray[] = "({$this->extra_where})";
        }

        if ($table == 'users') {
            $whereClauseArray[] = "users.status='Active'";
        }


        if (strpos($_REQUEST['data'], 'oem_account_c') !== false) {
            $_REQUEST['disable_security_groups_filter'] = true;
        }
        
        return implode(' AND ', $whereClauseArray);
    }
}
