<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/* * *******************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 * ****************************************************************************** */
/* * *******************************************************************************
 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * ****************************************************************************** */

/** @var AuthenticationController $authController */
$authController->authController->pre_login();

$sugar_smarty = new Sugar_Smarty();
//-----------------------checking sugar and include css if required----------------------------
global $current_user;
if ($current_user->getPreference('suitecrm_version') != '') {
    if ($theme == 'SuiteP') {
        echo "<link rel='stylesheet' type='text/css'  href='modules/CL_custom_login/loginSlider/css/suitep_login_css.css'>";
    } else {
        echo "<link rel='stylesheet' type='text/css'  href='modules/CL_custom_login/loginSlider/css/suite_login_css.css'>";
    }
} else {
    echo "<link rel='stylesheet' type='text/css' href='modules/CL_custom_login/loginSlider/css/sugar_login_css.css'>";
}
//------------------------checking licence configuration status------------------------------
require_once('modules/bc_Quote_Category/login_plugin.php');
$checkLoginSubscription = validateLoginSubscription();
if (!$checkLoginSubscription['success']) {
    $disabled_plugin_loginslider = true;
    $sugar_smarty->assign('DISABLED_PLUGIN_LOGINSLIDER', $disabled_plugin_loginslider);
} else { //--------- module enabled--------
    if (!empty($checkLoginSubscription['message'])) {
        echo '<div style="color: #f11147;font-size: 14px;left: 0;text-align: center;top: 50%;">' . $checkLoginSubscription['message'] . '</div>';
    }

    //-----------------------------------------QUOTE OF THE DAY-------------------------------------------------------------------------------------------------------
    global $db;
    $quote = array();
    // $get = "SELECT id FROM bc_Quote_Category where description='1' and deleted=0";
    // $query = $db->query($get);
    $bc_quotes = new bc_Quote_Category();
    $bc_quotes_result = $bc_quotes->get_list("", "");

    if (count($bc_quotes_result['list']) != '0') {
        foreach ($bc_quotes_result['list'] as $key => $value) {
            if ($value->description == '1') {
                $bc_quotes->retrieve($value->id);
                $quotes = $bc_quotes->get_linked_beans('bc_quote_category_bc_quote', 'bc_Quote');
                foreach ($quotes as $value_quotes) {
                    array_push($quote, nl2br($value_quotes->description));
                }
            }
        }

        $random = array_rand($quote);
        if ($random >= 0 && !empty($quote[$random])) {
            echo "<h1 class='quote-block' >";
            echo "<span class='quote-img-left'><img src='modules/bc_Quote_Category/images/quote/ico-quote.png'></span><span class='quote'>" . $quote[$random] . "</span><span class='quote-img-right'><img src='modules/bc_Quote_Category/images/quote/ico-quote-right.png'></span></h1>";
        }
    }

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}

require_once 'modules/CL_custom_login/slider_function.php';


$theme_path = "themes/" . $theme . "/";
global $app_language, $sugar_config, $app_strings;
//$company_Name = $app_strings['LBL_BROWSER_TITLE'];
//$company_logoDetails = getCurrentThemeAndCompanyLogoDetails();
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'Users');
require_once('modules/Administration/updater_utils.php');
// Retrieve username and password from the session if possible.
if (isset($_SESSION["login_user_name"])) {
    if (isset($_REQUEST['default_user_name']))
        $login_user_name = $_REQUEST['default_user_name'];
    else
        $login_user_name = $_SESSION['login_user_name'];
} else {
    if (isset($_REQUEST['default_user_name'])) {
        $login_user_name = $_REQUEST['default_user_name'];
    } elseif (isset($_REQUEST['ck_login_id_20'])) {
        $login_user_name = get_user_name($_REQUEST['ck_login_id_20']);
    } else {
        $login_user_name = $sugar_config['default_user_name'];
    }
    $_SESSION['login_user_name'] = $login_user_name;
}


$current_module_strings['VLD_ERROR'] = $GLOBALS['app_strings']["\x4c\x4f\x47\x49\x4e\x5f\x4c\x4f\x47\x4f\x5f\x45\x52\x52\x4f\x52"];

