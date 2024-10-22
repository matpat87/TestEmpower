<?php

$outfitters_config = array(
    'name' => 'DashboardCopyManager', //The matches the id value in your manifest file. This allow the library to lookup addon version from upgrade_history, so you can see what version of addon your customers are using
    'shortname' => 'dashboard-copy-manager',
    'public_key' => '461a42dd20f39e19ab634c407fd75d38,1ea394ffda960b0a8741f3e3d4cb7878,e1f3e0848017968d15fe20d2b87dd7c1',
    'api_url' => 'https://store.suitecrm.com/api/v1',
    'validate_users' => false,
    'manage_licensed_users' => false,
    'validation_frequency' => 'weekly',
    'continue_url' => 'index.php?module=jckl_DashboardTemplates&action=index',
);

