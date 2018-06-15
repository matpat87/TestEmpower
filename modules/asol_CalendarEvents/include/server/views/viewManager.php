<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.min.js"></script>
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.UI.min.js"></script>
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.min.css" rel="stylesheet">
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.theme.min.css" rel="stylesheet">

<script type="text/javascript">
	var jQueryCalendar = $.noConflict();
</script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/multiselect/jquery.multiselect.min.js"></script>
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/external/multiselect/jquery.multiselect.css">

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/external/jscolor/jscolor.js"></script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/helpers/calendarApi.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/controllers/controllerManager.js"></script>

<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/css/styleManager.css">

<div id="managerContent">
	<div class="titleForm">
		<?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_TITLE"); ?>
	</div>
	<button id="newCategory" type="button" class="submitButton" onClick="controllerManager.newCategory();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_NEW_CATEGORY"); ?></button>
	<table id="ce_category_table" class="detail view detail508">
		<tbody id="container">
			<tr>
				<th align="left" colspan="6"><h3><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_CATEGORY_TITLE"); ?></h3></th>
			</tr>
			<tr>
				<th width="19%">
	  				<h4><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_COLOR_CATEGORY"); ?></h4>
				</th>
				<th width="19%">
	  				<h4><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_COLOR_BACKGROUND"); ?></h4>
				</th>
				<th width="19%">
	  				<h4><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_COLOR_BORDER"); ?></h4>
				</th>
				<th width="19%">
	  				<h4><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_COLOR_TEXT"); ?></h4>
				</th>
				<th width="19%">
	  				<h4><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_COLOR_RESULT"); ?></h4>
				</th>
				<th width="5%"></th>
			</tr>
			<?php foreach($languages as $key => $value): ?>
			<tr class="ce_category_row">
				<?php if($current_language != ""): ?>
				<td style="cursor: pointer;"><?= $value[$current_language]; ?></td>
				<?php else: ?>
				<td style="cursor: pointer;"><?= $value['en_us']; ?></td>
				<?php endif; ?>
				<?php if(array_key_exists($key, $colors)): ?>
				<td><input id="<?= $key."_background"; ?>" class="color" value="<?= $colors[$key]["background"]; ?>"></td>
				<td><input id="<?= $key."_border"; ?>" class="color" value="<?= $colors[$key]["border"]; ?>"></td>
				<td><input id="<?= $key."_text"; ?>" class="color" value="<?= $colors[$key]["text"]; ?>"></td>
				<td><div id="<?= $key ?>" style="<?= "width: 50%; color: #". $colors[$key]['text'] ."; border-style: solid; border-width: 2px; border-radius: 4px; border-color: #". $colors[$key]['border'] ."; background-color: #". $colors[$key]['background'] .";" ?>" >
				<?php else: ?>
				<td><input id="<?= $key."_background"; ?>" class="color" value="3A87AD"></td>
				<td><input id="<?= $key."_border"; ?>" class="color" value="3A87AD"></td>
				<td><input id="<?= $key."_text"; ?>" class="color" value="FFFFFF"></td>
				<td><div id="<?= $key ?>" style="width: 50%; color: #FFFFFF; border-style: solid; border-width: 2px; border-radius: 4px; border-color: #3A87AD; background-color: #3A87AD;" >
				<?php endif; ?>
				<?php if($current_language != ""): ?>
					<?= $value[$current_language]; ?>
				<?php else: ?>
					<?= $value['en_us']; ?>
				<?php endif; ?>
				</div></td>
				<td>
					<a class="managerActionButton" title="<?= asol_CalendarEvents::translateCalendarLabel("LBL_EDIT_BUTTON"); ?>" href="<?="index.php?module=asol_CalendarEvents&action=modify&eventType=".$key ?>" ><img class="asol_icon" border="0" src="modules/asol_CalendarEvents/include/client/images/asol_calendar_edit.png"></a>
					<a class="managerActionButton" title="<?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_DELETE"); ?>" onclick="<?= "controllerManager.deleteCategory('". $key ."');" ?>" ><img class="asol_icon" border="0" src="modules/asol_CalendarEvents/include/client/images/asol_calendar_delete.png"></a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<button id="submitColor" type="button" class="submitButton" onClick="controllerManager.submmitColor();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_SAVE"); ?></button>
	
	<table class="detail view detail508">
		<tbody>
			<tr>
				<th align="left" colspan="2"><h3><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_TIMEZONE_TITLE"); ?></h3></th>
			</tr>
			<tr>
				<td scope="col" width="15%"><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_TIMEZONE_VIS_COL"); ?></td>
			<?php if($timezoneVisible == '0'): ?>
				<td width="85%"><input id="tzVisibility" type="checkbox" onChange="controllerManager.tzVisibilityChange(this);"></td>
			</tr>
			<tr id="tzRow" style="display: none;">
			<?php else: ?>
				<td width="85%"><input id="tzVisibility" type="checkbox" checked="checked" onChange="controllerManager.tzVisibilityChange(this);"></td>
			</tr>
			<tr id="tzRow">
			<?php endif; ?>
				<td scope="col" width="15%"><?= asol_CalendarEvents::translateCalendarLabel("LBL_MANAGER_TIMEZONE_COL"); ?></td>
				<td width="85%"> 
					<select id="tzSelect" multiple class="multiselect">
					<?php foreach($availableTimezones as $timezone): ?>
						<?php if(in_array($timezone, $myTimezone)): ?>
						<option selected value="<?= $timezone; ?>"><?= $timezone; ?></option>
						<?php else: ?>
						<option value="<?= $timezone; ?>"><?= $timezone; ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<button id="submitTimezone" type="button" class="submitButton" onClick="controllerManager.submitTimezone();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_SAVE"); ?></button>
</div>
