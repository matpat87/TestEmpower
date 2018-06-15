<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.min.js"></script>
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.UI.min.js"></script>
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.min.css" rel="stylesheet">
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.theme.min.css" rel="stylesheet">

<script type="text/javascript">
	var jQueryCalendar = $.noConflict();
</script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/helpers/calendarApi.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/controllers/controllerModify.js"></script>

<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/css/styleModify.css">

<script>
	window["actualEvent"] = "<?= $type; ?>";
</script>

<div class="titleForm">
<?= $language [$type] [$current_language]; ?>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="detail view detail508">
	<tbody>
		<tr><th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CATEGORY_KEY" ); ?></h4></th>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CATEGORY_KEY" ); ?></td>
			<td><input id="category_key" name="key" value="<?= $type ?>" readonly></td>
		</tr>
	
		<tr><th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CATEGORY_NAME" ); ?></h4></th>
		<tr>
			<td scope="col">English (US):</td>
			<td><input id="en_us" name="title" value="<?= $language[$type]['en_us'] ?>"></td>
			<?php foreach($sugar_config ['languages'] as $key => $value): ?>
			<?php if($key != 'en_us'): ?>
			<td scope="col"><?= $value; ?></td>
			<td><input id="<?= $key; ?>" name="title" value="<?= $language[$type][$key]; ?>" ></td>
			<?php endif; ?>
			<?php endforeach; ?>
		</tr>
		
		<tr><th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DURATION_TITLE" ); ?></h4></th>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DURATION_ALLDAY" ); ?></td>
			<?php if($structure[$type]['allDay'] == "1"): ?>
			<td><input id="allDay" type="checkbox" checked="checked" disabled="disabled"></td>
			<?php else: ?>
			<td><input id="allDay" type="checkbox" disabled="disabled"></td>
			<?php endif; ?>
		</tr>
		
		<?php if($existDomains): ?>
		<tr><th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DOMAINS_SUPPORT" ); ?></h4></th>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DOMAINS" ); ?></td>
			<?php if($structure[$type]['domain'] == 'domain'): ?>
			<td><input id="domain" type="radio" name="domain" value="domain" checked="checked" disabled="disabled"></td>
			<?php else: ?>
			<td><input id="domain" type="radio" name="domain" value="countries" disabled="disabled"></td>
			<?php endif; ?>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_COUNTRIES" ); ?></td>
			<?php if($structure[$type]['domain'] == 'domain'): ?>
			<td><input id="domain" type="radio" name="domain" value="domain" disabled="disabled"></td>
			<?php else: ?>
			<td><input id="domain" type="radio" name="domain" value="countries" checked="checked" disabled="disabled"></td>
			<?php endif; ?>
		</tr>
		<?php endif; ?>
		
		<?php if(!$existDomains): ?>
		<tr><th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_TITLE" ); ?></h4></th>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_MODULE" ); ?></td>
			<td><div id="left" class="container">
			<?php foreach ($model->field_defs as $key => $value): ?>
			<?php if (($value ["source"] == "custom_fields") && ($value ["required"] != "1") && (!in_array ($key, $structure[$type]["customFields"]))): ?>
				<div id="<?= $key; ?>"><?= $value ["labelValue"]; ?></div>
			<?php endif; ?>
			<?php endforeach; ?>
			</div></td>
			
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_CATEGORY" ); ?></td>
			<td><div id="right" class="container">
			<?php foreach($structure[$type]["customFields"] as $key => $value): ?>
				<div id="<?= $key; ?>" ><?= $model->field_defs[$value]["labelValue"]; ?></div>
			<?php endforeach; ?>
			</div></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>

<button id="modifyType" class="submit" type="button" onClick="controllerModify.modifyCategory();"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_BUTTON_SAVE" ); ?></button>
