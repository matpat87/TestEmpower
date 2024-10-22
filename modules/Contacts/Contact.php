<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/SugarObjects/templates/person/Person.php');
require_once __DIR__ . '/../../include/EmailInterface.php';

// Contact is used to store customer information.
#[\AllowDynamicProperties]
class Contact extends Person implements EmailInterface
{
    public $field_name_map;
    // Stored fields
    public $id;
    public $name = '';
    public $lead_source;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $assigned_user_id;
    public $created_by;
    public $created_by_name;
    public $modified_by_name;

    public $description;
    public $salutation;
    public $first_name;
    public $last_name;
    public $title;
    public $department;
    public $birthdate;
    public $reports_to_id;
    public $do_not_call;
    public $phone_home;
    public $phone_mobile;
    public $phone_work;
    public $phone_other;
    public $phone_fax;
    public $email1;
    public $email_and_name1;
    public $email_and_name2;
    public $email2;
    public $assistant;
    public $assistant_phone;
    public $email_opt_out;
    public $primary_address_street;
    public $primary_address_city;
    public $primary_address_state;
    public $primary_address_postalcode;
    public $primary_address_country;
    public $alt_address_street;
    public $alt_address_city;
    public $alt_address_state;
    public $alt_address_postalcode;
    public $alt_address_country;
    public $portal_name;
    public $portal_app;
    public $portal_active;
    public $contacts_users_id;
    // These are for related fields
    public $bug_id;
    public $account_name;
    public $account_id;
    public $report_to_name;
    public $opportunity_role;
    public $opportunity_rel_id;
    public $opportunity_id;
    public $case_role;
    public $case_rel_id;
    public $case_id;
    public $task_id;
    public $note_id;
    public $meeting_id;
    public $call_id;
    public $email_id;
    public $assigned_user_name;
    public $accept_status;
    public $accept_status_id;
    public $accept_status_name;
    public $alt_address_street_2;
    public $alt_address_street_3;
    public $opportunity_role_id;
    public $portal_password;
    public $primary_address_street_2;
    public $primary_address_street_3;
    public $campaign_id;
    public $sync_contact;
    public $full_name; // l10n localized name
    public $invalid_email;
    public $table_name = "contacts";
    public $rel_account_table = "accounts_contacts";
    //This is needed for upgrade.  This table definition moved to Opportunity module.
    public $rel_opportunity_table = "opportunities_contacts";

    public $object_name = "Contact";
    public $module_dir = 'Contacts';
    public $new_schema = true;
    public $importable = true;

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = array(
        'bug_id',
        'assigned_user_name',
        'account_name',
        'account_id',
        'opportunity_id',
        'case_id',
        'task_id',
        'note_id',
        'meeting_id',
        'call_id',
        'email_id'
    );

    public $relationship_fields = array(
        'account_id' => 'accounts',
        'bug_id' => 'bugs',
        'call_id' => 'calls',
        'case_id' => 'cases',
        'email_id' => 'emails',
        'meeting_id' => 'meetings',
        'note_id' => 'notes',
        'task_id' => 'tasks',
        'opportunity_id' => 'opportunities',
        'contacts_users_id' => 'user_sync'
    );

    public function __construct()
    {
        parent::__construct();
    }




    public function add_list_count_joins(&$query, $where)
    {
        // accounts.name
        if (stristr((string) $where, "accounts.name")) {
            // add a join to the accounts table.
            $query .= "
	            LEFT JOIN accounts_contacts
	            ON contacts.id=accounts_contacts.contact_id
	            LEFT JOIN accounts
	            ON accounts_contacts.account_id=accounts.id
			";
        }
        $custom_join = $this->getCustomJoin();
        $query .= $custom_join['join'];
    }

    public function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();
        $is_owner = false;
        //MFH BUG 18281; JChi #15255
        $is_owner = !empty($this->assigned_user_id) && $this->assigned_user_id == $GLOBALS['current_user']->id;
        if (!ACLController::moduleSupportsACL('Accounts') || ACLController::checkAccess(
            'Accounts',
            'view',
            $is_owner
        )
        ) {
            $array_assign['ACCOUNT'] = 'a';
        } else {
            $array_assign['ACCOUNT'] = 'span';
        }

