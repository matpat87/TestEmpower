jQuery.fn.toHtmlString = function() {
	return $('<div></div>').html($(this).clone()).html();
};

$(document).ready(function() {
	// loadFlowChartJsFile();
});

$(window).unload(function() {
});

function loadFlowChartJsFile() {
	console.log('[loadFlowChartJsFile()]');
	
	jsPlumb.unload();
	loadSeveralFeaturesFlowChart();
	loadJsPlumb();
	loadQtip();
	
	switch ($("#dragAndDropAction").val()) {
		case 'moveNode':
		case 'cloneOnlyNode':
		case 'cloneNodeAndDescendants':
			loadDragAndDrop();
			break;
		case 'orderTasks':
			loadSortable();
			break;
	}
	
	loadGrowl();
}

function destroyDragAndDrop() {
	console.log('[destroyDragAndDrop()]');
	
	// #newObjects
	$("#newObjects [module='asol_Events']").draggable('destroy');
	$("#newObjects [module='asol_Activity']").draggable('destroy');
	$("#newObjects [module='asol_Task']").draggable('destroy');
	
	// #workflow
	$("#workflow [module='asol_Events']").draggable('destroy');
	$("#workflow [module='asol_Activity']").draggable('destroy');
	$("#workflow [module='asol_Task']").draggable('destroy');
	
	// #workflow
	$("#recycleBin [module='asol_Events']").draggable('destroy');
	$("#recycleBin [module='asol_Activity']").draggable('destroy');
	$("#recycleBin [module='asol_Task']").draggable('destroy');
	
	// #workflow
	$("#workflow").droppable('destroy');
	$("#workflow [module='asol_Events']").droppable('destroy');
	$("#workflow [module='asol_Activity']").droppable('destroy');
	
	// #recycleBin
	$("#recycleBin").droppable('destroy');
	$("#recycleBin [module='asol_Events']").droppable('destroy');
	$("#recycleBin [module='asol_Activity']").droppable('destroy');
}

function helper(item) {
	
	var dragAndDropContainer = $("#dragAndDropContainer").val();
	
	if (item.closest('#newObjects').length) {
		
		switch (dragAndDropContainer) {
			case 'window':

				var itemHtml = item.clone().show().toHtmlString();
				
				var auxHtml = '\
					<div id="newObjects" class="helperForJstree jstree jstree-0 jstree-focused jstree-default">\
						<ul>\
							<li>\
								<ul>\
									<li rel="' + item.parent().attr("rel") + '">\
										'
						+ itemHtml + '\
									</li>\
								</ul>\
							</li>\
						</ul>\
					</div>\
				';
				
				return $(auxHtml).css({
					opacity : 0
				}).show();
				break;
			default:
				return item.clone().css({}).show();
				break;
		}
		
	} else if (item.closest('#workflowContent').length) {
		
		switch (dragAndDropContainer) {
			case 'window':

				return item.clone().css({}).appendTo('body').show();
				return $(auxHtml).css({
					opacity : 0
				}).show();
				break;
			default:
				return item.clone().css({}).appendTo('#workflowContent').show();
				break;
		}
		
	} else if (item.closest('#recycleBinEvents').length) {
		
		switch (dragAndDropContainer) {
			case 'window':
				return item.clone().css({}).appendTo('body').show();
				break;
			default:
				return item.clone().css({}).appendTo('#recycleBinEvents').show();
				break;
		}
		
	} else if (item.closest('#recycleBinActivities').length) {
		
		switch (dragAndDropContainer) {
			case 'window':
				return item.clone().css({}).appendTo('body').show();
				break;
			default:
				return item.clone().css({}).appendTo('#recycleBinActivities').show();
				break;
		}
		
	} else if (item.closest('#recycleBinTasks').length) {
		
		switch (dragAndDropContainer) {
			case 'window':
				return item.clone().css({}).appendTo('body').show();
				break;
			default:
				return item.clone().css({}).appendTo('#recycleBinTasks').show();
				break;
		}
		
	}
}

