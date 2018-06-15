<?php

if(ACLController::checkAccess('asol_Process', 'list', true)) $module_menu[]=Array("index.php?module=asol_Process&action=index", translate("LBL_ASOL_ALINEASOL_WFM", "asol_ProcessInstances"),"asol_Process");