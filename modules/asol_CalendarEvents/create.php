<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
	die ( 'Not A Valid Entry Point' );

require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
if (! asol_CalendarUtils::isCommonBaseInstalled ()) {
	die ( "<font color='red'>" . str_replace ( "%[v]", asol_CalendarUtils::$common_version, asol_CalendarEvents::translateCalendarLabel ( "LBL_CALENDAR_COMMON_BASE_NEEDED" ) ) . "</font>" );
}
asol_CalendarUtils::initCalendarEventsFunctions ();
require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerCreate.php");

asol_ControllerCreate::display ();
