<?php

global $sugar_config, $current_user;
$current_theme = $current_user->getPreference('user_theme');
$admin_option_defs = array();

$admin_option_defs['Administration']['login_licence_link'] = array(
    '',
    'LBL_LOGINPLUGINLICENSE_TITLE',
    'LBL_LOGIN_LICENSE',
    'index.php?module=bc_Quote_Category&action=license'
);

$admin_option_defs['Administration']['Login_Manage_Images'] = array(
    '',
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER',
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_DESCRITOPN',
    'index.php?module=CL_custom_login&action=loginPageSliderGallery'
);

$admin_option_defs['Administration']['Login_Quote'] = array(
    '',
    'LBL_QUOTE',
    'LBL_QUOTE_DESCRIPTION',
    'index.php?module=bc_Quote_Category&action=loginquote'
);
$admin_option_defs['Administration']['Login_Quote_by_category'] = array(
    '',
    'LBL_QUOTE_CATEGORY',
    'LBL_QUOTE_CATEGORY_DESCRIPTION',
    'index.php?module=bc_Quote_Category&action=loginquotedisplay'
);
$admin_group_header[] = array(
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_SECTION',
    '',
    false,
    $admin_option_defs,
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_SECTION_DESCRIPTION'
);