function loadDragAndDrop() {
	console.log('[loadDragAndDrop()]');
	
	// Draggable
	
	var dragAndDropContainer = $("#dragAndDropContainer").val();
	
	var draggableOptionsCommon = {
		revert : "invalid", // when not dropped, the item will revert back to its initial position
		// helper : 'clone',
		
		helper : function() {
			return helper($(this));
		},
		
		// cursor : "move",
		opacity : 0.8,
		zIndex : 100000000
	};
	
	if (dragAndDropContainer == 'window') {
		
		draggableOptionsCommon = $.extend({
			appendTo : 'body'
		}, draggableOptionsCommon);
	}
	
	// #newObjects
	$("#newObjects [module='asol_Events']").draggable(draggableOptionsCommon);
	$("#newObjects [module='asol_Activity']").draggable(draggableOptionsCommon);
	$("#newObjects [module='asol_Task']").draggable(draggableOptionsCommon);
	
	// #workflow
	$("#workflow [module='asol_Events']").draggable(draggableOptionsCommon);
	$("#workflow [module='asol_Activity']").draggable(draggableOptionsCommon);
	$("#workflow [module='asol_Task']").draggable(draggableOptionsCommon);
	
	// #workflow
	$("#recycleBin [module='asol_Events']").draggable(draggableOptionsCommon);
	$("#recycleBin [module='asol_Activity']").draggable(draggableOptionsCommon);
	$("#recycleBin [module='asol_Task']").draggable(draggableOptionsCommon);
	
	// Droppable
	
	var droppableOptionsCommon = {
		greedy : true,
		tolerance : "pointer",
		activeClass : "droppableActive",
		hoverClass : "droppableHover",
		drop : function(event, ui) {
			console.log('[loadDragAndDrop()] drop event=[', event, '] ui=[', ui, ']');
			
			var dragAndDropAction = $("#dragAndDropAction").val();
			
			var fromLayout = ui.draggable[0].getAttribute('layoutId');
			
			switch (fromLayout) {
				case 'newObjects':

					var draggedNodeAux = ui.draggable;
					var targetNode = $(event.target);
					
					var draggedNodeModule = draggedNodeAux.attr("module");
					switch (draggedNodeModule) {
						case 'asol_Events':
							draggedNode = new DraggedNode(draggedNodeModule, new asol_Event(draggedNodeAux.attr("trigger_type"), draggedNodeAux.attr("trigger_event"), draggedNodeAux.attr("scheduled_type"), draggedNodeAux.attr("subprocess_type")));
							break;
						case 'asol_Activity':
							draggedNode = new DraggedNode(draggedNodeModule, new asol_Activity());
							break;
						case 'asol_Task':
							draggedNode = new DraggedNode(draggedNodeModule, new asol_Task(draggedNodeAux.attr("task_type")));
							break;
					}
					
					var validTargetNode = new ValidTargetNode(targetNode);
					
					switch (event.target.id) {
						
						case 'recycleBin':

							switch (dragAndDropAction) {
								case 'moveNode':
								case 'cloneOnlyNode':
								case 'cloneNodeAndDescendants':
									createObjectAndRelationship(draggedNode, validTargetNode);
									break;
							}
							
							break;
						
						case 'workflow':

							switch (dragAndDropAction) {
								case 'moveNode':
								case 'cloneOnlyNode':
								case 'cloneNodeAndDescendants':
									createObjectAndRelationship(draggedNode, validTargetNode);
									break;
							}
							
							break;
						
						default:

							switch (dragAndDropAction) {
								case 'moveNode':
								case 'cloneOnlyNode':
								case 'cloneNodeAndDescendants':
									createObjectAndRelationship(draggedNode, validTargetNode);
									break;
							}
							
							break;
					}
					
					break;
				
				default:

					switch (event.target.id) {
						
						case 'recycleBin':

							switch (dragAndDropAction) {
								case 'moveNode':
									removeNode(ui.draggable[0].getAttribute('module'), ui.draggable[0].id);
									break;
								case 'cloneOnlyNode':
								case 'cloneNodeAndDescendants':
									cloneNode(dragAndDropAction, ui.draggable[0].getAttribute('relationship'), ui.draggable[0].getAttribute('module'), ui.draggable[0].id, null, event.target.id);
									break;
							}
							
							break;
						
						case 'workflow':
						default:

							switch (dragAndDropAction) {
								case 'moveNode':
									moveNode(ui.draggable[0].getAttribute('relationship'), ui.draggable[0].getAttribute('module'), ui.draggable[0].id, event.target.getAttribute('module'), event.target.id);
									break;
								case 'cloneOnlyNode':
								case 'cloneNodeAndDescendants':
									cloneNode(dragAndDropAction, ui.draggable[0].getAttribute('relationship'), ui.draggable[0].getAttribute('module'), ui.draggable[0].id, event.target.getAttribute('module'), event.target.id);
									break;
							}
							
							break;
					}
					
					break;
			}
			
		}
	};
	
	// #workflow
	$("#workflow").droppable($.extend({
		// accept : "#newObjects [module='asol_Events'], #recycleBin [module='asol_Events']"
		accept : function(draggableNode) {
			console.log("[loadDragAndDrop()] accept draggableNode=[", draggableNode, "] $(this)=[", $(this), "]");
			
			var accept = false;
			
			if (draggableNode.is("#newObjects [module='asol_Events'], #recycleBin [module='asol_Events']")) {
				accept = true;
			}
			
			return accept;
		}
	}, droppableOptionsCommon));
	$("#workflow [module='asol_Events']").droppable($.extend({
		accept : "#newObjects [module='asol_Activity'], #workflow [module='asol_Activity'], #recycleBin [module='asol_Activity']"
	}, droppableOptionsCommon));
	$("#workflow [module='asol_Activity']").droppable($.extend({
		// accept : "#newObjects [module='asol_Activity'], #newObjects [module='asol_Task'], #workflow [module='asol_Activity'], #workflow [module='asol_Task'], #recycleBin [module='asol_Activity'], #recycleBin [module='asol_Task']"
		accept : function(draggableNode) {
			var accept = false;
			
			var dragAndDropAction = $("#dragAndDropAction").val();
			
			if (draggableNode.is("#workflow [module='asol_Task']")) {
				
				switch (dragAndDropAction) {
					case 'moveNode':
						if ((draggableNode.closest($(this)).length == 0)) { // activity is not parent of the dragging-task
							accept = true;
						}
						break;
					case 'cloneOnlyNode':
					case 'cloneNodeAndDescendants':
						accept = true;
						break;
				}
			}
			
			if (draggableNode.is("#newObjects [module='asol_Activity'], #newObjects [module='asol_Task'], #workflow [module='asol_Activity'], #recycleBin [module='asol_Activity'], #recycleBin [module='asol_Task']")) {
				accept = true;
			}
			
			return accept;
		}
	}, droppableOptionsCommon));
	
	// #recycleBin
	$("#recycleBin").droppable($.extend({
		accept : "#newObjects [module='asol_Events'], #newObjects [module='asol_Activity'], #newObjects [module='asol_Task'], #workflow [module='asol_Events'], #workflow [module='asol_Activity'], #workflow [module='asol_Task']"
	}, droppableOptionsCommon));
	$("#recycleBin [module='asol_Events']").droppable($.extend({
		accept : "#newObjects [module='asol_Activity'], #workflow [module='asol_Activity'], #recycleBin [module='asol_Activity']"
	}, droppableOptionsCommon));
	$("#recycleBin [module='asol_Activity']").droppable($.extend({
		// accept : "#newObjects [module='asol_Activity'], #newObjects [module='asol_Task'], #workflow [module='asol_Activity'], #recycleBin [module='asol_Activity'], #workflow [module='asol_Task'], #recycleBin [module='asol_Task']"
		
		accept : function(draggableNode) {
			var accept = false;
			
			var dragAndDropAction = $("#dragAndDropAction").val();
			
			if (draggableNode.is("#recycleBin [module='asol_Task']")) {
				
				switch (dragAndDropAction) {
					case 'moveNode':
						if ((draggableNode.closest($(this)).length == 0)) { // activity is not parent of the dragging-task
							accept = true;
						}
						break;
					case 'cloneOnlyNode':
					case 'cloneNodeAndDescendants':
						accept = true;
						break;
				}
			}
			
			if (draggableNode.is("#newObjects [module='asol_Activity'], #newObjects [module='asol_Task'], #workflow [module='asol_Activity'], #recycleBin [module='asol_Activity'], #workflow [module='asol_Task']")) {
				accept = true;
			}
			
			return accept;
		}
	}, droppableOptionsCommon));
	
}