        return $array_assign;
    }

    // APX Custom Codes -- START
    public function create_new_list_query(
        $order_by,
        $where,
        $filter = array(),
        $params = array(),
        $show_deleted = 0,
        $join_type = '',
        $return_array = false,
        $parentbean = null,
        $singleSelect = false,
        $ifListForExport = false
    ) {
        global $log, $app;

        // APX Custom Codes: Fix email_opt_out unknown column issue
        $where = str_ireplace('email_opt_out', 'email_addresses.opt_out', $where);

        // APX Custom Codes: OnTrack #1917 -- START
        // If SELECT ALL is triggered on Popup/Mass Update/Delete (Save2.php line 170)
        if (!empty($_REQUEST['select_entire_list']) &&  $_REQUEST['select_entire_list'] != 'undefined' && isset($_REQUEST['current_query_by_page'])) {
            $current_query_by_page = $_REQUEST['current_query_by_page'];
            $current_query_by_page_array = json_decode(html_entity_decode($current_query_by_page), true);
            $this->handleNullKeywordQueries($where, $current_query_by_page_array);

            $popupSelectAllQuery = parent::create_new_list_query(
                $order_by,
                $where,
                $filter,
                $params,
                $show_deleted,
                $join_type,
                $return_array,
                $parentbean,
                $singleSelect,
                $ifListForExport
            );

            // Need to add custom join if triggered via SELECT ALL on Popup to fix DB failed issue
            if ($_REQUEST['action'] == 'Save2') {
                $popupSelectAllQuery = str_ireplace_first(
                    "where",
                    " 
                        LEFT JOIN accounts_contacts ON contacts.id=accounts_contacts.contact_id AND accounts_contacts.deleted = 0
                        LEFT JOIN accounts ON accounts_contacts.account_id=accounts.id AND accounts.deleted = 0 
                        LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = contacts.id AND email_addr_bean_rel.bean_module = '{$this->module_dir}' AND email_addr_bean_rel.primary_address = 1 AND email_addr_bean_rel.deleted = 0
                        LEFT JOIN email_addresses ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addresses.deleted = 0 AND email_addresses.invalid_email = 0
                        WHERE 
                    ",
                    $popupSelectAllQuery
                );
            }

            return $popupSelectAllQuery;
        } else {
            $this->handleNullKeywordQueries($where);
        }
        // APX Custom Codes: OnTrack #1917 -- END


        //if this is from "contact address popup" action, then process popup list query
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ContactAddressPopup') {
            return $this->address_popup_create_new_list_query(
                $order_by,
                $where,
                $filter,
                $params,
                $show_deleted,
                $join_type,
                $return_array,
                $parentbean,
                $singleSelect,
                $ifListForExport
            );
        } else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'quicksearchQuery') {
            return $this->quick_search_new_list_query(
                $order_by,
                $where,
                $filter,
                $params,
                $show_deleted,
                $join_type,
                $return_array,
                $parentbean,
                $singleSelect,
                $ifListForExport
            );
        } else {
            //any other action goes to parent function in sugarbean
            if (strpos((string) $order_by, 'sync_contact') !== false) {
                //we have found that the user is ordering by the sync_contact field, it would be troublesome to sort by this field
                //and perhaps a performance issue, so just remove it
                $order_by = '';
            }

            // APX Custom Codes: Fix issue where list view total display is incorrect -- START
            $result =  parent::create_new_list_query(
                $order_by,
                $where,
                $filter,
                $params,
                $show_deleted,
                $join_type,
                $return_array,
                $parentbean,
                $singleSelect,
                $ifListForExport
            );

            if ($return_array) {
                // Need to filter DISTINCT to remove duplicates on list view BUT also show contacts where it's related to multiple accounts
                $result['select'] = str_ireplace('contacts.id', 'DISTINCT(contacts.id)', $result['select']);

                // Need to add GROUP BY on Popup as you don't need duplicate contact IDs when linking to a record as it would only insert once
                // Does not matter which account it belongs to if a contact is related to multiple accounts we only need one non-duplicate contact IDs to display
                if ($_REQUEST['action'] == 'Popup') {
                    $result['where'] .= " GROUP BY contacts.id ";
                }

                $result['from'] .= "
                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = contacts.id AND email_addr_bean_rel.bean_module = '{$this->module_dir}' AND email_addr_bean_rel.primary_address = 1 AND email_addr_bean_rel.deleted = 0
                    LEFT JOIN email_addresses ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addresses.deleted = 0 AND email_addresses.invalid_email = 0
                ";
            }

            return $result;
            // APX Custom Codes: Fix issue where list view total display is incorrect -- END
        }
    }

    // APX Custom Codes: Need to extend create_list_count_query to fix counting issue and match list view and export count -- START
    public function create_list_count_query($query, $params=array())
    {
        // Fix count issue showing up as 1 due to GROUP BY custom query
        if (strpos($query, 'GROUP BY contacts.id') !== false) {
            $query = str_replace('GROUP BY contacts.id', '', $query);
        }

        $result =  parent::create_list_count_query($query);

        // Custom list view count to match create_new_list_query and create_export_query count
        // A contact can have many accounts, so we need to group them as such to retrieve correct count
        if ($_REQUEST['action'] == 'index' && $_REQUEST['module'] == $this->module_dir) {
            // Only modify GROUP BY with accounts.id if it exists in the SELECT query
            if (strpos($query, 'accounts.id') !== false) {
                $result = " SELECT COUNT(*) AS c FROM ( {$result} GROUP BY contacts.id, accounts.id ) AS total_count ";
            }
        }

        return $result;
    }
    // APX Custom Codes: Need to extend create_list_count_query to fix counting issue and match list view and export count -- END

    private function quick_search_new_list_query($order_by, $where, $filter = array(),
        $params = array(), $show_deleted = 0, $join_type = '',
        $return_array = false, $parentbean = null, $singleSelect = false, $ifListForExport = false)
    {
        global $log;
        $data = (isset($_POST['data'])) ? json_decode(htmlspecialchars_decode($_POST['data']), true) : null;

        if ($data['conditions'][1]['name'] !== 'account_c') {
            $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type,
                    $return_array, $parentbean, $singleSelect, $ifListForExport);
        } else {
            if(!empty($data) && !empty($data['conditions']) && !empty($data['conditions'][1])){
                $where = str_replace('contacts.account_c', 'ac.account_id', $where);
            }
    
            $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type,
                    $return_array, $parentbean, $singleSelect, $ifListForExport);
    
            //This will only be invoked by adding secondary condition in SQS
            if(!empty($data) && !empty($data['conditions']) && !empty($data['conditions'][1])){
                $where_position = strpos($query, 'where');
                $account_contacts_join = " INNER JOIN accounts_contacts ac
                on ac.contact_id = contacts.id
                    and ac.account_id = '{$data['conditions'][1]['value']}' ";
                $query = substr_replace($query, $account_contacts_join, $where_position, 0);
            }
        }

        return $query;
    }
    // APX Custom Codes -- END

    public function address_popup_create_new_list_query(
        $order_by,
        $where,
        $filter = array(),
        $params = array(),
        $show_deleted = 0,
        $join_type = '',
        $return_array = false,
        $parentbean = null,
        $singleSelect = false
    ) {
        //if this is any action that is not the contact address popup, then go to parent function in sugarbean
        if (isset($_REQUEST['action']) && $_REQUEST['action'] !== 'ContactAddressPopup') {
            return parent::create_new_list_query(
                $order_by,
                $where,
                $filter,
                $params,
                $show_deleted,
                $join_type,
                $return_array,
                $parentbean,
                $singleSelect
            );
        }

        $custom_join = $this->getCustomJoin();
        // MFH - BUG #14208 creates alias name for select
        $select_query = "SELECT ";
        $select_query .= $this->db->concat($this->table_name, array('first_name', 'last_name')) . " name, ";
        $select_query .= "
				$this->table_name.*,
                accounts.name as account_name,
                accounts.id as account_id,
                accounts.assigned_user_id account_id_owner,
                users.user_name as assigned_user_name ";
        $select_query .= $custom_join['select'];
        $ret_array = [];
        $ret_array['select'] = $select_query;

        $from_query = "
                FROM contacts ";

        $from_query .= "LEFT JOIN users
	                    ON contacts.assigned_user_id=users.id
	                    LEFT JOIN accounts_contacts
	                    ON contacts.id=accounts_contacts.contact_id  and accounts_contacts.deleted = 0
	                    LEFT JOIN accounts
	                    ON accounts_contacts.account_id=accounts.id AND accounts.deleted=0 ";
        $from_query .= "LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = contacts.id AND eabl.bean_module = 'Contacts' and eabl.primary_address = 1 and eabl.deleted=0 ";
        $from_query .= "LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id) ";
        $from_query .= $custom_join['join'];
        $ret_array['from'] = $from_query;
        $ret_array['from_min'] = 'from contacts';

        $where_auto = '1=1';
        if ($show_deleted == 0) {
            $where_auto = " $this->table_name.deleted=0 ";
        //$where_auto .= " AND accounts.deleted=0  ";
        } elseif ($show_deleted == 1) {
            $where_auto = " $this->table_name.deleted=1 ";
        }


        if ($where != "") {
            $where_query = "where ($where) AND " . $where_auto;
        } else {
            $where_query = "where " . $where_auto;
        }


        $ret_array['where'] = $where_query;
        $ret_array['order_by'] = '';

        //process order by and add if it's not empty
        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $ret_array['order_by'] = ' ORDER BY ' . $order_by;
        }

        if ($return_array) {
            return $ret_array;
        }

        return $ret_array['select'] . $ret_array['from'] . $ret_array['where'] . $ret_array['order_by'];
    }


    public function create_export_query($order_by, $where, $relate_link_join = '')
    {
        // APX Custom Codes: Fix email_opt_out unknown column issue -- START
        $where = str_ireplace('email_opt_out', 'email_addresses.opt_out', $where);
        // APX Custom Codes: Fix email_opt_out unknown column issue -- END

        $custom_join = $this->getCustomJoin(true, true, $where);
        $custom_join['join'] .= $relate_link_join;

        // APX Custom Codes: Fix export data incorrect results issue -- START
        // Need to add DISTINCT(contacts.id) and accounts.id to retrieve correct data
        // Need to fix LEFT JOIN conditions to retrieve correct data (users, accounts_contacts, accounts, email_addresses)
        $query = "SELECT
                                DISTINCT(contacts.id),
                                contacts.*,
                                email_addresses.email_address email_address,
                                '' email_addresses_non_primary, " . // email_addresses_non_primary needed for get_field_order_mapping()
            "accounts.name as account_name,
                                accounts.id as account_id,
                                users.user_name as assigned_user_name ";
        $query .= $custom_join['select'];
        $query .= " FROM contacts ";
        $query .= "LEFT JOIN users
	                                ON contacts.assigned_user_id=users.id AND users.deleted = 0 ";
        $query .= "LEFT JOIN accounts_contacts
	                                ON contacts.id=accounts_contacts.contact_id and accounts_contacts.deleted = 0
	                                LEFT JOIN accounts
	                                ON accounts_contacts.account_id=accounts.id and accounts.deleted=0 ";

        //join email address table too.
        $query .= ' LEFT JOIN  email_addr_bean_rel on contacts.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module=\'Contacts\' and email_addr_bean_rel.deleted=0 and email_addr_bean_rel.primary_address=1 ';

        // APX Custom Codes: OnTrack #1912 -- START
        $query .= ' LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id AND email_addresses.deleted = 0 AND email_addresses.invalid_email = 0 ';
        // APX Custom Codes: OnTrack #1912 -- END

        $query .= $custom_join['join'];

        $where_auto = " contacts.deleted=0 ";
        // APX Custom Codes: Fix export data incorrect results issue -- END

        // APX Custom Codes: OnTrack #1917 -- START
        $current_post = $_REQUEST['current_post'];
        $current_post_array = json_decode(html_entity_decode($current_post), true);
        $this->handleNullKeywordQueries($where, $current_post_array);
        // APX Custom Codes: OnTrack #1917 -- END

        if ($where != "") {
            $query .= "where ($where) AND " . $where_auto;
        } else {
            $query .= "where " . $where_auto;
        }

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query .= ' ORDER BY ' . $order_by;
        }

        return $query;
    }

    public function fill_in_additional_list_fields()
    {
        parent::fill_in_additional_list_fields();
        $this->_create_proper_name_field();
        // cn: bug 8586 - l10n names for Contacts in Email TO: field
        $this->email_and_name1 = "{$this->full_name} &lt;" . $this->email1 . "&gt;";
        $this->email_and_name2 = "{$this->full_name} &lt;" . $this->email2 . "&gt;";

        if ($this->force_load_details == true) {
            $this->fill_in_additional_detail_fields();
        }
    }

    public function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();
        if (empty($this->id)) {
            return;
        }

        global $locale, $app_list_strings, $current_user;

        // retrieve the account information and the information about the person the contact reports to.
        $query = "SELECT acc.id, acc.name, con_reports_to.first_name, con_reports_to.last_name
		from contacts
		left join accounts_contacts a_c on a_c.contact_id = '" . $this->id . "' and a_c.deleted=0
		left join accounts acc on a_c.account_id = acc.id and acc.deleted=0
		left join contacts con_reports_to on con_reports_to.id = contacts.reports_to_id
		where contacts.id = '" . $this->id . "'";
        // Bug 43196 - If a contact is related to multiple accounts, make sure we pull the one we are looking for
        // Bug 44730  was introduced due to this, fix is to simply clear any whitespaces around the account_id first

        $clean_account_id = trim($this->account_id);

        if (!empty($clean_account_id)) {
            $query .= " and acc.id = '{$this->account_id}'";
        }

        $query .= " ORDER BY a_c.date_modified DESC";

        $result = $this->db->query($query, true, " Error filling in additional detail fields: ");

        // Get the id and the name.
        $row = $this->db->fetchByAssoc($result);

        if ($row != null) {
            $this->account_name = $row['name'];
            $this->account_id = $row['id'];
            if (null === $locale || !is_object($locale) || !method_exists($locale, 'getLocaleFormattedName')) {
                $GLOBALS['log']->fatal('Call to a member function getLocaleFormattedName() on ' . gettype($locale));
            } else {
                $this->report_to_name = $locale->getLocaleFormattedName(
                    $row['first_name'],
                    $row['last_name'],
                    '',
                    '',
                    '',
                    null,
                    true
                );
            }
        } else {
            $this->account_name = '';
            $this->account_id = '';
            $this->report_to_name = '';
        }
        $this->load_contacts_users_relationship();
        /** concating this here because newly created Contacts do not have a
         * 'name' attribute constructed to pass onto related items, such as Tasks
         * Notes, etc.
         */
        $this->name = $locale->getLocaleFormattedName($this->first_name, $this->last_name);
        if (!empty($this->contacts_users_id)) {
            $this->sync_contact = true;
        }

        if (!empty($this->portal_active) && $this->portal_active == 1) {
            $this->portal_active = true;
        }
        // Set campaign name if there is a campaign id
        if (!empty($this->campaign_id)) {
            $camp = BeanFactory::newBean('Campaigns');
            $where = "campaigns.id='{$this->campaign_id}'";
            $campaign_list = $camp->get_full_list("campaigns.name", $where, true);
            if (!empty($campaign_list) && !empty($campaign_list[0]->name)) {
                $this->campaign_name = $campaign_list[0]->name;
            }
        }
    }

    /**
     * loads the contacts_users relationship to populate a checkbox
     * where a user can select if they would like to sync a particular
     * contact to Outlook
     */
    public function load_contacts_users_relationship()
    {
        global $current_user;

        $this->load_relationship("user_sync");

        if (!isset($this->user_sync)) {
            $GLOBALS['log']->fatal('Contact::$user_sync is not set');
            $beanIDs = null;
        } elseif (!is_object($this->user_sync)) {
            $GLOBALS['log']->fatal('Contact::$user_sync is not an object');
            $beanIDs = null;
        } elseif (!method_exists($this->user_sync, 'get')) {
            $GLOBALS['log']->fatal('Contact::$user_sync::get() is not a function');
            $beanIDs = null;
        } else {
            $beanIDs = $this->user_sync->get();
        }

        if (in_array($current_user->id, $beanIDs)) {
            $this->contacts_users_id = $current_user->id;
        }
    }

    public function get_list_view_data($filter_fields = array())
    {
        $temp_array = parent::get_list_view_data();

        if ($filter_fields && !empty($filter_fields['sync_contact'])) {
            $this->load_contacts_users_relationship();
            $temp_array['SYNC_CONTACT'] = !empty($this->contacts_users_id) ? 1 : 0;
        }

        $temp_array['EMAIL_AND_NAME1'] = "{$this->full_name} &lt;" . $temp_array['EMAIL1'] . "&gt;";

        return $temp_array;
    }

    /**
     * builds a generic search based on the query string using or
     * do not include any $this-> because this is called on without having the class instantiated
     */
    public function build_generic_where_clause($the_query_string)
    {
        $where_clauses = array();
        $the_query_string = $this->db->quote($the_query_string);

        array_push($where_clauses, "contacts.last_name like '$the_query_string%'");
        array_push($where_clauses, "contacts.first_name like '$the_query_string%'");
        array_push($where_clauses, "accounts.name like '$the_query_string%'");
        array_push($where_clauses, "contacts.assistant like '$the_query_string%'");
        array_push($where_clauses, "ea.email_address like '$the_query_string%'");

        if (is_numeric($the_query_string)) {
            array_push($where_clauses, "contacts.phone_home like '%$the_query_string%'");
            array_push($where_clauses, "contacts.phone_mobile like '%$the_query_string%'");
            array_push($where_clauses, "contacts.phone_work like '%$the_query_string%'");
            array_push($where_clauses, "contacts.phone_other like '%$the_query_string%'");
            array_push($where_clauses, "contacts.phone_fax like '%$the_query_string%'");
            array_push($where_clauses, "contacts.assistant_phone like '%$the_query_string%'");
        }

        $the_where = "";
        foreach ($where_clauses as $clause) {
            if ($the_where != "") {
                $the_where .= " or ";
            }
            $the_where .= $clause;
        }


        return $the_where;
    }

    public function set_notification_body($xtpl, $contact)
    {
        global $locale;

        $xtpl->assign("CONTACT_NAME", trim($locale->getLocaleFormattedName($contact->first_name, $contact->last_name)));
        $xtpl->assign("CONTACT_DESCRIPTION", nl2br($contact->description));

        return $xtpl;
    }

    public function get_contact_id_by_email($email)
    {
        $email = trim($email);
        if (empty($email)) {
            //email is empty, no need to query, return null
            return null;
        }

        $where_clause = "(email1='$email' OR email2='$email') AND deleted=0";

        $query = "SELECT id FROM $this->table_name WHERE $where_clause";
        $GLOBALS['log']->debug("Retrieve $this->object_name: " . $query);
        $result = $this->db->getOne($query, true, "Retrieving record $where_clause:");

        return empty($result) ? null : $result;
    }

    public function save_relationship_changes($is_update, $exclude = array())
    {

        //if account_id was replaced unlink the previous account_id.
        //this rel_fields_before_value is populated by sugarbean during the retrieve call.
        if (!empty($this->account_id) && !empty($this->rel_fields_before_value['account_id']) && trim($this->account_id) !== trim($this->rel_fields_before_value['account_id'])
        ) {
            //unlink the old record.
            $this->load_relationship('accounts');
            $this->accounts->delete($this->id, $this->rel_fields_before_value['account_id']);
        }
        parent::save_relationship_changes($is_update);
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    public function get_unlinked_email_query($type = array())
    {
        return get_unlinked_email_query($type, $this);
    }

    /**
     * used by import to add a list of users
     *
     * Parameter can be one of the following:
     * - string 'all': add this contact for all users
     * - comma deliminated lists of teams and/or users
     *
     * @param string $list_of_user
     */
    public function process_sync_to_outlook($list_of_users)
    {
        static $focus_user;

        // cache this object since we'll be reusing it a bunch
        if (!($focus_user instanceof User)) {
            $focus_user = BeanFactory::newBean('Users');
        }


        if (empty($list_of_users)) {
            return;
        }
        if (!isset($this->users)) {
            $this->load_relationship('user_sync');
        }

        if (strtolower($list_of_users) == 'all') {
            // add all non-deleted users
            $sql = "SELECT id FROM users WHERE deleted=0 AND is_group=0 AND portal_only=0";
            $result = $this->db->query($sql);
            while ($hash = $this->db->fetchByAssoc($result)) {
                if (!isset($this->user_sync)) {
                    $GLOBALS['log']->fatal('Contact::$user_sync is not set');
                } elseif (!is_object($this->user_sync)) {
                    $GLOBALS['log']->fatal('Contact::$user_sync is not an object');
                } elseif (!method_exists($this->user_sync, 'add')) {
                    $GLOBALS['log']->fatal('Contact::$user_sync::add() is not a function');
                } else {
                    $this->user_sync->add($hash['id']);
                }
            }
        } else {
            $theList = explode(",", $list_of_users);
            foreach ($theList as $eachItem) {
                if (($user_id = $focus_user->retrieve_user_id($eachItem))
                    || $focus_user->retrieve($eachItem)
                ) {
                    // it is a user, add user
                    if (!isset($this->user_sync)) {
                        $GLOBALS['log']->fatal('Contact::$user_sync is not set');
                    } elseif (!is_object($this->user_sync)) {
                        $GLOBALS['log']->fatal('Contact::$user_sync is not an object');
                    } elseif (!method_exists($this->user_sync, 'add')) {
                        $GLOBALS['log']->fatal('Contact::$user_sync::add() is not a function');
                    } else {
                        $this->user_sync->add($user_id ? $user_id : $focus_user->id);
                    }

                    return;
                }
            }
        }
    }

    // APX Custom Codes: OnTrack #1917 -- START
    public function handleNullKeywordQueries(&$where, $dataArray = null)
    {
        $dataArray = (! $dataArray) ? $_REQUEST : $dataArray;
        $nullAcceptingFields = ['account_name', 'first_name', 'last_name', 'email'];

        // Used to filter Contact Popup Active Accounts
        $where = str_ireplace('account_status_non_db', '(SELECT accounts_cstm.status_c FROM accounts_cstm WHERE accounts_cstm.id_c = accounts.id)', $where);

        foreach ($nullAcceptingFields as $field) {
            if (isset($dataArray["{$field}_advanced"]) && strtolower($dataArray["{$field}_advanced"]) == 'null') {
                if (in_array($field, ['account_name'])) {
                    $where = str_ireplace("accounts.name LIKE '%{$dataArray["{$field}_advanced"]}%'", "(accounts.name IS NULL OR accounts.name = '')", $where);
                }

                if (in_array($field, ['first_name', 'last_name'])) {
                    $where = str_ireplace("contacts.{$field} LIKE '%{$dataArray["{$field}_advanced"]}%'", "(contacts.{$field} IS NULL OR contacts.{$field} = '')", $where);
                }

                if (in_array($field, ['email'])) {
                    $where = str_ireplace("contacts.id IN (select bean_id", "contacts.id NOT IN (select bean_id", $where);
                    $where = str_ireplace("ea.email_address LIKE '{$dataArray["{$field}_advanced"]}%'", "(ea.email_address IS NOT NULL OR ea.email_address <> '')", $where);
                }
            }

            if (isset($dataArray["{$field}_advanced"]) && strtolower($dataArray["{$field}_advanced"]) == 'not null') {
                if (in_array($field, ['account_name'])) {
                    $where = str_ireplace("accounts.name LIKE '%{$dataArray["{$field}_advanced"]}%'", "(accounts.name IS NOT NULL AND accounts.name <> '')", $where);
                }

                if (in_array($field, ['first_name', 'last_name'])) {
                    // When string has spaces it automatically gets converted to a format where it has LTRIM, RTRIM, etc...
                    $where = str_ireplace(
                        "LTRIM(RTRIM(CONCAT(IFNULL(contacts.{$field},'')))) LIKE '{$dataArray["{$field}_advanced"]}%' OR LTRIM(RTRIM(CONCAT(IFNULL(contacts.{$field},'')))) LIKE '{$dataArray["{$field}_advanced"]}%'",
                        "contacts.{$field} IS NOT NULL AND contacts.{$field} <> ''", // No need to add () as it has it already for strings with spaces
                        $where
                    );

                    $where = str_ireplace("contacts.{$field} LIKE '%{$dataArray["{$field}_advanced"]}%'", "(contacts.{$field} IS NOT NULL AND contacts.{$field} <> '')", $where);
                }

                if (in_array($field, ['email'])) {
                    $where = str_ireplace("ea.email_address LIKE '{$dataArray["{$field}_advanced"]}%'", "(ea.email_address IS NOT NULL AND ea.email_address <> '')", $where);
                }
            }
        }
    }
    // APX Custom Codes: OnTrack #1917 -- END
}
