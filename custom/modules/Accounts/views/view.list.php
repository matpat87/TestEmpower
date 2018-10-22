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
        if( (isset($_REQUEST['parentTab']) && !empty($_REQUEST['parentTab'])) || ((isset($_REQUEST['return_module']) && !empty($_REQUEST['return_module'])) && (isset($_REQUEST['return_action']) && !empty($_REQUEST['return_action']))) ) {

	        $_REQUEST = [
	        	'action' => 'index',
			    'module' => 'Accounts',
			    'searchFormTab' => 'advanced_search',
			    'query' => 'true',
			    'clear_query' => 'true',
                'orderBy' => 'NAME',
                'sortOrder' => 'ASC'
	        ];
        }

        // Set default filter to logged user (if not admin) when accessing accounts list view
        if(!$current_user->isAdmin() && !isset($_REQUEST['assigned_user_id_advanced'])) {
        	$_REQUEST['assigned_user_id_advanced'][0] = $current_user->id;
        }

        parent::preDisplay();
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