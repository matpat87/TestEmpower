<?php

global $sugar_version, $admin_group_header;

if (!is_array($jckl_options_defs)) {
    $jckl_options_defs = [];
}


if (preg_match("/^6.*/", $sugar_version)) {
    $jckl_options_defs['Administration']['jackal_DashboardManager_License']
        = [
        'helpInline',
        'LBL_JCKL_DASHBOARD_LICENSEADDON_LICENSE_TITLE',
        'LBL_JCKL_DASHBOARD_LICENSEADDON_LICENSE',
        './index.php?module=jckl_DashboardTemplates&action=license',
        'oauth-keys',
    ];

    $jckl_options_defs['Administration']['jackal_DashboardManager'] = [
        'Administration',
        'LBL_JACKAL_DASHBOARDCOPY_TITLE',
        'LBL_JACKAL_DASHBOARDCOPY_DESCRIPTION',
        './index.php?module=jckl_DashboardTemplates&action=index',
        'import'
    ];

    $jckl_options_defs['Administration']['jackal_DashboardManagerAppend'] = [
        'Administration',
        'LBL_JACKAL_DASHBOARDAPPEND_TITLE',
        'LBL_JACKAL_DASHBOARDAPPEND_DESCRIPTION',
        './index.php?module=jacka_DashboardAppend&action=index',
        'import'
    ];
} else {
    $jckl_options_defs['Administration']['jackal_DashboardManager']
        = [
        'helpInline',
        'LBL_JCKL_DASHBOARD_LICENSEADDON_LICENSE_TITLE',
        'LBL_JCKL_DASHBOARD_LICENSEADDON_LICENSE',
        'javascript:parent.SUGAR.App.router.navigate("#bwc/index.php?module=jckl_DashboardTemplates&action=license", {trigger: true});',
    ];
    $jckl_options_defs['Administration']['jackal_DashboardManager'] = [
        'Administration',
        'LBL_JACKAL_DASHBOARDCOPY_TITLE',
        'LBL_JACKAL_DASHBOARDCOPY_DESCRIPTION',
        './index.php?module=jckl_DashboardTemplates&action=index',
    ];
}

$admin_group_header['jackal_software'] = [
    'LBL_JACKAL_DASHBOARD_MANAGER_GROUP_TITLE',
    '',
    'false',
    $jckl_options_defs,
    'LBL_JACKAL_DASHBOARD_MANAGER_GROUP_DESCRIPTION',
];