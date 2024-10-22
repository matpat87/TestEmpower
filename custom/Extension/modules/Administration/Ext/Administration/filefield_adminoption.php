<?php
/*********************************************************************************
 * This file is part of package File Field addon.
 * 
 * Author : NS-Team (http://www.ns-team.fr)
 * All rights (c) 2016 by NS-Team
 *
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at infos@ns-team.fr
 * 
 ********************************************************************************/

$admin_option_defs=array();
if(preg_match( "/^6.*/", $sugar_version) ) {
    $admin_option_defs['Administration']['ff_info']= array('helpInline','LBL_FILEFIELD_LICENSE_TITLE','LBL_FILEFIELD_LICENSE','./index.php?module=FileField&action=license');
} else {
    $admin_option_defs['Administration']['ff_info']= array('helpInline','LBL_FILEFIELD_LICENSE_TITLE','LBL_FILEFIELD_LICENSE','javascript:parent.SUGAR.App.router.navigate("#bwc/index.php?module=FileField&action=license", {trigger: true});');
}
$admin_group_header[]= array('LBL_FILEFIELD','',false,$admin_option_defs, '');

?>