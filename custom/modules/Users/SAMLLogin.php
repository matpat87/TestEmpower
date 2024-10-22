<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

global $sugar_config, $current_user, $log;

// If webview exists in HTTP_SEC_CH_UA, redirect to default Login Page as this is called from external popup (Ex. Outlook Implicit)
// If SAML Login page is accessed when SAML is disabled, redirect back to default Login Page
if (
    (isset($_SERVER['HTTP_SEC_CH_UA']) && stripos(strtolower($_SERVER['HTTP_SEC_CH_UA']), 'webview') !== false) ||
    (! $sugar_config['authenticationClass'] || isset($sugar_config['authenticationClass']) && $sugar_config['authenticationClass'] <> 'SAML2Authenticate')
) {
    SugarApplication::redirect('index.php?action=Login&module=Users');
}

// If current user id does not exists, redirect to SAML Login page, else redirect to homepage
if (! $current_user->id) {
    $sugar_smarty = new Sugar_Smarty();
    $sugar_smarty->assign('LOGIN_URL', $sugar_config['SAML_loginurl']);
    $sugar_smarty->display('custom/modules/Users/tpls/saml-login.tpl');
} else {
    SugarApplication::redirect('index.php?action=index&module=Home');
}
