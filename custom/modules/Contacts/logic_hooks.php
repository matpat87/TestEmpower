<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set Default Status', 'custom/modules/Contacts/hooks/before_save_hook.php','ContactsBeforeSaveHook', 'setDefaultStatus'); 
$hook_array['before_save'][] = Array(2, 'Save Distribution Items', 'custom/modules/Contacts/hooks/before_save_hook.php', 'ContactsBeforeSaveHook', 'saveDistibutionItems');
$hook_array['before_delete'] = Array(); 



?>