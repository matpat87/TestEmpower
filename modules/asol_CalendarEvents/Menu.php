<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $current_user;

if ( $current_user->is_admin ) 
{
	$module_menu[]=Array("index.php?module=asol_CalendarEvents&action=manageCalendar", asol_CalendarEvents::translateCalendarLabel('LBL_MENU_MANAGER'), "asol_CalendarEvents");
}