// Retrieve username and password from the session if possible.
if (isset($_SESSION["login_password"])) {
    $login_password = $_SESSION['login_password'];
} else {
    $login_password = $sugar_config['default_password'];
    $_SESSION['login_password'] = $login_password;
}

if (isset($_SESSION["login_error"])) {
    $login_error = $_SESSION['login_error'];
}

/* Assign variable in login tpl file */

if (isset($_GET['login_module'])) {
    $sugar_smarty->assign("LOGIN_MODULE", $_GET['login_module']);
}

if (isset($_GET['login_action'])) {
    $sugar_smarty->assign("LOGIN_ACTION", $_GET['login_action']);
}
if (isset($_GET['login_record'])) {
    $sugar_smarty->assign("LOGIN_RECORD", $_GET['login_record']);
}
if (isset($_SESSION["waiting_error"])) {
    $sugar_smarty->assign('WAITING_ERROR', $_SESSION['waiting_error']);
}
if (empty($GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON'])) {
    $sugar_smarty->assign('DISPLAY_FORGOT_PASSWORD_FEATURE', 'none');
}
if (isset($login_error) && $login_error != "") {
    $sugar_smarty->assign("LOGIN_ERROR_CONDITION", true);
    $sugar_smarty->assign("LOGIN_ERROR_LBL", $current_module_strings['LBL_ERROR']);
    $sugar_smarty->assign("LOGIN_ERROR", $login_error);
} else {
    $sugar_smarty->assign("LOGIN_ERROR_CONDITION", false);
}
if (isset($_REQUEST['ck_login_language_20'])) {
    $display_language = $_REQUEST['ck_login_language_20'];
} else {
    $display_language = $sugar_config['default_language'];
}

if (isset($_REQUEST['ck_login_theme_20'])) {
    $display_theme = $_REQUEST['ck_login_theme_20'];
} else {
    $display_theme = $sugar_config['default_theme'];
}

$the_languages = get_languages();
if (count($the_languages) > 1)
    $sugar_smarty->assign('SELECT_LANGUAGE', get_select_options_with_id($the_languages, $display_language));

$dir = $sugar_config['dls_dir_path'];
$image_count = getSliderConfiguration();
$configurationCount = $image_count;
$sliderImages = getImagesFromUpload($dir);
shuffle($sliderImages);
$random_images = array();

if (empty($configurationCount)) {
    $configurationCount = 1;
}

for ($count = 0; $count < $configurationCount; $count++) {
    if ($sliderImages[$count] != '') {
        array_push($random_images, $sliderImages[$count]);
    }
}

if (is_array($sliderImages)) {
    $is_slider_image_array = true;
} else {
    $is_slider_image_array = false;
}

//check suitecrm version
$suitecrm_version = $sugar_config['suitecrm_version'];
if(version_compare($suitecrm_version, '7.9.8', '>')){
    $input_password = 'username_password';
} else{
    $input_password = 'user_password';
}

$current_theme_and_logo_details_array = getCurrentThemeAndCompanyLogoDetails();
$sugar_smarty->assign("COMPANY_NAME", $app_strings['LBL_BROWSER_TITLE']);
$sugar_smarty->assign("CURRENT_THEME_AND_LOGO_DETAILS", $current_theme_and_logo_details_array);
$sugar_smarty->assign("WELCOME_TO", $mod_strings['LBL_LOGIN_WELCOME_TO']);
$sugar_smarty->assign("LOGIN_USER_NAME", $login_user_name);
$sugar_smarty->assign("LOGIN_USER_NAME_LBL", $current_module_strings['LBL_USER_NAME']);
$sugar_smarty->assign("LOGIN_PASSWORD_LBL", $current_module_strings['LBL_PASSWORD']);
$sugar_smarty->assign("INPUT_PASSWORD", $input_password);
$sugar_smarty->assign("LOGIN_PASSWORD", $login_password);
$sugar_smarty->assign("LOGIN_OPTIONS", $mod_strings['LBL_LOGIN_OPTIONS']);
$sugar_smarty->assign("LBL_THEME", $current_module_strings['LBL_THEME']);
$sugar_smarty->assign("THEME_OPTIONS", get_select_options_with_id(get_themes(), $display_theme));
$sugar_smarty->assign("LBL_LANGUAGE", $current_module_strings['LBL_LANGUAGE']);
$sugar_smarty->assign("LANGUAGE_OPTIONS", get_select_options_with_id($the_languages, $display_language));
$sugar_smarty->assign("LBL_LOGIN_BUTTON_TITLE", $current_module_strings['LBL_LOGIN_BUTTON_TITLE']);
$sugar_smarty->assign("LBL_LOGIN_BUTTON_LABEL", $current_module_strings['LBL_LOGIN_BUTTON_LABEL']);

$sugar_smarty->assign("SLIDER_IMAGES", $random_images);
$sugar_smarty->assign("IS_SLIDER_IMAGE_ARRAY", $is_slider_image_array);
$sugar_smarty->assign("CONFIGURATION_COUNT", $configurationCount);

// $sugar_smarty->assign("LOGO_HEIGHT", $current_theme_and_logo_details_array['logo_height']);
// $sugar_smarty->assign("LOGO_WIDTH", $current_theme_and_logo_details_array['logo_width']);
$sugar_smarty->assign("LOGO_HEIGHT", '120');
$sugar_smarty->assign("LOGO_WIDTH", 'auto');
$sugar_smarty->assign("LOGO_URL", $current_theme_and_logo_details_array['logo_url']);

// RECAPTCHA

$admin = new Administration();
$admin->retrieveSettings('captcha');
$captcha_privatekey = "";
$captcha_publickey = "";
$captcha_js = "";
$Captcha = '';

// if the admin set the captcha stuff, assign javascript and div

require_once('custom/modules/Users/BrowserCheck.php'); //OnTrack #1037 - IE Unsupported
$browserCheck = new BrowserCheck(); //OnTrack #1037 - IE Unsupported
$GLOBALS['log']->fatal('is_allowed_browser: ' . $browserCheck->is_allowed_browser());
if(!$browserCheck->is_allowed_browser() == 'false'){
    $sugar_smarty->assign('SHOW_BROWSER_UNSUPPORTED', 'false');
}

$sugar_smarty->assign('CAPTCHA_CODE', false);
if (isset($admin->settings['captcha_on']) && $admin->settings['captcha_on'] == '1' && !empty($admin->settings['captcha_private_key']) && !empty($admin->settings['captcha_public_key'])) {

    $captcha_privatekey = $admin->settings['captcha_private_key'];
    $captcha_publickey = $admin->settings['captcha_public_key'];
    $sugar_smarty->assign('CAPTCHA_CODE', true);
    $sugar_smarty->assign('LBL_RECAPTCHA_INSTRUCTION', $mod_strings['LBL_RECAPTCHA_INSTRUCTION']);
    $sugar_smarty->assign('LBL_RECAPTCHA_NEW_CAPTCHA', $mod_strings['LBL_RECAPTCHA_NEW_CAPTCHA']);
    $sugar_smarty->assign('LBL_RECAPTCHA_SOUND', $mod_strings['LBL_RECAPTCHA_SOUND']);
    $sugar_smarty->assign('LBL_RECAPTCHA_IMAGE', $mod_strings['LBL_RECAPTCHA_IMAGE']);
    $sugar_smarty->assign('CAPTCHA_PRIVATEKEY', $captcha_privatekey);
    $sugar_smarty->assign('CAPTCHA_PUBLICKEY', $captcha_publickey);
}
if(SugarThemeRegistry::current() == 'SuiteP')
{
    $sugar_smarty->assign('SUITECLASS', 'buttonP');

}else{
    $sugar_smarty->assign('SUITECLASS', '');
}
/* End */

$sugar_smarty->display('modules/CL_custom_login/loginSlider/tpls/login.tpl');


