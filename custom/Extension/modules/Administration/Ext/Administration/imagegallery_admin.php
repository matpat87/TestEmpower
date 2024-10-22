<?php

global $sugar_version;

$admin_option_defs=array();

if(preg_match( "/^6.*/", $sugar_version) ) {
    $admin_option_defs['Administration']['imagegallery_info']= array('helpInline','LBL_IMAGEGALLERY_LICENSE_TITLE','LBL_IMAGEGALLERY_LICENSE','./index.php?module=Imagegallery&action=license');
} else {
    $admin_option_defs['Administration']['imagegallery_info']= array('helpInline','LBL_IMAGEGALLERY_LICENSE_TITLE','LBL_IMAGEGALLERY_LICENSE','javascript:parent.SUGAR.App.router.navigate("#bwc/index.php?module=Imagegallery&action=license", {trigger: true});');
}

$admin_group_header[]= array('LBL_IMAGEGALLERY','',false,$admin_option_defs, '');
