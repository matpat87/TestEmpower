<?php 

$html = '
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.min.js"></script>
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.UI.min.js"></script>
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.min.css" rel="stylesheet">
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.theme.min.css" rel="stylesheet">

<script type="text/javascript">
	var jQueryCalendar = $.noConflict();
</script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/multiselect/jquery.multiselect.min.js"></script>
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/external/multiselect/jquery.multiselect.css">

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/moment/moment.min.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/moment/moment-timezone.min.js"></script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/combodate/combodate.js"></script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/fullcalendar/fullcalendar.min.js"></script>
<link rel="stylesheet" media="print" href="modules/asol_CalendarEvents/include/client/external/fullcalendar/fullcalendar.print.css">
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/external/fullcalendar/fullcalendar.min.css">

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/helpers/helperCalendar.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/helpers/calendarApi.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/controllers/controllerCalendar.js"></script>
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/css/styleDashlet.css">

<script>
	window["sugarUserTimezone"] = "'. $sugarUserTimezone .'";
	window["dashlet"] = "'. $dashlet .'";		
	window["fdow"] = "'. $fdow .'";
</script>
			
<div id="calendarContent" class="calendarContent">
	<div id="ac-container"></div>
	<div id="calendar"></div>
';
	
	if ($canEdit) {
		$html .= '
		<div id="panel-new" title="'. asol_CalendarEvents::translateCalendarLabel("LBL_TITLE_NEW_EVENT") .'">
			<div id="category">
				<label for="selectCategory" class="">'. asol_CalendarEvents::translateCalendarLabel("LBL_SELECT_CATEGORY") .'</label>
				<select id="selectCategory" class="ui-widget-content ui-state-default selectJqueryStyle">';
					foreach($categories as $key => $value) {
						if($current_language != "") {
							$html .= '<option value="'. $key .'">'. $value[$current_language] .'</option>';
						} else {
							$html .= '<option value="'. $key .'">'. $value["en_us"] .'</option>';
						}
					}
				$html .= '</select>
				<button id="nextButton" onClick="controllerCalendar.next();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_NEXT") .'</button>
			</div>
			<div id="properties">
				<div id="content-ajax">
				</div>
				<button id="backButton" onClick="controllerCalendar.back();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_BACK") .'</button>
				<button id="createEvent" onClick="controllerCalendar.createEvent();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_CREATE") .'</button>
			</div>
		</div>';
	} else {
		$html .= '<select id="selectCategory" class="ui-widget-content ui-state-default selectJqueryStyle" style="display: none;">';
		foreach($categories as $key => $value) {
			if($current_language != "") {
				$html .= '<option value="'. $key .'">'. $value[$current_language] .'</option>';
			} else {
				$html .= '<option value="'. $key .'">'. $value["en_us"] .'</option>';
			}
		}
		$html .= '</select>';
	}

$html .= '
	<div id="panel-modify">
		<div id="view-event">
			<div class="titleEvent"></div>
			<div id="displayTime"></div>
			<div id="displayInfo"></div>
			<div id="moreInfo">
				<h3>'. 
						asol_CalendarEvents::translateCalendarLabel("LBL_MORE_INFO")
				.'</h3>
				<div id="contentMoreInfo"></div>
			</div>
';
			if ($canEdit) {
				$html .= '<button id="modifyButton" onClick="controllerCalendar.modify();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_MODIFY") .'</button>';
			}
			if ($canDelete) {
				$html .= '<button id="deleteButton" onClick="controllerCalendar.deleteEvent();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_DELETE") .'</button>';
			}
$html .= '
		</div>
		<div id="modify-properties">
			<div id="modify-ajax">
			</div>
			<button id="modifyEvent" onClick="controllerCalendar.modifyEvent();">'. asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_SAVE") .'</button>
		</div>
	</div>
';

return $html;
