<?php

require_once('include/MVC/Controller/SugarController.php');
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class SecurityGroupsController extends SugarController
{
    public function action_check_if_duplicate_exists()
    {
        $postData = (isset($_POST['postData']) && $_POST['postData']) ? $_POST['postData'] : [];
        $response = SecurityGroupHelper::handleDuplicateCheck($postData);
        echo json_encode($response);
    }
}
