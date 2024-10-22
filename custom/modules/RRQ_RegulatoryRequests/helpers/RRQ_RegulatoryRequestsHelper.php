<?php
    handleVerifyBeforeRequire('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');

    class RRQ_RegulatoryRequestsHelper{
        public static function get_record($id)
        {
            global $db;
            $result = 0;

            $query = "select r.id,
                            r.assigned_user_id,
                            rc.id_num_c,
                            rc.user_id_c,
                            rc.status_c
                        from rrq_regulatoryrequests r
                        left join rrq_regulatoryrequests_cstm rc
                            on rc.id_c = r.id
                        where r.deleted = 0
                            and id = '{$id}'";
            $data = $db->query($query);

            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null)
            {
                $result = $rowData;
            }

    
            return $result;
        }

        public static function get_regulatory_manager_data()
        {
            global $db;
            $result = array();

            $query = "select u.id,
                        u.user_name
                    from users u
                    left join users_cstm uc
                        on uc.id_c = u.id
                    where u.deleted = 0
                        and uc.role_c = 'RegulatoryManager'";
                        $data = $db->query($query);

            while($rowData = $db->fetchByAssoc($data)){
                if($rowData != null)
                {
                    $result[] = $rowData;
                }
            }

            return $result;
        }

        public static function get_regulatory_manager(){
            $result = array();
            $regulatory_manager_data = RRQ_RegulatoryRequestsHelper::get_regulatory_manager_data();
            $regulatory_manager = (!empty($regulatory_manager_data) && count($regulatory_manager_data) > 0) ? $regulatory_manager_data[0] : null;

            if($regulatory_manager != null){
                $regulatory_manager_bean = BeanFactory::getBean('Users', $regulatory_manager['id']);
                $result = array(
                    'id' => $regulatory_manager_bean->id,
                    'email' => $regulatory_manager_bean->emailAddress->getPrimaryAddress($regulatory_manager_bean),
                    'name' => $regulatory_manager_bean->name
                );
            }

            return $result;
        }

        public static function get_content($bean){
            $result = '';
            global $sugar_config, $app_list_strings;

            $recordURL = $sugar_config['site_url'] . '/index.php?module=RRQ_RegulatoryRequests&action=DetailView&record=' . $bean->id;
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
            $status = $app_list_strings['reg_req_statuses'][$bean->status_c];

            //if($bean->status_c == 'new'){
                $result = <<<EOD
                    {$customQABanner}
                    
                    <p>Hi, <br/><br/>
                    Please review the below for slow moving regulatory request. <br/>
                    Module: Regulatory Requests <br/>
                    ID: {$bean->id_num_c} <br/>
                    Status: {$status} <br/>
                    Required Date: {$bean->req_date_c} <br/>
                    Account: {$bean->accounts_rrq_regulatoryrequests_1_name} <br/>
                    Contact: {$bean->contacts_rrq_regulatoryrequests_1_name} <br/>
                    </p>

                    <p>Click here to access the record: <a href='{$recordURL}'>{$recordURL}</a></p>
                    Thanks,
                    <br>
                    {$defaults['name']}
                    <br>
EOD;
            //}

            return $result;
        }

        public static function send_email($subject, $content, $address_arr = array()){
            global $sugar_config, $app_list_strings, $current_user, $log;

            $mail = new SugarPHPMailer();
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = $subject;

            $mail->Body = from_html($content);
            //$mail->AddAddress($current_user->emailAddress->getPrimaryAddress($current_user), $current_user->name);

            foreach($address_arr as $address){
                $mail->AddAddress($address['email'], $address['name']);
            }
            
            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
            $mail->prepForOutbound();
            $mail->Send();
        }

        public static function get_customer_product_modal_html(){
            
            return <<<EOD
            <div id="mdl-customer-product" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document" style="background-color: white;">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-weight: bolder">Add Customer Product</h5>
                    </div>
                    <div class="modal-body col-md-12">

                            <div class="search-filters row">
                                <div class="search-filter col-md-5">
                                    <span class="lbl-account-name">Account Name</span>
                                    <span class="account-name-val">
                                        <input type="text" class="form-control" name="accountName" id="accountName" value="" />
                                    </span>
                                </div>

                                <div class="search-filter col-md-5">
                                    <span class="lbl-account-name">Product #</span>
                                    <span class="account-name-val">
                                        <input type="text" class="form-control" name="productNum" id="productNum" />
                                    </span>
                                </div>

                                <div class="search-filter col-md-5">
                                    <span class="lbl-account-name">Product Name</span>
                                    <span class="account-name-val">
                                        <input type="text" class="form-control" name="productName" id="productName" />
                                    </span>
                                </div>

                                <div class="search-filter col-md-5">
                                    <span class="lbl-account-name">Customer Product #</span>
                                    <span class="account-name-val">
                                        <input type="text" class="form-control" name="custProdNum" id="custProdNum" />
                                    </span>
                                </div>

                            </div>

                            <div class="search-actions">
                                <input class="btn btn-primary" type="button" name="searchCustomerProducts" id="searchCustomerProducts" value="Search" />
                                <!-- <input class="btn btn-primary" type="button" name="clear" value="Clear" /> -->
                            </div>

                            <div class="">
                                <div id="select-all-data-btn" class="btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                    <input id="select-all-data" type="checkbox" autocomplete="off"> <span>Select All</span>
                                    </label>
                                </div>
                            </div>

                            <div class="table-responsive col-md-12">
                                <table id="tbl-customer-products" class="table table-striped display" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' id='dt-checkbox-select-all-rows' value='select_all'></th>
                                            <th>Account</th>
                                            <th>Product #</th>
                                            <th>Product Name</th>
                                            <th>Status</th>
                                            <th>Application</th>
                                            <th>OEM Account</th>
                                            <th>Customer Product #</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="cust_prod_select">Select</button>
                        <button type="button" class="btn btn-secondary" id="cust_prod_close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
EOD;
        }

        public static function get_customer_product_rows_html($reg_req_id = '', $index = 0){
            $result = <<<EOD
            <tr>
                <td><input type="text" name="product_num_{$index}" id="product_num_{$index}" class="product_num" disabled /></td>
                <td>
                    <div>
                        <input style="margin-top: 4px;" class="sqsEnabled sqsNoAutofill customer_product_name" disabled
                            autocomplete="off" type="text" name="customer_product_name[{$index}]" id="customer_product_name_{$index}" 
                            maxlength="50" value="" placeholder="">
            
                        <input type="hidden" name="customer_product_id[{$index}]" id="customer_product_id_{$index}" class="customer_product_id"  maxlength="50" value="{$reg_req_id}">

                        
                    </div>
                </td>

                <td><input type="text" name="application_{$index}" id="application_{$index}" class="application" disabled /></td>
                <td><input type="text" name="oem_account_{$index}" id="oem_account_{$index}" class="oem_account" disabled /></td>
                <td><input type="text" name="industry_{$index}" id="industry_{$index}" class="industry" disabled /></td>

                <td class="text-center" style="display: flex; padding-left: 20px; margin-top: 6px; justify-content: center">
                    <span style="margin-right: 10px;" class="btn btn-info customer-product-add glyphicon glyphicon-plus" aria-hidden="true" title="Add More"></span>
                    <span class="btn btn-info customer-product-remove glyphicon glyphicon-minus" title="Remove"></span>
                </td>
            </tr>
EOD;
            return $result;
        }

        public static function get_customer_product_rows($reg_req_id){
            $result = '';

            $i = 0;
            $customer_product_rows_html = RRQ_RegulatoryRequestsHelper::get_customer_product_rows_html($reg_req_id, $i);

            $result = $customer_product_rows_html;

            return $result;
        }

        public static function get_customer_prod_query($sort_by = 'ci_customeritems_cstm.product_number_c ASC', $limit = '50', $displayStart = '', $account_id,
            $account_name, $prod_num, $prod_name, $cust_prod_num){
            global $current_user, $log;
            
            $result = '';
            $sec_group_where = '';
            $limit_query = '';
            $prod_master_query = '';
            $offset_query = '';
            $not_in_str = '';

            if(!$current_user->is_admin){
                $sec_group_where = " AND (( ci_customeritems.assigned_user_id = '{$current_user->id}' 
                OR EXISTS (SELECT 1
                FROM   securitygroups secg
                        INNER JOIN securitygroups_users secu
                                ON secg.id = secu.securitygroup_id
                                    AND secu.deleted = 0
                                    AND secu.user_id = '{$current_user->id}'
                        INNER JOIN securitygroups_records secr
                                ON secg.id = secr.securitygroup_id
                                    AND secr.deleted = 0
                                    AND secr.module = 'CI_CustomerItems'
                WHERE  secr.record_id = ci_customeritems.id
                        AND secg.deleted = 0)))"; 
            }

            if(!empty($displayStart)){
                $offset_query = "OFFSET {$displayStart} ";
            }

            if(!empty($limit) && $limit != -1){
                $limit_query = "LIMIT {$limit} ";
            }

            if(!empty($account_id)){
                $accountBean = BeanFactory::getBean('Accounts', $account_id);

                $prod_master_query .= (isset($accountBean) && $accountBean->id && $accountBean->account_type == 'CustomerParent') 
                    ? "AND (acc.id = '{$accountBean->id}' OR acc.parent_id = '{$accountBean->id}') "
                    : "AND acc.id = '{$accountBean->id}' ";
            } else {
                if(!empty($account_name)){
                    $lower_account_name = strtolower($account_name);
                    $prod_master_query .= "AND lower(acc.name) like '%{$account_name}%' ";
                }    
            }

            if(!empty($prod_num)){
                $prod_num = strtolower($prod_num);
                $prod_master_query .= "AND lower(ci_customeritems_cstm.product_number_c) like '%{$prod_num}%' ";
            }

            if(!empty($prod_name)){
                $prod_name = strtolower($prod_name);
                $prod_master_query .= "AND lower(ci_customeritems.name) like '%{$prod_name}%' ";
            }

            if(!empty($cust_prod_num)){
                $cust_prod_num = strtolower($cust_prod_num);
                $prod_master_query .= "AND lower(ci_customeritems_cstm.customer_product_id_number_c) like '%{$cust_prod_num}%' ";
            }

            // $_GET['currentSelectedCustomerProductIds'] is set via Datatable draw to controller function: action_get_customer_products()
            // if ($_GET['isSelectAll'] == 'false' && isset($_GET['currentSelectedCustomerProductIds']) && !empty($_GET['currentSelectedCustomerProductIds'])) {
            if (isset($_GET['currentSelectedCustomerProductIds']) && !empty($_GET['currentSelectedCustomerProductIds'])) {
                $implodeIds = implode("','", json_decode(html_entity_decode($_GET['currentSelectedCustomerProductIds'])));
                $not_in_str = " AND  ci_customeritems.id NOT IN ('{$implodeIds}')";
                
            }

            //$log->fatal('prod_master_query: ' . $prod_master_query);

            $result = "SELECT distinct ci_customeritems.id,
                    ci_customeritems_cstm.application_c,
                    ci_customeritems_cstm.industry_c,
                    ci_customeritems_cstm.product_number_c,
                    ci_customeritems_cstm.version_c,
                    ci_customeritems_cstm.aos_products_id_c,
                    ci_customeritems_cstm.customer_product_id_number_c,
                    ci_customeritems.name,
                    ci_customeritems.status,
                    acc.name as account_name,
                    oem_acc.name AS oem_account_c
            FROM   ci_customeritems
            LEFT JOIN ci_customeritems_accounts_c cc
                ON cc.ci_customeritems_accountsci_customeritems_idb = ci_customeritems.id
            LEFT JOIN ci_customeritems_cstm
                ON ci_customeritems.id = ci_customeritems_cstm.id_c
                    and ci_customeritems.deleted = 0
            LEFT JOIN accounts acc
                ON acc.id = cc.ci_customeritems_accountsaccounts_ida
                    AND acc.deleted = 0
                    AND acc.deleted = 0
            LEFT JOIN accounts oem_acc ON ci_customeritems_cstm.account_id_c = oem_acc.id AND oem_acc.deleted=0
            WHERE  ci_customeritems.deleted = 0 
                {$sec_group_where} 
                {$prod_master_query} 
                {$not_in_str}
            ORDER  BY {$sort_by} 
            {$limit_query}
            {$offset_query} ";

            // $log->fatal($result);

            return $result;
        }

        public static function get_customer_products_data($sort_by = 'ci_customeritems_cstm.product_number_c ASC', $limit = '50', $displayStart, $account_id,
            $account_name, $prod_num, $prod_name, $cust_prod_num){
            global $db;

            $result = array();
            
            $sql = RRQ_RegulatoryRequestsHelper::get_customer_prod_query($sort_by, $limit, $displayStart, $account_id, $account_name, $prod_num, $prod_name, $cust_prod_num);

            $data = $db->query($sql);

            while($rowData = $db->fetchByAssoc($data)){
                if(!empty($rowData)){
                    $result[$rowData['id']] = $rowData;
                }
            }

            return $result;
        }

        public static function get_customer_products_data_count($sort_by = 'ci_customeritems_cstm.product_number_c ASC', 
            $account_id, $account_name, $prod_num, $prod_name, $cust_prod_num){
            global $db, $log;

            $result = 0;
            
            $sql = RRQ_RegulatoryRequestsHelper::get_customer_prod_query($sort_by, null, null, $account_id, $account_name, $prod_num, $prod_name, $cust_prod_num);
            $query = "select count(*) as total_count from ({$sql}) tbl";

            $data = $db->query($query);

            $rowData = $db->fetchByAssoc($data);

            if(!empty($rowData)){
                $result = $rowData['total_count'];
            }

            //$log->fatal('get_customer_products_data_count query: ' . $query);

            return $result;
        }

        public static function get_sort_column($sort_column_num){
            $result = '';

            if($sort_column_num == 1){
                $result = 'product_number_c';
            }
            else if($sort_column_num == 2){
                $result = 'name';
            }
            else if($sort_column_num == 3){
                $result = 'application_c';
            }
            else if($sort_column_num == 4){
                $result = 'oem_account_c';
            }
            else if($sort_column_num == 5){
                $result = 'industry_c';
            }
            else{
                $result = 'product_number_c';
            }

            return $result;
        }
        
        public static function filterStatusOptions($status = '')
        {
            global $log, $app_list_strings, $current_user;

            if (! $current_user->is_admin) {

                $statusArr = array_filter($app_list_strings['reg_req_statuses'], function($key) use ($status, $log) {
                    switch ($status) {
                        case 'draft':
                            return in_array($key, ['draft']);
                            break;
                        case 'new':
                            return in_array($key, ['new', 'rejected', 'awaiting_more_info', 'created_in_error', 'assigned', 'waiting_on_supplier']);
                            break;
                        case 'assigned':
                            return in_array($key, ['assigned', 'in_process', 'awaiting_more_info', 'rejected', 'complete', 'waiting_on_supplier']);
                            break;
                        case 'in_process':
                            return in_array($key, ['in_process', 'complete', 'awaiting_more_info', 'rejected', 'waiting_on_supplier']);
                            break;
                        case 'complete':
                            return in_array($key, ['complete', 'in_process']);
                            break;
                        case 'awaiting_more_info':
                            return in_array($key, ['draft','awaiting_more_info']);
                            break;
                        case 'rejected':
                            return in_array($key, ['rejected', 'draft']);
                            break;
                        case 'created_in_error':
                            return in_array($key, ['created_in_error', 'draft']);
                            break;
                        case 'waiting_on_supplier':
                            return in_array($key, ['in_process', 'waiting_on_supplier']);
                            break;
                        
                        default:
                            return $key != '';
                            break;
                    }
                }, ARRAY_FILTER_USE_KEY);

            } else {
                return $app_list_strings['reg_req_statuses'];
            }

            return $statusArr;
        }

        /**
         * Handles retrieving the Assigned User from previous status
         * @param SugarBean $bean (RRQ_RegulatoryRequests module)
         * @return User bean => Assigned User Bean
         * @author Glai Obido
         */
        public static function getPreviousAssignedUser($bean, $statusParam = '', $currentAssignedUserId = null)
        {
            global $log, $db;

            $currentAssignedUserId = (empty($currentAssignedUserId)) ? $bean->assigned_user_id : $currentAssignedUserId;
            $query = "
                SELECT 
                    *
                FROM
                    rrq_regulatoryrequests_audit
                WHERE
                    parent_id = '{$bean->id}'
                        AND ((field_name = 'status_c'
                        AND after_value_string = '{$statusParam}')
                        OR (field_name = 'assigned_user_id'
                        AND after_value_string = '{$currentAssignedUserId}'))
                ORDER BY date_created DESC
                LIMIT 2
            ";
            
            $result = $db->query($query);
            $returnObj = [];
            while ($row = $db->fetchByAssoc($result)) {
                
                // We need the before value of the assigned user id - that is the previous assigned user from prev status
                if ($row['field_name'] == 'assigned_user_id') {
                    $assignedUserId = $row['before_value_string'];
                    $userBean = BeanFactory::getBean('Users', $assignedUserId);
                    $returnObj = $userBean;
                   
                }
                
            }
            
            return $returnObj;
        }
        /**
         * Helper function to determine if User is the Regulatory Manager:
         * Compares the current user (if no User Bean is passed as parameter) if it has/is the the Regulatory Manager
         * @param RRQ_RegulatoryRequests $bean, User $bean
         * @return Boolean True if user is the Regulatory Manager, False if otherwise
         * @author: Glaiza Obido
         */
        public static function isRegulatoryManager($regulatoryRequestBean, $userBean = null)
        {
            global $log, $current_user;
            
            $customNotificationObj = new ManageTimelyNotif($regulatoryRequestBean->id);
            $regulatoryManagerUserBean = $customNotificationObj->getRegulatoryManager();
            
            if (!empty($userBean)) {
                return $regulatoryManagerUserBean->id == $userBean->id;
            } else {
                // compare to the current_user
                return $regulatoryManagerUserBean->id == $current_user->id;
            }
    
            return false;
        }

        /**
         * Helper function to determine if User has a Regulatory role:
         * Compares the current user (if no User Bean is passed as parameter) if it has/is the the Regulatory role
         * @param RRQ_RegulatoryRequests $bean, User $bean
         * @return Boolean True if user has a Regulatory, False if otherwise
         * @author: Glaiza Obido
         */
        public static function isRegulatoryUser($regulatoryRequestBean, $userBean = null)
        {
            global $log, $current_user;
            
            // $customNotificationObj = new ManageTimelyNotif($regulatoryRequestBean->id);
            // $regulatoryManagerUserBean = $customNotificationObj->getRegulatoryManager();

            $aclRolesBean = BeanFactory::getBean('ACLRoles')->retrieve_by_string_fields(
                [ 'division' => $regulatoryRequestBean->division_c, 'name' => 'Regulatory'],
                false,
                true
            );

            if ($aclRolesBean) {
                // Query Users where role id is that of $roleName
                $regulatoryUsersArr = $aclRolesBean->get_linked_beans(
                    'users', 'Users', array(), 0, -1,0,
                    "users.status='Active' "
                );
                
                if (!empty($userBean)) {
                    return in_array($userBean->id, array_column($regulatoryUsersArr, 'id'));
                } else {
                    // compare to the current_user
                    return in_array($current_user->id, array_column($regulatoryUsersArr, 'id'));
                }
            }
            
            return false;
        }

        /**
         * Helper function to determine if User has a Regulatory Manager role:
         * Compares the current user (if no User Bean is passed as parameter) if it has/is the the Regulatory Manager role
         * @param User $bean, String $division (optional)
         * @return Boolean True if user has a Regulatory Role, False if otherwise
         * @author: Glaiza Obido
         */
        public static function isRegulatoryManagerUser($userBean = null, $division = null)
        {
            global $current_user;

            $regulatoryManagerUserBean = retrieveUserBySecurityGroupTypeDivision('Regulatory Manager', 'RRWorkingGroup', NULL, $division);

            if ($regulatoryManagerUserBean) {
                if (!empty($userBean)) {
                    return $userBean->id == $regulatoryManagerUserBean->id;
                } else {
                    // compare to the current_user
                    return $current_user->id == $regulatoryManagerUserBean->id;
                }
            }
            
            return false;
        }

        
    }


?>