<?php

class QCRM_HomepageController extends SugarController
{

    public function action_copyrole()
    {
        $homepage_id = $_POST['record'];
        $role_id = $_POST['role_id'];
        
        $homepage = new QCRM_Homepage();
        $homepage->retrieve($homepage_id);
        $homepage->copyToUsers($role_id, "");
		echo json_encode('ok');
	}

    public function action_copytoall()
    {
        $homepage_id = $_POST['record'];
        
        $homepage = new QCRM_Homepage();
        $homepage->retrieve($homepage_id);
        $homepage->copyToUsers();
		echo json_encode('ok');
	}

    public function action_editview()
    {
        global $current_user;
        $this->view = 'edit';
        
		if ($this->bean->assigned_user_id != $current_user->id){
            if (!is_admin($current_user)) {
		        $this->view = 'detail';
            }
        }
        $GLOBALS['view'] = $this->view;
    }

}