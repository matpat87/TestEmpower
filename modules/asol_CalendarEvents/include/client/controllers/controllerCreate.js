"use strict";

var controllerCreate = (function($, api) {
	
	var init = function() {
		
		$( "#left, #right" ).sortable({
			connectWith: ".container"
		}).disableSelection();
	};
	
	var createCategory = function() {
		
		var config = {},
			error = false;
		
		config['language'] = {};
		$(":input[name='title']").each( function(index, element) {
			if (this.value != '') {
				config['language'][this.id] = this.value;
			} else {
				error = true;
				alert('Title field empty');
				console.error('Title field empty');
			}
		});
		
		config['structure'] = {};
		if ($('#allDay').is(':checked')) {
			config['structure']['allDay'] = "1";
		} else {
			config['structure']['allDay'] = "0";
		}
		
		if ($("input[name='domain']:checked").val() !== undefined) {
			config['structure']['domain'] = $("input[name='domain']:checked").val();
		} else {
			config['structure']['domain'] = "countries";
		}
		
		config['structure']['customFields'] = [];
		if ($('#right').length !== 0) {
			$('#right > div').each( function(index, element) {
				config['structure']['customFields'].push(this.id);
			});
		}
	
		if (!error) {
			api.saveCategory(config).done(function(data) {
				window.location.href = "index.php?module=asol_CalendarEvents";
			});
		}
	};
	
	return {
		init : init,
		createCategory : createCategory,
	}
	
})(jQueryCalendar, calendarApi);

jQueryCalendar(function() {
	controllerCreate.init();
});
