
function save() {
	console.log('[save()]');
	
	// I m using tinyMCE for textareas and POSTing form through AJAX. But when I m trying to save textarea value, it is taking old values on first click, but it takes updated values on second click
	if (typeof tinymce !== 'undefined') {
		tinymce.triggerSave();
	}
	
	if (!wfm_save()) {
		return false;
	}
	
	if (false) { // check_form returns false sometimes (asol_Process, disabled dropdownlist)
		parent.saveObjectAndReload($("#EditView").serializeArray());
	} else {
		if (check_form('EditView')) {
			parent.saveObjectAndReload($("#EditView").serializeArray());
		}
	}
	
	return false;
}

function showHelpTips(el, helpText, myPos, atPos, id) {
	if (myPos == undefined || myPos == "") {
		myPos = "left top";
	}
	if (atPos == undefined || atPos == "") {
		atPos = "right top";
	}
	
	var pos = $(el).offset(), ofWidth = $(el).width(), elmId = id || 'helpTip' + pos.left + '_' + ofWidth, $dialog = elmId ? ($("#" + elmId).length > 0 ? $("#" + elmId) : $('<div></div>').attr("id", elmId)) : $('<div></div>');
	$dialog.html(helpText).dialog({
		autoOpen : false,
		title : SUGAR.language.get('app_strings', 'LBL_HELP'),
		position : {
			my : myPos,
			at : atPos,
			of : $(el)
		}
	});
	
	var width = $dialog.dialog("option", "width");
	
	if ((pos.left + ofWidth) - 40 < width) {
		$dialog.dialog("option", "position", {
			my : 'left top',
			at : 'right top',
			of : $(el)
		});
	}
	$dialog.dialog('open');
	$(".ui-dialog").appendTo("#content");
}

function initPanel(id, state) {
	panelId = 'detailpanel_' + id;
	expandPanel(id);
	if (state == 'collapsed') {
		collapsePanel(id);
	}
}

function expandPanel(id) {
	var panelId = 'detailpanel_' + id;
	document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' expanded';
}

function collapsePanel(id) {
	var panelId = 'detailpanel_' + id;
	document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' collapsed';
}

function setCollapseState(mod, panel, isCollapsed) {
	var sugar_panel_collase = Get_Cookie("sugar_panel_collase");
	if (sugar_panel_collase == null) {
		sugar_panel_collase = {};
	} else {
		sugar_panel_collase = YAHOO.lang.JSON.parse(sugar_panel_collase);
	}
	sugar_panel_collase[mod] = sugar_panel_collase[mod] || {};
	sugar_panel_collase[mod][panel] = isCollapsed;
	
	Set_Cookie('sugar_panel_collase', YAHOO.lang.JSON.stringify(sugar_panel_collase), 30, '/', '', '');
}

function forceExecuteEvent(event_id) {

    var url = 'index.php?module=asol_Process&action=scheduledTask&uid=' + event_id + '&sugar_body_only=true';
    document.location = url;
}