function loadSeveralFeaturesFlowChart() {
	console.log('[loadSeveralFeaturesFlowChart()]');
	
	// Check to see if the window is top if not then display button
	$("#workflowContent").scroll(function() {
		scrollToTopArrowVisibility();
	});
	
	// Click event to scroll to top
	$('.scrollToTop').click(function() {
		$('#workflowContent').animate({
			scrollTop : 0
		}, 800);
		return false;
	});
	
	// When pressing 'Ctrl' key + 'Space' key => complete names
	$(document).keypress(function(e) {
		if (e.which == 32) { // space key was pressed
			if (e.ctrlKey) { // 
				toggleEllipsis();
			}
		}
	});
	
	// When pressing 'Ctrl' key and clicking on a link => redirect to EditView (instead of DetailView when only clicking without pressing)
	$(".redirectLink").click(function(event) {
		
		var viewType = "wfeEditView";
		// if (event.ctrlKey) {
		// viewType = "DetailView";
		// }
		
		var module = $(this).attr("link_module");
		var id = $(this).attr("link_record");
		var url = 'index.php?module=' + module + '&action=' + viewType + '&record=' + id;
		/*
		if ((typeof window.opener !== 'undefined') && (window.opener != null)) {
			window.opener.location = url;
		}
		*/

		url = url + '&sugar_body_only=true';
		
		forceOpenPanelSouth = true;
		
		loadObjectEditor(url);
		
	});
	
}

