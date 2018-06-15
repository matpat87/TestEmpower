<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.min.js"></script>
<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jquery.UI.min.js"></script>
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.min.css" rel="stylesheet">
<link type="text/css" href="modules/asol_CalendarEvents/include/client/jquery-ui.theme.min.css" rel="stylesheet">

<script type="text/javascript">
	var jQueryCalendar = $.noConflict();
</script>

<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/helpers/calendarApi.js"></script>
<script type="text/javascript" src="modules/asol_CalendarEvents/include/client/controllers/controllerCreate.js"></script>
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/css/styleCreate.css">

<div class="titleForm">
	<?= asol_CalendarEvents::translateCalendarLabel("LBL_CREATE_CATEGORY"); ?>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="detail view detail508">
	<tbody>
		<tr>
			<th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CATEGORY_NAME" ); ?></h4></th>
		</tr>
		<tr>
			<td scope="col">English (US):</td>
			<td><input id="en_us" name="title"></td>
			<?php foreach($sugar_config ['languages'] as $key => $value): ?>
			<?php if($key != $key): ?>
			<td scope="col"><?= $value; ?></td>
			<td><input id="<?= $key; ?>" name="title" ></td>
			<?php endif; ?>
			<?php endforeach; ?>
		</tr>
	
		<tr>
			<th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DURATION_TITLE" ); ?></h4></th>
		</tr>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DURATION_ALLDAY" ); ?></td>
			<td><input id="allDay" type="checkbox" ></td>
		</tr>
		
		<?php if($existDomains): ?>
		<tr>
			<th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DOMAINS_SUPPORT" );  ?></h4></th>
		</tr>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_DOMAINS" ); ?></td>
			<td><input id="domain" type="radio" name="radio" value="domain"></td>
		</tr>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_COUNTRIES" ); ?></td>
			<td><input id="domain" type="radio" name="radio" value="countries"></td>
		</tr>
		<?php endif; ?>
		
		<?php if(!$existDomains): ?>
		<tr>
			<th colspan="4"><h4><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_TITLE" ); ?></h4></th>
		</tr>
		<tr>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_MODULE" ); ?></td>
			<td><div id="left" class="container">
				<?php foreach($customFields as $key => $value): ?>
				<div id="<?= $key; ?>"><?= $value; ?></div>
				<?php endforeach; ?>
			</div></td>
			<td scope="col"><?= asol_CalendarEvents::translateCalendarLabel ( "LBL_CUSTOM_FIELDS_CATEGORY" ); ?></td>
			<td><div id="right" class="container"></div></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<button id="submitType" type="button" onClick="controllerCreate.createCategory();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_SAVE"); ?></button>
