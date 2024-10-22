<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * Many thanks to Yathit Mobile App Service for their free module
 *
 */

require_once('custom/QuickCRM/API_utils.php');

global $current_user;
global $sugar_config;
if (empty($current_user) || empty($current_user->id)) die(403);

$token = get_seamless_token($current_user->id);

$GLOBALS['log']->info("QuickCRM SAMLSession->generate token for: $current_user->id");
$url = $sugar_config['site_url'];
$redirect = 'Location: index.php?module=Home&action=About&seamless_token=' . $token;
if (!empty($_REQUEST['withsession'])){
	$redirect .= '&session=' . session_id();
}

header($redirect);
die(302);