function loadJsPlumb() {
	console.log('[loadJsPlumb()]');
	// alert("jsPlumb is now loaded");
	
	var jsPlumbDefaults = {
		// default to blue at one end and green at the other
		EndpointStyles : [ {
			fillStyle : '#225588'
		}, {
			fillStyle : '#225588'
		} ],
		// EndpointStyles : [ null, null ],
		// blue endpoints 7 px; green endpoints 11.
		// Endpoints : [ [ "Dot", {radius:3} ], [ "Rectangle", { width :10, height: 10 } ]],
		Endpoints : [ [ "Dot", {
			radius : 3
		} ], [ "Dot", {
			radius : 3
		} ] ],
		// Endpoints : [ "Blank", "Blank" ],
		// the overlays to decorate each connection with.
		//
		ConnectionOverlays : [ [ "Arrow", {
			location : 0.5
		} ] ],
		
		// Connector : [ "Flowchart", { stub:10 } ],
		// Connector : [ "Bezier", { curviness:1 } ],
		Connector : [ "Straight" ],
		// Connector : [ "StateMachine", {curviness :0} ],
		// 
		Anchors : [ "RightMiddle", "LeftMiddle" ],
		//
		PaintStyle : {
			lineWidth : 3,
			strokeStyle : "#deea18",
			joinstyle : "round"
		},
		//
		HoverPaintStyle : {
			lineWidth : 5,
			strokeStyle : "#2e2aF8"
		}
	};
	
	jsPlumb.bind("ready", function() {
		// your jsPlumb related init code goes here
		
		uiLayoutCenter = jsPlumb.getInstance({
			container : "workflow"
		});
		uiLayoutCenter.importDefaults(jsPlumbDefaults);
		
		recycleBinEvents = jsPlumb.getInstance({
			container : "recycleBinEvents"
		});
		recycleBinEvents.importDefaults(jsPlumbDefaults);
		
		recycleBinActivities = jsPlumb.getInstance({
			container : "recycleBinActivities"
		});
		recycleBinActivities.importDefaults(jsPlumbDefaults);
		
		generateConnectionsUiLayoutCenter();
		generateConnectionsRecycleBinEvents();
		generateConnectionsRecycleBinActivities();
		
		// /////////////
		// Drag&Drop //
		// /////////////
		
		selectEndpointInsideWorkflow = jsPlumb.getInstance({
			container : "workflow",
			scope : "workflow",
			ConnectionOverlays : [ [ "Arrow", {
				location : 0.5
			} ] ]
		});
		
		selectEndpointInsideRecycleBinEvents = jsPlumb.getInstance({
			container : "recycleBinEvents",
			scope : "recycleBinEvents",
			ConnectionOverlays : [ [ "Arrow", {
				location : 0.5
			} ] ]
		});
		
		selectEndpointInsideRecycleBinActivities = jsPlumb.getInstance({
			container : "recycleBinActivities",
			scope : "recycleBinActivities",
			ConnectionOverlays : [ [ "Arrow", {
				location : 0.5
			} ] ]
		});
		
		eventSourceEndpoint = {
			isSource : true,
			endpoint : "Dot",
			anchor : "RightMiddle",
			paintStyle : {
				fillStyle : "orange",
				opacity : 0.5,
				radius : 10
			},
			hoverPaintStyle : {
				fillStyle : "greenyellow"
			},
			connector : "Straight",
			connectorStyle : {
				strokeStyle : "#deea18",
				lineWidth : 3
			}
		};
		
		activityTargetEndpoint = {
			isTarget : true,
			endpoint : "Dot",
			anchor : "LeftMiddle",
			paintStyle : {
				fillStyle : "orange",
				opacity : 0.5,
				radius : 10
			},
			hoverPaintStyle : {
				fillStyle : "red"
			},
			dropOptions : {
				hoverClass : "hover_select",
				activeClass : "active_select"
			},
			beforeDrop : function(params) {
				
				var source = $("#" + params.sourceId);
				var target = $("#" + params.targetId);
				
				createRelationship(source.attr("module"), source.attr("id"), target.attr("module"), target.attr("id"), target.attr("relationship"));
				
				return false;
			}
		};
		
		activitySourceEndpoint = {
			isSource : true,
			endpoint : "Dot",
			anchor : "RightMiddle",
			paintStyle : {
				fillStyle : "orange",
				opacity : 0.5,
				radius : 10
			},
			hoverPaintStyle : {
				fillStyle : "greenyellow"
			},
			connector : "Straight",
			connectorStyle : {
				strokeStyle : "#deea18",
				lineWidth : 3
			}
		};
		
		generateEndpointsWorkflow();
		generateEndpointsRecycleBinEvents();
		generateEndpointsRecycleBinActivities();
		
		// Delete relationships
		loadContextMenuForRelationshipWorkflow();
		loadContextMenuForRelationshipRecycleBinEvents();
		loadContextMenuForRelationshipRecycleBinActivities();
		
	});
}

