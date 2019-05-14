<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set assigned user id to logged user when creating new record', 'custom/modules/CI_CustomerItems/hooks/beforeSaveHook.php','beforeSaveHook', 'setAssignedUser'); 
$hook_array['before_save'][] = Array(2, 'Account - Customer Item Quick Create by cloning Item Master details to Customer Item', 'custom/modules/CI_CustomerItems/hooks/beforeSaveHook.php', 'beforeSaveHook', 'accountQuickCreateCustomerItem')


?>