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
<link rel="stylesheet" href="modules/asol_CalendarEvents/include/client/css/styleCalendar.css">

<script>
window["sugarUserTimezone"] = "<?= $sugarUserTimezone; ?>";
window["dashlet"] = "<?= $dashlet; ?>";
window["fdow"] = "<?= $fdow; ?>";
</script>

<div id="calendarContent" class="calendarContent">
	<div id="ac-container">
		<div id="buttonPanel">
			<div>
				<input id="toggleFilter" name="button" type="checkbox"/>
				<label for="toggleFilter" class="selectable-boton" title="<?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_TITLE_HIDE"); ?>"></label>
			</div>
			<div>
				<input id="selectedFilter" name="button" type="checkbox"/>
				<label for="selectedFilter" class="selectable-boton" title="<?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_TITLE_ENABLE"); ?>"></label>
			</div>
			<div>
				<input id="applyFilter" name="button" type="button" onClick="controllerCalendar.applyFilter();"/>
				<label for="applyFilter" class="selectable-boton"><?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_BUTTON"); ?></label>
			</div>
		</div>
		<div id="filterPanel">
			<?php if($timezoneVisible == '0'): ?>
			<div style="display: none;">
			<?php else: ?>
			<div>
			<?php endif; ?>
				<input id="timezonesFilter" type="checkbox" name="ac" value="" >
				<label for="timezonesFilter" class="selectable-menu"><?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_TIMEZONE"); ?></label>
				<section>
					<ol id="selectable-timezones" class="selectable">
						<li class="ui-widget-content ui-selectee ui-selected" title="<?= $sugarUserTimezone; ?>">User/Timezone</li>
						<?php foreach ( $timezoneList as $zone ): ?>
						<li class="ui-widget-content" title="<?= $zone; ?>"><?= $zone; ?></li>
						<?php endforeach; ?>
					</ol>
				</section>
			</div>
			
			<?php if($existDomains): ?>
			<div>
				<input id="countriesFilter" type="checkbox" name="ac" value="" >
				<label for="countriesFilter" class="selectable-menu"><?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_COUNTRIES"); ?></label>
				<section>
					<ol id="selectable-countries" class="selectable">
					<?php foreach ( $enableCountries as $country ): ?>
						<li class="ui-widget-content ui-selectee ui-selected" title="<?= $country; ?>"><?= $country; ?></li>
					<?php endforeach; ?>
					</ol>
				</section>
			</div>
			<?php endif; ?>
			
			<div>
				<input id="categoriesFilter" type="checkbox" name="ac" value="" >
				<label for="categoriesFilter" class="selectable-menu"><?= asol_CalendarEvents::translateCalendarLabel("LBL_FILTER_CATEGORIES"); ?></label>
				<section>
					<ol id="selectable-categories" class="selectable">
					<?php foreach ( $categoriesFilter as $key => $value ): ?>
						<?php if( $current_language != "" ): ?>
						<li class="ui-widget-content ui-selectee ui-selected" title="<?= $key; ?>"><?= $value [$current_language]; ?></li>
						<?php else: ?>
						<li class="ui-widget-content ui-selectee ui-selected" title="<?= $key; ?>"><?= $value ['en_us']; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
					</ol>
				</section>
			</div>
		</div>
	</div>
	<div id="calendar"></div>
	
	<?php if ($canEdit): ?>
	<div id="panel-new" title="<?= asol_CalendarEvents::translateCalendarLabel("LBL_TITLE_NEW_EVENT"); ?>">
		<div id="category">
			<label for="selectCategory" class=""><?= asol_CalendarEvents::translateCalendarLabel("LBL_SELECT_CATEGORY"); ?></label>
			<select id="selectCategory" class="ui-widget-content ui-state-default selectJqueryStyle">
				<?php foreach($categories as $key => $value): ?>
				<?php if($current_language != ""): ?>
				<option value="<?= $key ?>"><?= $value[$current_language] ?></option>
				<?php else: ?>
				<option value="<?= $key ?>"><?= $value["en_us"] ?></option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>
			<button id="nextButton" onClick="controllerCalendar.next();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_NEXT"); ?></button>
		</div>
		<div id="properties">
			<div id="content-ajax">
			</div>
			<button id="backButton" onClick="controllerCalendar.back();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_BACK"); ?></button>
			<button id="createEvent" onClick="controllerCalendar.createEvent();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_CREATE"); ?></button>
		</div>
	</div>
	<?php else: ?>
		<select id="selectCategory" style="display: none;">
			<?php foreach($categories as $key => $value): ?>
			<?php if($current_language != ""): ?>
			<option value="<?= $key ?>"><?= $value[$current_language] ?></option>
			<?php else: ?>
			<option value="<?= $key ?>"><?= $value["en_us"] ?></option>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>
	<?php endif; ?>
	<div id="panel-modify">
		<div id="view-event">
			<div class="titleEvent"></div>
			<div id="displayTime"></div>
			<div id="displayInfo"></div>
			<div id="moreInfo">
				<h3><?= asol_CalendarEvents::translateCalendarLabel("LBL_MORE_INFO"); ?></h3>
				<div id="contentMoreInfo"></div>
			</div>
			<?php if ($canEdit): ?>
			<button id="modifyButton" onClick="controllerCalendar.modify();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_MODIFY"); ?></button>
			<?php endif; ?>
			<?php if ($canDelete): ?>
			<button id="deleteButton" onClick="controllerCalendar.deleteEvent();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_DELETE"); ?></button>
			<?php endif; ?>
		</div>
		<div id="modify-properties">
			<div id="modify-ajax">
			</div>
			<button id="modifyEvent" onClick="controllerCalendar.modifyEvent();"><?= asol_CalendarEvents::translateCalendarLabel("LBL_BUTTON_SAVE"); ?></button>
		</div>
	</div>
</div>