function generateEndpointsWorkflow() {
	console.log('[generateEndpointsWorkflow()]');
	
	// #workflow
	var events = $("#workflow [module='asol_Events']");
	if (events.length > 0) {
		selectEndpointInsideWorkflow.addEndpoint(events, eventSourceEndpoint, {
			scope : "workflow"
		});
	}
	
	var activities = $("#workflow [module='asol_Activity']");
	if (activities.length > 0) {
		selectEndpointInsideWorkflow.addEndpoint(activities, activityTargetEndpoint, {
			scope : "workflow"
		});
		selectEndpointInsideWorkflow.addEndpoint(activities, activitySourceEndpoint, {
			scope : "workflow"
		});
	}
}

function generateEndpointsRecycleBinEvents() {
	console.log('[generateEndpointsRecycleBinEvents()]');
	
	// #recycleBinEvents
	var events = $("#recycleBinEvents [module='asol_Events']");
	if (events.length > 0) {
		selectEndpointInsideRecycleBinEvents.addEndpoint(events, eventSourceEndpoint, {
			scope : "recycleBinEvents"
		});
	}
	
	var activities = $("#recycleBinEvents [module='asol_Activity']");
	if (activities.length > 0) {
		selectEndpointInsideRecycleBinEvents.addEndpoint(activities, activityTargetEndpoint, {
			scope : "recycleBinEvents"
		});
		selectEndpointInsideRecycleBinEvents.addEndpoint(activities, activitySourceEndpoint, {
			scope : "recycleBinEvents"
		});
	}
}

function generateEndpointsRecycleBinActivities() {
	console.log('[generateEndpointsRecycleBinActivities()]');
	
	// #recycleBinActivities
	var activities = $("#recycleBinActivities [module='asol_Activity']");
	if (activities.length > 0) {
		selectEndpointInsideRecycleBinActivities.addEndpoint(activities, activityTargetEndpoint, {
			scope : "recycleBinActivities"
		});
		selectEndpointInsideRecycleBinActivities.addEndpoint(activities, activitySourceEndpoint, {
			scope : "recycleBinActivities"
		});
	}
}

