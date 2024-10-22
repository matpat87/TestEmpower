<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/SecurityGroups/SecurityGroupFormBase.php');
$securityGroupForm = new SecurityGroupFormBase();
$prefix = empty($_REQUEST['dup_checked']) ? '' : 'SecurityGroups';
$securityGroupForm->handleSave($prefix, true, false);