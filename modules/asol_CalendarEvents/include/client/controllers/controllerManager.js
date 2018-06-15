"use strict";

var controllerManager = (function($, api, window) {
	
	var observerList = [];
	
	var init = function() {
		
		$(".color").each(function(index, element) {
			
			var id 		= this.id,
				typeId 	= this.id.split("_")[0];
					
			$("#"+id).change(function() {
				$("#"+typeId).trigger( id, [ typeId, $("#"+id).val() ] );
			});
					
			if ( $.inArray(typeId, observerList) === -1 ) {
				observerList.push(typeId);
			}
		});
		
		observerList.forEach(function(element, index) {
			
			$("#"+element).on( element+"_background", function(event, id, value) {
				controllerBackground(id, value);
			});
			
			$("#"+element).on( element+"_border", function(event, id, value) {
				controllerBorder(id, value);
			});
			
			$("#"+element).on( element+"_text", function(event, id, value) {
				controllerText(id, value);
			});
		});
		
		$("#ce_category_table").sortable({ items: ".ce_category_row", axis: "y" });
		
		$(".multiselect").multiselect({
			selectedList: 3,
			header: true,
			checkAllText: "Check all"
		});
		
		jscolor.init();
		
		$("#managerContent").css('display', 'block');
	};
	
	var newCategory = function() {
		window.location.href = "index.php?module=asol_CalendarEvents&action=create";
	};
	
	var deleteCategory = function(id) {
		
		if(confirm(SUGAR.language.get('asol_CalendarEvents', 'LBL_MESSAGE_CONFIRMATION_DELETE_CATEGORY'))) {
			api.deleteCategory(id).done(function() {
				window.location.href = "index.php?module=asol_CalendarEvents";
			});
		}
	};
	
	var submmitColor = function() {
		
		var colors = {};
		
		$(":input[class='color']").each(function(index, element) {
			
			if ( colors[this.id.split("_")[0]] == undefined )
						colors[this.id.split("_")[0]] = {};
			
			colors[this.id.split("_")[0]][this.id.split("_")[1]] = this.value;
		});
		
		api.saveColor(colors).done(function() {
			window.location.href = "index.php?module=asol_CalendarEvents";
		});
	};
	
	var tzVisibilityChange = function(context) {
		
		if (context.checked)
			$("#tzRow").css('display', 'table-row');
		else
			$("#tzRow").css('display', 'none');
	};
	
	var submitTimezone = function() {
		
		var timezoneConfig = {};
		
		timezoneConfig['timezoneVisibility'] = $("#tzVisibility").is(':checked');
		timezoneConfig['timezoneList'] = $("#tzSelect").multiselect("getChecked").map(function() { return this.value; }).get();
		
		api.saveTimezone(timezoneConfig).done(function() {
			window.location.href = "index.php?module=asol_CalendarEvents";
		});
	};
	
	var controllerBackground = function( id, value ) {
		$("#"+id).css("background-color", "#"+value);
	};

	var controllerBorder = function ( id, value ) {
		$("#"+id).css("border-color", "#"+value);
	};

	var controllerText = function ( id, value ) {
		$("#"+id).css("color", "#"+value);
	};
	
	return {
		init : init,
		newCategory : newCategory,
		deleteCategory : deleteCategory,
		submmitColor : submmitColor,
		tzVisibilityChange : tzVisibilityChange,
		submitTimezone : submitTimezone,
	}
	
})(jQueryCalendar, calendarApi, window);

jQueryCalendar(function() {
	controllerManager.init();
});