function loadContextMenuForRelationshipWorkflow() {
	uiLayoutCenter.select().each(function(connection) {
		loadContextMenuForRelationshipsCommon(connection, "workflow");
	});
}

function loadContextMenuForRelationshipRecycleBinEvents() {
	recycleBinEvents.select().each(function(connection) {
		loadContextMenuForRelationshipsCommon(connection, "recycleBinEvents");
	});
}

function loadContextMenuForRelationshipRecycleBinActivities() {
	recycleBinActivities.select().each(function(connection) {
		loadContextMenuForRelationshipsCommon(connection, "recycleBinActivities");
	});
}

function loadContextMenuForRelationshipsCommon(connection, scope) {
	console.log('[loadContextMenuForRelationshipsCommon(connection, scope)]');
	console.dir(arguments);
	
	var id = scope + "_" + connection.id;
	connection.canvas.setAttribute("id", id);
	
	$("#" + id).contextmenu({
		menu : [ {
			cmd : "deleteRelationship",
			title : lang('LBL_WFE_DELETE_RELATIONSHIP'),
			uiIcon : "deleteRelationship",
			action : function(event, ui) {
				console.log('[loadContextMenuForRelationshipsCommon] action event=[', event, '] ui=[', ui, '] connection=[', connection, ']');
				
				deleteRelationship(connection.source.attr("module"), connection.source.attr("id"), connection.target.attr("module"), connection.target.attr("id"));
			}
		} ]
	});
}

function scrollToTopArrowVisibility() {
	console.log('[scrollToTopArrowVisibility()]');
	
	$("#scrollToTop").position({
		my : "right bottom",
		at : "right bottom",
		of : "#workflowContent"
	});
	
	if ($("#workflowContent").scrollTop() > 100) {
		$('.scrollToTop').fadeIn();
		
	} else {
		$('.scrollToTop').fadeOut();
	}
}

function loadQtip() {
	console.log('[loadQtip()]');
	
	$("#workflow a, #recycleBinEvents a, #recycleBinActivities a, #recycleBinTasks a").not('#scrollToTop').qtip({
		content : {
			attr : 'qtip_info'
		},
		style : {
			classes : 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position : {
			my : 'top left',
			at : 'bottom left'
		}
	});
	
	$('.condition_icon img, .condition_icon_for_events img').qtip({
		content : {
			attr : 'qtip_info',
			title : {
				text : function(event, api) {
					return lang('LBL_WFE_CONDITIONS') + $(this).attr('node_name');
				},
				button : lang('LBL_WFE_CLOSE')
			}
		},
		style : {
			classes : 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position : {
			my : 'left top',
			at : 'bottom middle'
		},
		show : 'click',
		hide : 'click',
		events : {
			render : function(event, api) {
				$(this).draggable({
					containment : 'window',
					handle : api.elements.titlebar
				});
			}
		}
	});
	
	$('.delay_icon img, .delay_icon_for_task img').qtip({
		content : {
			attr : 'alt'
		},
		style : {
			classes : 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position : {
			my : 'bottom middle',
			at : 'top middle'
		}
	});
	
	/*
	$('.task_call_process_open_subprocess_icon img').qtip({
		content : {
			attr : 'qtip_info'
		},
		style : {
			classes : 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position : {
			my : 'bottom left',
			at : 'top right'
		}
	});
	*/

	/*
	$('a[title]').qtip({
		style : {
			classes : 'ui-tooltip-rounded ui-tooltip-shadow'
		},
		position : {
			my : 'bottom left',
			at : 'top left'
		}
	});
	*/
}

function toggleEllipsis() {
	console.log('[toggleEllipsis()]');
	
	if ($('.aux_name_overflow').hasClass('overflow_ellipsis_enabled')) {
		$('.aux_name_overflow').addClass('overflow_ellipsis_disabled');
		$('.aux_name_overflow').removeClass('overflow_ellipsis_enabled');
	} else {
		$('.aux_name_overflow').addClass('overflow_ellipsis_enabled');
		$('.aux_name_overflow').removeClass('overflow_ellipsis_disabled');
	}
}