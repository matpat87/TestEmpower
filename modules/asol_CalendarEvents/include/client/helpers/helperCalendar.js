"use strict";

var arrayCategory = [],
	arrayCountry = [];

var pullEvents = function(date) {
	
	var timezone = null;
	
	arrayCategory = [];
	arrayCountry = [];

	if (window.dashlet === 'false') {

		timezone = controllerCalendar.getTimezone();
		
		jQueryCalendar("#selectable-categories .ui-selected").each(function() {
			arrayCategory.push( this.title );
		});
		
		jQueryCalendar("#selectable-countries .ui-selected").each(function() {
			arrayCountry.push( this.title );
		});
	} else {
	
		if (jQueryCalendar("#tzFilterPanel").val() === undefined) {
			timezone = window.sugarUserTimezone;
		} else {
			timezone = jQueryCalendar("#tzFilterPanel").val();
		}
		controllerCalendar.setTimezone(timezone);
			
		if (jQueryCalendar("#categoriesFilterPanel").length !== 0) 
			arrayCategory = jQueryCalendar("#categoriesFilterPanel").val();
		
		if (jQueryCalendar("#countriesFilterPanel").length !== 0) 
			arrayCountry = jQueryCalendar("#countriesFilterPanel").val();
	}
	
	var fetch = {
    	timezone:   	moment.tz(date, timezone).format("Z"),
    	month:      	transformToMonth(date),   
    	filterCategory: arrayCategory,
    	filterCountry: 	arrayCountry,
  	};
	
	calendarApi.getEvents(fetch).done(function(data) {		
		
		if (window.dashlet === 'false') {
			
			jQueryCalendar("#calendar").fullCalendar('removeEvents');
			controllerCalendar.setEvents( window.JSON.parse(data) );
			jQueryCalendar("#calendar").fullCalendar('addEventSource', controllerCalendar.getEvents());
		} else {
			
			jQueryCalendar("#dlg_c").addClass('yui-overlay-hidden');
			jQueryCalendar("#dlg_c").css('visibility','hidden');
			jQueryCalendar("#dlg_mask").css('display', 'none');
			jQueryCalendar("#dlg_mask").css('z-index', 3);
			
			jQueryCalendar("#calendar").fullCalendar('removeEvents');
    		controllerCalendar.setEvents( window.JSON.parse(data) );
    		jQueryCalendar("#calendar").fullCalendar('addEventSource', controllerCalendar.getEvents());
		}
		
	});
}

var formatDates = function(dateDOM, timeDOM) {
	var date,
		time,
		hour 		= "01",
		minute 		= "00",
		formatDate 	= "";

	date 	= dateDOM.val();
	if( timeDOM.val() !== undefined )
		time = timeDOM.combodate('getValue');
	else
		time = hour + ':' + minute;	

	formatDate 	= date + " " + time + ":00";
	return formatDate;
}

var transformDurationToDate = function(dateDOM, hourDOM, minuteDOM, durationDOM) {
	var date,
		hour 		= "01",
		minute 		= "00",
		duration  	= 0,
		formatDate 	= "",
		offset 		= 0;

	date 	= dateDOM.val();
	if( hourDOM.val() !== 'undefined' )
		hour 	= hourDOM.val();
	if( minuteDOM.val() !== 'undefined' )
		minute 	= minuteDOM.val();
	duration = parseInt(durationDOM.val());
	offset 	= jQueryCalendar.fullCalendar.moment().utcOffset();

	formatDate = date + " " + hour + ":" + minute + ":00";
	formatDate = moment(formatDate).add(duration, "m").format("YYYY-MM-DD HH:mm:ss");
	return formatDate;
}

var transformUTCtoOffset = function(date, timezone) {
	return moment.tz(moment.utc(date), timezone).format("YYYY-MM-DD HH:mm:ss");
}

var transformOffsetToUTC = function(date, timezone) {
	return moment.utc(moment.tz(date, timezone).format()).format("YYYY-MM-DD HH:mm:ss");
}

var transformToMonth = function(date) {
	return parseInt(moment(date).format("YYYYMM"));
}

var validateDates = function(start, end) {
	return moment(end).isSameOrAfter(start);
}
