<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

wfm_utils::repairPhpCustom();

echo "<br><br><br><b>{$mod_strings['LBL_REPAIR_PHP_CUSTOM_DONE']}</b>";
echo '<BR><BR>';
echo '<code>gmdate=['.gmdate('Y-m-d H:i:s').']</code>';

wfm_utils::wfm_log('debug', 'EXIT', __FILE__);

?>