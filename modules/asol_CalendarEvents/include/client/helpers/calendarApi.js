"use strict";

var calendarApi = (function($) {
	
	var url = 'index.php?entryPoint=asolCalendarEventsApi&module=asol_CalendarEvents';
	
	var getEvents = function(configuration) {
		
		return $.ajax({
			url : url,
			type : 'GET',
			dataType : 'text',
			data : {
				actionTarget : 'fetch_events',
				actionValue : configuration,
			}
		});
	};
	
	var saveEvent = function(event) {
		
		return $.ajax({
			url : url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'save_event',
				actionValue : event,
			}
		});
	};
	
	var deleteEvent = function(id) {
		
		return $.ajax({
			url: url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'delete_event',
				actionValue : id,
			}
		});
	};
	
	var saveCategory = function(config) {
		
		return $.ajax({
			url : url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'save_type',
				actionValue : config
			}
		});
	};
	
	var deleteCategory = function(id) {
		
		return $.ajax({
			url : url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'delete_type',
				actionValue : id
			}
		});
	};
	
	var saveColor = function(config) {
		
		return $.ajax({
			url : url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'save_color',
				actionValue : config,
			}
		});
	};
	
	var saveTimezone = function(config) {
		
		return $.ajax({
			url : url,
			type : 'POST',
			dataType : 'text',
			data : {
				actionTarget : 'save_timezone',
				actionValue : config,
			}
		});
	};
	
	var obtainForm = function(type, id) {
		
		return $.ajax({
			url : url,
			type : 'GET',
			dataType : 'text',
			data : {
				actionTarget : 'event_form',
				actionValue : {
					type : type,
					id : id,
				}
			},
		});
	};
	
	return {
		getEvents : getEvents,
		saveEvent : saveEvent,
		deleteEvent : deleteEvent,
		saveCategory : saveCategory,
		deleteCategory : deleteCategory,
		saveColor : saveColor,
		saveTimezone : saveTimezone,
		obtainForm : obtainForm,
	}
	
})(jQueryCalendar);
