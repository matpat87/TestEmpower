"use strict";

var controllerCalendar = (function($, api) {
	
	var firstDayWeek,	
		currentTimezone ,
		events = [],
		actualDate = null,
		actualEvent = null;
		
	var newPanel,
		modifyPanel;

	var setTimezone = function(tz) {
		currentTimezone = tz;
	};	

	var getTimezone = function() {
		return currentTimezone;
	};

	var setEvents = function(e) {
		events = e;
	};

	var getEvents = function() {
		return events;
	};

	var init = function(timezone, fdow) {
		
		firstDayWeek = fdow;
		currentTimezone = timezone;
		
		$([]).add("#nextButton").add("#backButton").add("#createEvent").add("#modifyButton").add("#deleteButton").add("#modifyEvent").button();

		$("#selectable-timezones").selectable({
			  stop: function() {
				  if ($("#" + this.id + " .ui-selected").length !== 1) {
					  
					  var first = $("#" + this.id + " .ui-selected:first");
					  
					  $("#" + this.id + " .ui-selected").removeClass("ui-selected");
					  first.addClass("ui-selected");
				  }
			  }
		});
		
		$([]).add("#selectable-countries").add("#selectable-categories").selectable();
		
		$(".multiselect").multiselect({
			selectedList: 3,
			header: true,
			checkAllText: "Check all"
		});

		$("#toggleFilter").change(function()
		{
			if (this.checked) {
				
				$("[name='ac']").prop('checked', true);
			} else {
				
				$("[name='ac']").prop('checked', false);
			}
		});
		
		$("#selectedFilter").change(function()
		{
			if( this.checked ) {
				
				$("[class='ui-widget-content ui-selectee']").css('display', 'none');
			} else {
				
				$("[class='ui-widget-content ui-selectee']").css('display', 'list-item');
			}
		});
		
		newPanel = $("#panel-new").dialog({
			autoOpen: false,
			height: 650,
			width: 625,
			modal: true,
			close: function()
			{
				if (typeof cleanTreejs !== 'undefined')
			  		cleanTreejs();
				actualDate = null;
				$("#properties").css("display", "none");
				$("#content-ajax").empty();
				$("#category").css("display", "block");
			}
		});

		modifyPanel = $("#panel-modify").dialog({
			autoOpen: false,
			height: 650,
			width: 625,
			modal: true,
			close: function()
			{
				if (typeof cleanTreejs !== 'undefined')
			  		cleanTreejs();
				actualEvent = null;
				$("#modify-properties").css("display", "none");
				removeEventProperties();
				$("#view-event").css("display", "block");
			}
		});

		$("#moreInfo").accordion({
			collapsible: true,
			active: false,
			heightStyle: "content"
		});
		
		$("#calendarContent").removeClass("calendarContent");
		
		createCalendar();
	};
	
	var createCalendar = function() {
		
		$("#calendar").fullCalendar({
			header: {
				left: "prev,next today",
				center: "title",
				right: "month,agendaWeek,agendaDay"
			},
			firstDay: firstDayWeek,
			displayEventEnd: true,
			ignoreTimezone: false,
			timeFormat: "H:mm",
			timezone: currentTimezone,
			nextDayThreshold: '00:00:00',
			eventLimit: true,
			events: events,
			viewRender: function(view, element) {
				
				pullEvents(view.intervalStart);
			},
			eventClick: function(event, jsEvent, view) {
				
				actualEvent = event;
				initializeModifyForm( actualEvent.category, actualEvent.id );
				modifyPanel.dialog("open");
			},
			dayClick: function(date, jsEvent, view) {
				
				actualDate = date;
				newPanel.dialog("open");
			}
		});
	};
	
	var destroyCalendar = function() {
		
		$("#calendar").fullCalendar("destroy");
	};
	
	var next = function() {
		
		initializeNewForm( $("#selectCategory").val(), 0 );
	};
	
	var back = function() {
		
		$("#properties").css("display", "none");
		$("#content-ajax").empty();
		$("#category").css("display", "block");
	};
	
	var modify = function() {
		
		$("#view-event").css("display", "none");
		if ($("#visibility").val() === "public") $(".hideRole").css("display", "none");
		$("#modify-properties").css("display", "block");
	};
	
	var createEvent = function() {
		
		var language,
			text;

		language = SUGAR.language.get('asol_CalendarEvents', 'LBL_MESSAGE_INVALID_DATES');
		text = language !== 'undefined' ? language : 'The Dates are not filled correctly'; 

		var properties = {};
		
		properties['id'] = null;
		properties = obtainCategory(properties);
		properties = obtainTimezone(properties);
		properties = obtainEventDates(properties);
		properties = obtainDomains(properties);
		properties = obtainInfo(properties);
		properties = obtainCustomValues( properties, "content-ajax" );
		
		if (validateDates(properties['start'], properties['end'])) {
		
			api.saveEvent(properties).done(function(data) {
				pullEvents( $("#calendar").fullCalendar('getView').intervalStart );
				newPanel.dialog("close");
			});
		} else {
			
			alert(text);
		}
	};
	
	var modifyEvent = function() {
		
		var language,
			text;

		language = SUGAR.language.get('asol_CalendarEvents', 'LBL_MESSAGE_INVALID_DATES');
		text = language !== 'undefined' ? language : 'The Dates are not filled correctly'; 

		var properties = {};
		
		properties['id'] = actualEvent.id;
		properties = obtainTimezone(properties);
		properties = obtainEventDates(properties);
		properties = obtainDomains(properties);
		properties = obtainInfo(properties);
		properties = obtainCustomValues( properties, "modify-ajax" );
		
		if (validateDates(properties['start'], properties['end'])) {
			
			api.saveEvent(properties).done(function(data) {
				pullEvents( $("#calendar").fullCalendar('getView').intervalStart );
				modifyPanel.dialog("close");
			});
		} else {
			
			alert(text);
		}
	};
	
	var deleteEvent = function() {

		var language,
			text;

		language = SUGAR.language.get('asol_CalendarEvents', 'LBL_MESSAGE_CONFIRMATION_DELETE');
		text = language !== 'undefined' ? language : 'This event will be permanently deleted and cannot be recovered. Are you sure?';  

		if(confirm(text)) {
			
			api.deleteEvent(actualEvent.id).done(function(data) {
				$("#calendar").fullCalendar("removeEvents", actualEvent.id);
				modifyPanel.dialog("close");
			});
			
		} else {
			
			modifyPanel.dialog("close");
		}
	};
	
	var applyFilter = function() {
		
		currentTimezone = $("#selectable-timezones .ui-selected:first").attr('title');
		pullEvents( $("#calendar").fullCalendar('getView').intervalStart );
	};
	
	var initializeNewForm = function(type, id) {
		
		api.obtainForm(type, id).done(function(data) {

			$("#content-ajax").append(data);
			
			initializePanelLibs();
			
			$('#initialDate').val(moment(moment(actualDate).format()).format('YYYY-MM-DD'));
			if( $("#initialTime").length !== 0 )
				$('#initialTime').combodate( 'setValue', moment(actualDate).format("HH:mm") );
			
			$(".titleCategory").html( $("#selectCategory option:selected").text() );
			
			$("#category").css("display", "none");
			$("#properties").css("display", "block");
		});
	};
	
	var initializeModifyForm = function(type, id) {
		
		api.obtainForm(type, id).done(function(data) {
			
			$("#modify-ajax").append(data);
			
			initializePanelLibs();
			populateForm();
			displayEventProperties();
		});
	};
	
	var initializePanelLibs = function() {
		
		$("#asol_domains_publish_feature_button").button();
		
		$([]).add($("#visibility")).change(function() {
			
			if( $(this).val() !== "public" )
				$(".hideRole").css("display","inline-flex");
			else
				$(".hideRole").css("display","none");
		});

		$(".datePicker").datepicker({
			dateFormat: "yy-mm-dd"
		});
		
		$([]).add("#initialTime").add("#finalTime").combodate({
			customClass: 'text ui-widget-content ui-corner-all inputText',
			firstItem: 'name',
			minuteStep: 1
		});
		
		$(".multiselect").multiselect({
			selectedList: 3,
			header: true,
			checkAllText: "Check all"
		});
		
		if( $("#info").length !== 0 ) {
			CKEDITOR.replace('info',{
				customConfig: 'ckeditor_config.js'
			});
		}
	};
	
	var populateForm = function() {
		
		var exceptions = {
			title	: 'title',
			initialDate : 'initialDate',
			initialTime : 'initialTime',
			finalDate : 'finalDate',
			finalTime : 'finalTime',
			info : 'info',
			publish_mode : 'publish_mode',
			selectedLevels : 'selectedLevels',
			asol_multi_create_domain : 'asol_multi_create_domain',
		};
		
		$("#title").val(actualEvent.title);
		
		if (actualEvent.allDay) {
			
			$('#initialDate').val( (actualEvent.start).format('YYYY-MM-DD') );
			$('#finalDate').val( moment(actualEvent.end).subtract(1, 'day').format('YYYY-MM-DD') );
			
		} else {
			
			$('#initialDate').val( (actualEvent.start).format('YYYY-MM-DD') );
			$('#initialTime').combodate( 'setValue', (actualEvent.start).format('HH:mm') );
			
			$('#finalDate').val( (actualEvent.end).format('YYYY-MM-DD') );
			$('#finalTime').combodate( 'setValue', (actualEvent.end).format('HH:mm') );
		}
		
		if( typeof retrievePublishDomainTree !== 'undefined' )
			retrievePublishDomainTree(actualEvent.asol_domain_published_mode, actualEvent.asol_domain_child_share_depth, actualEvent.asol_multi_create_domain);
		
		CKEDITOR.instances.info.setData(actualEvent.info);
		
		$('#modify-ajax :input').each( function(index, element) {
			
			if (this.id !== '' && (exceptions[this.id] === undefined)) {
				
				if (this.type == 'text') {
					
					this.value = actualEvent[this.id];
					
				} else if (this.type == 'checkbox') {
					
					if (actualEvent[this.id])
						$('#'+this.id).prop('checked', true);
					else
						$('#'+this.id).prop('checked', false);
					
				} else if (this.type == 'radio') {
					
					if (actualEvent[this.name] === this.id)
						$('#'+this.id).prop('checked', true);
					
				} else if ($(this).is('select')) {
					
					if (!$(this).attr('multiple')) {
						
						$('#'+ this.id  +" option[value='"+ actualEvent[this.id] +"']").prop('selected', 'selected');
						
					} else {
						
						var probando = this.id;
						if( actualEvent[this.id] != null)
						{
							var array = actualEvent[this.id].slice(1,-1).split(';;');
							array.forEach(function(element, index)
							{
								$('#'+ probando +" option[value='"+ element +"']").prop('selected', 'selected');
							});
							$('#'+this.id).multiselect('refresh');
						}
					}
				}
			}
		});
	};
	
	var obtainCategory = function(properties) {
		
		properties['category'] = $("#selectCategory").val();
		
		return properties;
	};
	
	var obtainTimezone = function(properties) {
		
		var localTimezone = $("#selectable-timezones .ui-selected:first").attr('title');
		
		properties['timezone'] = localTimezone;
		
		return properties;
	};
	
	var obtainEventDates = function(properties) {
		
		if ($('#allDay').is(':checked')) {
			
			properties['start'] = formatDates($('#initialDate'), $('#initialTime'));
			properties['end'] = formatDates($('#finalDate'), $('#finalTime'));
		} else {
			
			properties['start'] = formatDates($('#initialDate'), $('#initialTime'));
			properties['start'] = moment.utc(transformOffsetToUTC(properties['start'], currentTimezone)).format('YYYY-MM-DD HH:mm:ss');
				
			properties['end'] = formatDates($('#finalDate'), $('#finalTime'));
			properties['end'] 	= moment.utc(transformOffsetToUTC(properties['end'], currentTimezone)).format('YYYY-MM-DD HH:mm:ss');
		}
		
		properties['month'] = transformToMonth(properties['end']);
		
		return properties;
	};
	
	var obtainDomains = function(properties) {
		
		if ($("#asol_domains_publish_feature_button").length == 0) {
			
			properties['asol_domain_published_mode'] 	= "1";
			properties['asol_domain_child_share_depth'] = ";;";
			properties['asol_multi_create_domain'] 		= ";;";
			properties['asol_published_domain'] 		= 1;
		} else {
			
			properties['asol_domain_published_mode'] 	= $("#publish_mode").val();
			properties['asol_domain_child_share_depth'] = $("#selectedLevels").val(";" + $("#domainsPublishingDiv").find("li.markerLevel.jstree-checked").map(function(){ var currentLevel = $(this).attr("level"); return $(this).closest("li.level"+(currentLevel - 1)).attr("domain") }).get().join(";;") + ";").val();
			properties['asol_multi_create_domain'] 		= $("#asol_multi_create_domain").val(";" + $("#domainsPublishingDiv").find("li.domainCheck.jstree-checked").map(function(){ return $(this).attr("domain") }).get().join(";;") + ";").val();
			if ($("#asol_published_domain").is(":checked") === true)
				properties['asol_published_domain'] = 1;
			else 
				properties['asol_published_domain'] = 0;
		}
		
		return properties;
	};
	
	var obtainInfo = function(properties) {
		
		properties['info'] = CKEDITOR.instances.info.getData();
		
		return properties;
	};
	
	var obtainCustomValues = function(properties, form) {
		
		var exceptions = {
			initialDate : 'initialDate',
			initialTime : 'initialTime',
			finalDate : 'finalDate',
			finalTime : 'finalTime',
			info : 'info',
			publish_mode : 'publish_mode',
			selectedLevels : 'selectedLevels',
			asol_multi_create_domain : 'asol_multi_create_domain',
			asol_published_domain : 'asol_published_domain',
		};
		
		$('#'+ form +' :input').each( function(index, element) {
			
			if (this.id !== '' && (exceptions[this.id] === undefined)) {
				
				if( this.type == 'text' ) {
					
					properties[this.id] = this.value;
				} else if( this.type == 'checkbox' ) {
					
					properties[this.id] = $("#"+this.id).is(':checked');
				} else if( this.type == 'radio' ) {
					
					 if( $('#'+this.id).is(':checked') ) properties[this.name] = this.value;
				} else if( $(this).is('select') ) {
					
					if( !$(this).attr('multiple') ) {
						
						properties[this.id] = this.value;
					} else {
						
						var tempString	= '', 
							tempArray 	= $('#'+this.id).multiselect('getChecked').map(function() { return this.value; }).get();
						
		  				tempArray.forEach(function(currentOption) {
		  					tempString += ';' + currentOption + ';';
		  				});
		  				
		  				properties[this.id] = tempString;
					}
				}
			}
		});
		
		return properties;
	};
	
	var displayEventProperties = function() {
		
		var exceptions = {
			title : 'title',
			allDay : 'allDay',
			initialDate : 'initialDate',
			initialTime : 'initialTime',
			finalDate : 'finalDate',
			finalTime : 'finalTime',
			info : 'info',
			publish_mode : 'publish_mode',
			selectedLevels : 'selectedLevels',
			asol_multi_create_domain : 'asol_multi_create_domain',
			asol_published_domain : 'asol_published_domain',
		};
		
		$(".titleEvent").css('background-color', actualEvent.backgroundColor).css('color', actualEvent.textColor);
		$(".titleEvent").html( actualEvent.title + '<p class="subtitleEvent">(' + $("#selectCategory [value='"+ actualEvent.category +"']").text()  + ')</p>');
		
		if (actualEvent.allDay) {
			
			$("#displayTime").append('<span id="titleInitTime" class="titleTime">Start At:</span>' + 
						'<span id="displayInitTime" class="dataTime">' + (actualEvent.start).format("MM/DD") + '</span>' +
						' &nbsp; <span id="titleFinalTime" class="titleTime">End At:</span>' + 
						'<span id="displayFinalTime" class="dataTime">' + moment(actualEvent.end).subtract(1, 'day').format("MM/DD") + '</span>');
			
		} else {
			
			$("#displayTime").append('<span id="titleInitTime" class="titleTime">Start At:</span>' + 
					'<span id="displayInitTime" class="dataTime">' + (actualEvent.start).format("MM/DD - HH:mm") + '</span>' +
					' &nbsp; <span id="titleFinalTime" class="titleTime">End At:</span>' + 
					'<span id="displayFinalTime" class="dataTime">' + (actualEvent.end).format("MM/DD - HH:mm") + '</span>');
			
		}
		
		$("#displayInfo").append('<span class="titleInfo">Description:</span>' + 
				'<span class="dataInfo">'+ actualEvent.info +'</span>');

		$("#contentMoreInfo").append('<div class="titleDisplay"> Timezone: ' +
				'<span class="dataDisplay">'+ actualEvent.timezone +'</span></div><br>');
		
		$("#modify-ajax :input").each(function(index, element) {
			
			if (this.id !== '' && (exceptions[this.id] === undefined)) {
				
				if (this.type == 'text') {
					
					var label = this.id;
					if( this.id.slice(this.id.length-2, this.id.length) === '_c' )
						label = this.id.slice(0, this.id.length-2).replace(/_/g, " ");
					
					$("#contentMoreInfo").append('<div class="titleDisplay">'+  label.charAt(0).toUpperCase() + label.slice(1) +': ' +
							'<span class="dataDisplay">'+ actualEvent[this.id] +'</span></div><br>');
					
				} else if (this.type == "checkbox") {
					
					var label = this.id;
					if( this.id.slice(this.id.length-2, this.id.length) === '_c' )
						label = this.id.slice(0, this.id.length-2).replace(/_/g, " ");
					
					$("#contentMoreInfo").append('<div class="titleDisplay">'+  label.charAt(0).toUpperCase() + label.slice(1) +': ' +
							'<span class="dataDisplay">'+ actualEvent[this.id] +'</span></div><br>');
					
				} else if (this.type == "radio") {
					
					if (actualEvent[this.name] === this.id) {
						
						var label = this.name;
						if( this.name.slice(this.name.length-2, this.name.length) === '_c' )
							label = this.name.slice(0, this.name.length-2).replace(/_/g, " ");
						
						$("#contentMoreInfo").append('<div class="titleDisplay">'+  label.charAt(0).toUpperCase() + label.slice(1) +': ' +
							'<span class="dataDisplay">'+ actualEvent[this.name] +'</span></div><br>');
					}
					
				} else if ($(this).is("select")) {
					
					if (!$(this).attr("multiple")) {
						
						var label = this.id;
						if (this.id.slice(this.id.length-2, this.id.length) === '_c')
							label = this.id.slice(0, this.id.length-2).replace(/_/g, " ");
						
						$("#contentMoreInfo").append('<div class="titleDisplay">'+  label.charAt(0).toUpperCase() + label.slice(1) +': ' +
								'<span class="dataDisplay">'+ $("#"+ this.id +" option[value='"+ actualEvent[this.id] +"']").text() +'</span></div><br>');
						
					} else {
						
						var label = this.id;
						if (this.id.slice(this.id.length-2, this.id.length) === '_c')
							var label = this.id.slice(0, this.id.length-2).replace(/_/g, " ");
						
						if (actualEvent[this.id] != null) {
							
							var optionsArray = actualEvent[this.id].slice(1,-1).split(";;");
							var id = this.id;
							
							var html = "";
							if (actualEvent[this.id] !== "") {
								
								html += '<div class="titleDisplay">'+  label.charAt(0).toUpperCase() + label.slice(1) + ': ';
								
								optionsArray.forEach(function(element, index)
								{
									html += '<span class="dataDisplay">'+ $("#"+ id +" option[value='"+ element +"']").text() +',</span>&nbsp;';
								});
								
								html += '</div><br>';
							}
							
							$("#contentMoreInfo").append(html);
						}
					}
				}
			}
		});
	};
	
	var removeEventProperties = function() {
		
		$([]).add(".titleEvent").add("#displayTime").add("#displayInfo").add("#contentMoreInfo").add("#modify-ajax").empty();
	};
	
	return {
		setTimezone : setTimezone,
		getTimezone : getTimezone,
		setEvents : setEvents,
		getEvents : getEvents,

		init : init,
		next : next,
		back : back,
		modify : modify,
		createEvent : createEvent,
		modifyEvent : modifyEvent,
		deleteEvent : deleteEvent,
		applyFilter : applyFilter,
		getTimezone : getTimezone,
	};
	
})(jQueryCalendar, calendarApi);

jQueryCalendar(function() {
	controllerCalendar.init(window.sugarUserTimezone, window.fdow);
});
