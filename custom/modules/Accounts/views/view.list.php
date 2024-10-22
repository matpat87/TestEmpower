<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Accounts/AccountsListViewSmarty.php');

class AccountsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */

    public function preDisplay(){
    	global $current_user;

        require_once('modules/AOS_PDF_Templates/formLetter.php');
        formLetter::LVPopupHtml('Accounts');

        // Clear filters if accessed via Menu or "View Accounts"
        if (isset($_REQUEST['parentTab']) && !empty($_REQUEST['parentTab'])) {

	        $_REQUEST = [
	        	'action' => 'index',
			    'module' => 'Accounts',
			    'searchFormTab' => 'advanced_search',
			    'query' => 'true',
                'clear_query' => 'true',
                'status_c_advanced' => [ 'Active' ],
                'orderBy' => 'NAME',
                'sortOrder' => 'ASC',
                'current_user_only_advanced' => 1
	        ];
        }
        
        parent::preDisplay();

        echo "<script src='custom/modules/Accounts/js/custom-edit.js'></script>
        <script>
            $(document).ready(function() {
                $('#mass_users_accounts_1_name').parent().find('button').attr('onclick', `open_popup(
                    'Users', 
                    600, 
                    400, 
                    '&filter_sam_results=true', 
                    true, 
                    false, 
                    {'call_back_function':'set_return','form_name':'MassUpdate','field_to_name_array':{'id':'users_accounts_1users_ida','name':'users_accounts_1_name'}}, 
                    'single', 
                    true
                    )`
                );

                $('#mass_users_accounts_2_name').parent().find('button').attr('onclick', `open_popup(
                    'Users', 
                    600, 
                    400, 
                    '&filter_mdm_results=true', 
                    true, 
                    false,
                    {'call_back_function':'set_return','form_name':'MassUpdate','field_to_name_array':{'id':'users_accounts_2users_ida','name':'users_accounts_2_name'}}, 
                    'single', 
                    true
                    )`
                );

                $('#mass_users_accounts_3_name').parent().find('button').attr('onclick', `open_popup(
                    'Users', 
                    600, 
                    400, 
                    '&department=CustomerService', 
                    true, 
                    false,
                    {'call_back_function':'set_return','form_name':'MassUpdate','field_to_name_array':{'id':'users_accounts_3users_ida','name':'users_accounts_3_name'}}, 
                    'single', 
                    true
                    )`
                );
                
                var closePopup = setInterval(function() {
                    $('.ui-dialog').find('.open').dialog('close');
                }, 300);

                $(`.suitepicon.suitepicon-action-info`)
                .removeAttr('title')
                .hover(function() {
                    $(this).trigger('click');
                    clearInterval(closePopup);
                }, function() {
                    closePopup = setInterval(function() {
                        $('.ui-dialog').find('.open').dialog('close');
                    }, 300);

                    closePopup;                     
                });
                    

                customRelateFieldAutocomplete(['Users'], 'users_accounts_1_name', 'MassUpdate_', {
                    'name': 'role_c', // name of field to apply filter
                    'op': 'equal', // Operator
                    'value': 'StrategicAccountManager' // Value to compare
                });
            
                customRelateFieldAutocomplete(['Users'], 'users_accounts_2_name', 'MassUpdate_', {
                    'name': 'role_c', // name of field to apply filter
                    'op': 'equal', // Operator
                    'value': 'MarketDevelopmentManager' // Value to compare
                });

                customRelateFieldAutocomplete(['Users'], 'users_accounts_3_name', 'MassUpdate_', {
                    'name': 'users.department', // name of field to apply filter
                    'op': 'equal', // Operator
                    'value': 'CustomerService' // Value to compare
                });

                customRelateFieldAutocomplete(['Users'], 'users_accounts_1_name_advanced', 'search_form_', {
                    'name': 'role_c', // name of field to apply filter
                    'op': 'equal', // Operator
                    'value': 'StrategicAccountManager' // Value to compare
                });
            
                customRelateFieldAutocomplete(['Users'], 'users_accounts_2_name_advanced', 'search_form_', {
                    'name': 'role_c', // name of field to apply filter
                    'op': 'equal', // Operator
                    'value': 'MarketDevelopmentManager' // Value to compare
                });

                function customRelateFieldAutocomplete(moduleArray, field, formName, conditions) {
                    var fieldName= field; // field name to override SQS
                
                    var sqsId = formName + fieldName;
                    sqs_objects[sqsId]['method'] = 'query';
                    sqs_objects[sqsId]['modules'] = moduleArray;
                    sqs_objects[sqsId]['field_list'] = ['name', 'id'];
                    sqs_objects[sqsId]['conditions'] = [{
                        'name': 'name',
                        'op': 'like_custom',
                        'end': '%',
                        'value': ''
                    }, conditions
                    ];
                    sqs_objects[sqsId]['group'] = 'and';
                } 
            });
        </script>";

        $this->lv = new AccountsListViewSmarty();
        $this->removeDeleteButtonBasedOnRole();
    }

    public function removeDeleteButtonBasedOnRole() {
        global $current_user, $db;

        if(!$current_user->isAdmin()) {
            $db = DBManagerFactory::getInstance();
            $sql = "SELECT access_override FROM acl_roles_users 
                    LEFT JOIN acl_roles
                        ON acl_roles.id = acl_roles_users.role_id
                    LEFT JOIN acl_roles_actions
                        ON acl_roles_actions.role_id = acl_roles.id
                    LEFT JOIN acl_actions
                        ON acl_actions.id = acl_roles_actions.action_id
                    WHERE acl_roles_users.user_id = '".$current_user->id."'
                        AND category = 'Accounts'
                        AND acl_actions.name = 'delete'
                        AND acl_roles.deleted = 0
                        AND acl_actions.deleted = 0
                        AND acl_roles_actions.deleted = 0
                        AND acl_roles_users.deleted = 0
                    UNION
                    SELECT access_override FROM securitygroups_users 
                    LEFT JOIN securitygroups_acl_roles
                        ON securitygroups_acl_roles.securitygroup_id = securitygroups_users.securitygroup_id
                    LEFT JOIN acl_roles
                        ON acl_roles.id = securitygroups_acl_roles.role_id
                    LEFT JOIN acl_roles_actions
                        ON acl_roles_actions.role_id = acl_roles.id
                    LEFT JOIN acl_actions
                        ON acl_actions.id = acl_roles_actions.action_id
                    WHERE user_id = '".$current_user->id."'
                    AND category = 'Accounts'
                    AND acl_actions.name = 'delete'
                    AND securitygroups_users.deleted = 0
                    AND acl_roles.deleted = 0
                    AND acl_actions.deleted = 0
                    AND acl_roles_actions.deleted = 0;";
            $result = $db->query($sql);

            while($row = $db->fetchByAssoc($result))
            {
                if($row['access_override'] == -99) {
                    // Hid the button using Javascript instead since it produces Notice errors when hiding the button via $this->lv->delete = false;
                    echo "<script>
                            $(\"a[id^='delete_listview']\").remove();
                        </script>";
                    break;
                }
            }
        }
    }
}