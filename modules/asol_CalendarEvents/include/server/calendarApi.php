<?php
$returnResult = "";
$actionTarget = $_REQUEST ["actionTarget"];
$actionValue = $_REQUEST ["actionValue"];

switch ($actionTarget) {
	case "save_event" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerEvents.php");
		$returnResult = asol_ControllerEvents::saveEvent ( $actionValue );
		break;
	case "delete_event" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerEvents.php");
		$returnResult = asol_ControllerEvents::deleteEvent ( $actionValue );
		break;
	case "fetch_events" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerEvents.php");
		$returnResult = asol_ControllerEvents::fetchEvents ( $actionValue ['timezone'], $actionValue ['month'], $actionValue ['filterCategory'], $actionValue ['filterCountry'] );
		break;
	case "reset_config" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerConfiguration.php");
		$returnResult = asol_ControllerConfiguration::resetConfig ( $actionValue );
		break;
	case "save_color" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerConfiguration.php");
		$returnResult = asol_ControllerConfiguration::saveColor ( $actionValue );
		break;
	case "save_type" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerConfiguration.php");
		$returnResult = asol_ControllerConfiguration::saveType ( $actionValue );
		break;
	case "delete_type" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerConfiguration.php");
		$returnResult = asol_ControllerConfiguration::deleteType ( $actionValue );
		break;
	case "save_timezone" :
		require_once ("modules/asol_CalendarEvents/include/server/controllers/controllerConfiguration.php");
		$returnResult = asol_ControllerConfiguration::saveTimezone ( $actionValue );
		break;
	case "event_form" :
		require_once ("modules/asol_CalendarEvents/include/server/Formly.php");
		$returnResult = asol_Formly::generateForm ( $actionValue ['type'], $actionValue ['id'] );;
		break;
}

echo $returnResult;
