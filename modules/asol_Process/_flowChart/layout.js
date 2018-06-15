var url = "index.php?entryPoint=" + entryPoint;
var urlObjectEditor;
var layout;

var uiLayoutCenter;
var recycleBinEvents;
var recycleBinActivities;
var selectEndpointInsideWorkflow;
var selectEndpointInsideRecycleBinEvents;
var selectEndpointInsideRecycleBinActivities;
var eventSourceEndpoint;
var activityTargetEndpoint;
var activitySourceEndpoint;

var dragAndDropActionOldValue = "moveNode";

var forceOpenPanelSouth = false;

var blockedBy = {
	loadFlowChart : false,
	loadObjectEditor : false,
	saveObjectAndReload : false
};

$(document).ready(function() {
	
	loadLayout();
	loadRecycleBin();
	loadJsTree();
	loadFlowChart(true);
	urlObjectEditor = "index.php?module=asol_Process&action=wfeEditView&record=" + uid + "&sugar_body_only=true;";
	loadObjectEditor(urlObjectEditor);
	loadContextMenuForRecycleBin();
	loadContextMenuForWFMObjects();
	loadSeveralFeaturesLayout();
});

function loadSeveralFeaturesLayout() {
	console.log('[loadSeveralFeaturesLayout()]');
	
	$("#dragAndDropContainer").change(function() {
		destroyDragAndDrop();
		loadDragAndDrop();
	});
	
	$("#dragAndDropAction").change(function() {
		
		switch ($(this).val()) {
			case 'moveNode':
			case 'cloneOnlyNode':
			case 'cloneNodeAndDescendants':

				$("#dragAndDropContainer").prop("disabled", false);
				
				switch (dragAndDropActionOldValue) {
					case 'moveNode':
					case 'cloneOnlyNode':
					case 'cloneNodeAndDescendants':
						break;
					case 'orderTasks':
						$(".activity_container_of_tasks").sortable("destroy");
						loadDragAndDrop();
						break;
				}
				
				break;
			
			case 'orderTasks':

				$("#dragAndDropContainer").prop("disabled", true);
				
				switch (dragAndDropActionOldValue) {
					case 'moveNode':
					case 'cloneOnlyNode':
					case 'cloneNodeAndDescendants':
						destroyDragAndDrop();
						loadSortable();
						break;
					case 'orderTasks':
						break;
				}
				
				break;
		}
		
		dragAndDropActionOldValue = $(this).val();
	});
	
	var dragAndDropAction = $("#dragAndDropAction").val();
	
	$("#objectEditor").load(function() {
		if (forceOpenPanelSouth) {
			layout.open('south');
			forceOpenPanelSouth = false;
		}
		if (blockedBy.loadFlowChart == false) {
			unblockUI();
		}
		blockedBy.loadObjectEditor = false;
	});
	
	$("#fullscreen").click(function() {
		if (screenfull.enabled) {
			screenfull.toggle();
		}
	});
	
	$("#closeWFE").click(function() {
		var url = 'index.php?module=asol_Process&action=index';
		
		if ((typeof window.opener !== 'undefined') && (window.opener != null)) {
			window.opener.location = url;
			window.close();
			window.opener.focus();
		} else {
			window.location = url;
		}
	});
	
	$("#maximize").click(function() {
		layout.close("north");
		layout.close("south");
		layout.close("west");
		layout.close("east");
	});
	
	$("#minimize").click(function() {
		layout.open("north");
		layout.open("south");
		layout.open("west");
		layout.open("east");
	});
	
	$("#wfmModulesLogicHookEnabled").change(function() {
		wfmModulesLogicHookEnabled(this.checked);
		
		var wfmModulesLogicHookEnabledWarning = (this.checked) ? lang('LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_SLOW') : lang('LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_FAST');
		$("#wfmModulesLogicHookEnabledWarning").html(wfmModulesLogicHookEnabledWarning);
	});
}

function refreshWfe() {
	console.log('[refreshWfe()]');
	
	loadFlowChart(true);
	loadObjectEditor($("#objectEditor").attr("src"));
}

function wfmModulesLogicHookEnabled(checked) {
	console.log('[wfmModulesLogicHookEnabled(checked)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'wfmModulesLogicHookEnabled',
				checked : (checked) ? 'true' : 'false'
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[wfmModulesLogicHookEnabled] success -> response.ok==true');
					
				} else {
					alert('wfmModulesLogicHookEnabled: success -> response.ok==false');
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("wfmModulesLogicHookEnabled: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
				unblockUI();
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
}

function loadSortable() {
	console.log('[loadSortable()]');
	
	$(".activity_container_of_tasks").sortable({
		containment : "parent",
		cancel : ".task_name",
		tolerance : "pointer",
		start : function(event, ui) {
			ui.item.startPos = ui.item.index();
		},
		stop : function(event, ui) {
			console.log('[loadSortable] stop event=[', event, '] ui=[', ui, ']');
			console.log("[loadSortable] Start position: " + ui.item.startPos);
			console.log("[loadSortable] New position: " + ui.item.index());
			
			if (ui.item.startPos != ui.item.index()) {
				reorderTasks(ui.item);
			}
		}
	});
}

function loadLayout() {
	console.log('[loadLayout()]');
	
	var togglerOptions = {
		spacing_open : 10,
		spacing_closed : 10,
		togglerContent_open : '<div class="ui-icon"></div>',
		togglerContent_closed : '<div class="ui-icon"></div>'
	};
	
	layout = $('body').layout({
		center : {
			onresize : function() {
				scrollToTopArrowVisibility();
			}
		},
		north : $.extend({
			slideTrigger_open : "click",
			resizable : true
		}, togglerOptions),
		south : $.extend({
			size : "50%",
			slideTrigger_open : "click",
			resizable : true,
			useOffscreenClose : true, // true = initClosed & initHidden are 'offscreen' instead of 'hidden'
			fxName : "slideOffscreen", // plug-in - like slide, but does not 'hide' panes
			fxSpeed : 300,
			contentIgnoreSelector : ".ui-layout-mask",
			maskObjects : true,
			initClosed : false
		}, togglerOptions),
		west : $.extend({
			size : "15%",
			slideTrigger_open : "click"
		}, togglerOptions),
		east : $.extend({
			size : "30%",
			onresize : $.layout.callbacks.resizePaneAccordions, // RESIZE Accordion widget when panes resize
			slideTrigger_open : "click"
		}, togglerOptions)
	});
	
}

// jsPlumb needs its container to have a css={display: block} in order to properly draw connections.
var refreshJsPlumbForRecycleBinEvents = true;
var refreshJsPlumbForRecycleBinActivities = true;

function loadRecycleBin() {
	console.log('[loadRecycleBin()]');
	
	// ACCORDION - in the East pane
	$("#accordion").accordion({
		active : 0, // recycleBinEvents
		heightStyle : "fill",
		event : "click", // "click hoverintent"
		activate : function(event, ui) {
			switch (ui.newPanel[0].id) {
				case 'recycleBinEvents':
					if (refreshJsPlumbForRecycleBinEvents) {
						generateConnectionsRecycleBinEvents();
						generateEndpointsRecycleBinEvents();
						loadContextMenuForRelationshipRecycleBinEvents();
						refreshJsPlumbForRecycleBinEvents = false;
					}
					break;
				case 'recycleBinActivities':
					if (refreshJsPlumbForRecycleBinActivities) {
						generateConnectionsRecycleBinActivities();
						generateEndpointsRecycleBinActivities();
						loadContextMenuForRelationshipRecycleBinActivities();
						refreshJsPlumbForRecycleBinActivities = false;
					}
					break;
				case 'recycleBinTasks':
					break;
			}
		},
		beforeActivate : function(event, ui) {
			switch (ui.newPanel[0].id) {
				case 'recycleBinEvents':
					if (refreshJsPlumbForRecycleBinEvents) {
						recycleBinEvents.reset();
						selectEndpointInsideRecycleBinEvents.reset();
					}
					break;
				case 'recycleBinActivities':
					if (refreshJsPlumbForRecycleBinActivities) {
						recycleBinActivities.reset();
						selectEndpointInsideRecycleBinActivities.reset();
					}
					break;
				case 'recycleBinTasks':
					break;
			}
		}
	});
}

function loadJsTree() {
	console.log('[loadJsTree()]');
	
	// CLEARABLE INPUT
	function tog(v) {
		return v ? 'addClass' : 'removeClass';
	}
	$(document).on('input', '.clearable', function() {
		$(this)[tog(this.value)]('x');
	}).on('mousemove', '.x', function(e) {
		$(this)[tog(this.offsetWidth - 18 < e.clientX - this.getBoundingClientRect().left)]('onX');
	}).on('click', '.onX', function() {
		$(this).removeClass('x onX').val('').change();
		$("#newObjects").jstree("search", $('#jstree_search').val());
	});
	
	var to = false;
	$('#jstree_search').keyup(function() {
		if (to) {
			clearTimeout(to);
		}
		to = setTimeout(function() {
			$("#newObjects").jstree("search", $('#jstree_search').val());
		}, 250);
	});
	
	$('#newObjects').jstree({
		"plugins" : [ "search", "themes", "html_data", /*"dnd",*/"types", "crrm" ],
		"search" : {
			"case_insensitive" : true,
			"show_only_matches" : true
		},
		"themes" : {
			"theme" : "default",
			"dots" : true,
			"icons" : true
		},
		"dnd" : {
			"drop_check" : function(data) {
				return drop_check(data);
			},
			"drop_finish" : function(data) {
				drop_finish(data);
			}
		},
		"crrm" : {
			"move" : {
				"check_move" : function(m) {
					return false;
				}
			}
		},
		"types" : {
			"types" : {
				"asol_Event" : {
					"start_drag" : false,
					"icon" : {
						"image" : "custom/themes/default/images/icon_asol_Events_32.gif",
						"size" : "100% auto"
					}
				},
				"asol_Activity" : {
					"start_drag" : false,
					"icon" : {
						"image" : "custom/themes/default/images/icon_asol_Activity_32.gif",
						"size" : "100% auto"
					}
				},
				"asol_Task" : {
					"start_drag" : false,
					"icon" : {
						"image" : "custom/themes/default/images/icon_asol_Task_32.gif",
						"size" : "100% auto"
					}
				},
				
				"asol_Events_" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/event.png",
						"size" : "100% auto"
					}
				},
				
				"asol_Activity_1" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/activity.png",
						"size" : "100% auto"
					}
				},
				
				"asol_Task_send_email" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_send_email_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_php_custom" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_php_custom_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_continue" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_continue_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_end" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_end_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_create_object" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_create_object_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_modify_object" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_modify_object_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_call_process" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_call_process_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_add_custom_variables" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_add_custom_variables_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_get_objects" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_get_objects_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_forms_response" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_forms_response_32.png",
						"size" : "100% auto"
					}
				},
				"asol_Task_forms_error_message" : {
					"icon" : {
						"image" : "modules/asol_Process/_flowChart/images/task_forms_error_message_32.png",
						"size" : "100% auto"
					}
				}
			}
		}
	});
}

function loadObjectEditor(urlForIframeSrc) {
	console.log('[loadObjectEditor(urlForIframeSrc)]');
	console.dir(arguments);
	
	blockedBy.loadObjectEditor = true;
	if (blockedBy.saveObjectAndReload == false) {
		blockUI_type('load');
	}
	
	$("#objectEditor").attr({
		src : urlForIframeSrc
	});
	
}

function loadFlowChart(block) {
	console.log('[loadFlowChart(block)]');
	console.dir(arguments);
	
	try {
		
		var url = "index.php?entryPoint=wfm_flowChart&uid=" + uid;
		var activePanel = $("#accordion").accordion("option", "active");
		
		$.ajax({
			dataType : "json",
			type : "POST",
			url : url,
			cache : false,
			async : true,
			beforeSend : function() {
				if (block) {
					blockedBy.loadFlowChart = true;
					blockUI_type('load');
				}
			},
			success : function(html) {
				
				if (!block) {
					switch ($("#dragAndDropAction").val()) {
						case 'moveNode':
						case 'cloneOnlyNode':
						case 'cloneNodeAndDescendants':
							destroyDragAndDrop();
							break;
						case 'orderTasks':
							$(".activity_container_of_tasks").sortable("destroy");
							break;
					}
				}
				
				$('#workflowHeaderDynamicContent').html(html.workflowHeader);
				$('#workflowContent').html(html.responseUiLayoutCenter);
				$('#recycleBinEvents').html(html.responseRecycleBinEvents);
				$('#recycleBinActivities').html(html.responseRecycleBinActivities);
				$('#recycleBinTasks').html(html.responseRecycleBinTasks);
				
				recycleBinVisibility(html);
				
				loadFlowChartJsFile();
				
				refreshJsPlumbForRecycleBinEvents = true;
				refreshJsPlumbForRecycleBinActivities = true;
				
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("loadFlowChart: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
				if (blockedBy.loadObjectEditor == false) {
					unblockUI();
				}
				blockedBy.loadFlowChart = false;
			}
		});
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
}

function saveObjectAndReload(editViewForm) {
	console.log('[saveObjectAndReload(editViewForm)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'saveObjectAndReload',
				editViewForm : editViewForm,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockedBy.saveObjectAndReload = true;
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[saveObjectAndReload] success -> response.ok==true');
					
					wfe_operation_counter++;
					
					// document.getElementById('objectEditor').contentDocument.location.reload(true);
					
					$('#workflowHeaderDynamicContent').html(response.html.workflowHeader);
					$('#workflowContent').html(response.html.responseUiLayoutCenter);
					$('#recycleBinEvents').html(response.html.responseRecycleBinEvents);
					$('#recycleBinActivities').html(response.html.responseRecycleBinActivities);
					$('#recycleBinTasks').html(response.html.responseRecycleBinTasks);
					
					recycleBinVisibility(response.html);
					
					loadFlowChartJsFile();
					
					refreshJsPlumbForRecycleBinEvents = true;
					refreshJsPlumbForRecycleBinActivities = true;
					
				} else {
					alert('saveObjectAndReload: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
				
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("saveObjectAndReload: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
				loadObjectEditor($("#objectEditor").attr("src"));
				// unblockUI();
				blockedBy.saveObjectAndReload = false;
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
}

function loadContextMenuForRecycleBin() {
	console.log('[loadContextMenuForRecycleBin()]');
	
	$("#recycleBinIcon").contextmenu({
		menu : [ {
			cmd : "all",
			title : lang('LBL_WFE_EMPTY_ALL'),
			uiIcon : "recycleBinAll",
			action : function(event, ui) {
				emptyRecycleBin('all');
			}
		}, {
			cmd : "events",
			title : lang('LBL_WFE_EMPTY_EVENTS'),
			uiIcon : "recycleBinEvents",
			action : function(event, ui) {
				emptyRecycleBin('asol_Events');
			}
		}, {
			cmd : "activities",
			title : lang('LBL_WFE_EMPTY_ACTIVITIES'),
			uiIcon : "recycleBinActivities",
			action : function(event, ui) {
				emptyRecycleBin('asol_Activity');
			}
		}, {
			cmd : "tasks",
			title : lang('LBL_WFE_EMPTY_TASKS'),
			uiIcon : "recycleBinTasks",
			action : function(event, ui) {
				emptyRecycleBin('asol_Task');
			}
		} ]
	});
}

function loadContextMenuForWFMObjects() {
	console.log('[loadContextMenuForWFMObjects()]');
	
	$("#workflow, #recycleBin").contextmenu({
		delegate : "[module='asol_Events'], [module='asol_Activity'], [module='asol_Task']",
		menu : [ {
			cmd : "remove",
			title : lang('LBL_WFE_REMOVE'),
			uiIcon : "removeNode",
			action : function(event, ui) {
				console.log('[loadContextMenuForWFMObjects] remove action event=[', event, '] ui=[', ui, ']');
				
				var validTargetNodeForContextMenu = new ValidTargetNodeForContextMenu(ui.target);
				console.log('[loadContextMenuForWFMObjects] remove action validTargetNodeForContextMenu=[', validTargetNodeForContextMenu, ']');
				
				removeNode(validTargetNodeForContextMenu.getModule(), validTargetNodeForContextMenu.getId());
			}
		}, {
			cmd : "delete",
			title : lang('LBL_WFE_DELETE'),
			uiIcon : "deleteNode",
			action : function(event, ui) {
				console.log('[loadContextMenuForWFMObjects] delete action event=[', event, '] ui=[', ui, ']');
				
				var validTargetNodeForContextMenu = new ValidTargetNodeForContextMenu(ui.target);
				console.log('[loadContextMenuForWFMObjects] delete action validTargetNodeForContextMenu=[', validTargetNodeForContextMenu, ']');
				
				if (confirm(lang('LBL_WFE_ARE_YOU_SURE'))) {
					deleteNode(validTargetNodeForContextMenu.getModule(), validTargetNodeForContextMenu.getId());
				}
			}
		}, {
			cmd : "clone",
			title : lang('LBL_WFE_CLONE'),
			uiIcon : "cloneNode",
			children : [ {
				cmd : "cloneOnlyNode",
				title : lang('LBL_WFE_ONLY_NODE'),
				uiIcon : "cloneOnlyNode",
				action : function(event, ui) {
					console.log('[loadContextMenuForWFMObjects] cloneOnlyNode action event=[', event, '] ui=[', ui, ']');
					
					var validTargetNodeForContextMenu = new ValidTargetNodeForContextMenu(ui.target);
					console.log('[loadContextMenuForWFMObjects] cloneOnlyNode action validTargetNodeForContextMenu=[', validTargetNodeForContextMenu, ']');
					
					cloneNode('cloneOnlyNode', null, validTargetNodeForContextMenu.getModule(), validTargetNodeForContextMenu.getId(), null, 'recycleBin');
				}
			}, {
				cmd : "cloneNodeAndDescendants",
				title : lang('LBL_WFE_NODE_AND_DESCENDANTS'),
				uiIcon : "cloneNodeAndDescendents",
				action : function(event, ui) {
					console.log('[loadContextMenuForWFMObjects] cloneNodeAndDescendants action event=[', event, '] ui=[', ui, ']');
					
					var validTargetNodeForContextMenu = new ValidTargetNodeForContextMenu(ui.target);
					console.log('[loadContextMenuForWFMObjects] cloneNodeAndDescendants action validTargetNodeForContextMenu=[', validTargetNodeForContextMenu, ']');
					
					cloneNode('cloneNodeAndDescendants', null, validTargetNodeForContextMenu.getModule(), validTargetNodeForContextMenu.getId(), null, 'recycleBin');
				}
			} ]
		}, ]
	});
}

function recycleBinVisibility(html) {
	console.log('[recycleBinVisibility(html)]');
	console.dir(arguments);
	
	if (html.hasRecycleBinEvents || html.hasRecycleBinActivities || html.hasRecycleBinTasks) {
		$("#recycleBinIcon").attr({
			src : "modules/asol_Process/_flowChart/images/recycleBinFull_24px.png"
		});
		
		$("#recycleBinIcon").contextmenu("enableEntry", "all", true);
	} else {
		
		$("#recycleBinIcon").attr({
			src : "modules/asol_Process/_flowChart/images/recycleBinEmpty_24px.png"
		});
		
		$("#recycleBinIcon").contextmenu("enableEntry", "all", false);
		
	}
	
	$("#recycleBinIcon").contextmenu("enableEntry", "events", html.hasRecycleBinEvents);
	$("#recycleBinIcon").contextmenu("enableEntry", "activities", html.hasRecycleBinActivities);
	$("#recycleBinIcon").contextmenu("enableEntry", "tasks", html.hasRecycleBinTasks);
	
}

function drop_finish(data) {
	console.log('[drop_finish(data)]');
	console.dir(arguments);
	
	var draggedNodeAux = $(data.o);
	var draggedNode;
	var targetNode = $(data.r);
	
	var draggedNodeModule = draggedNodeAux.parent().parent().attr("module");
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
	
	createObjectAndRelationship(draggedNode, validTargetNode);
}

function drop_check(data) {
	console.log('[drop_check(data)]');
	console.dir(arguments);
	
	var draggedNode = $(data.o);
	var targetNode = $(data.r);
	console.log('[drop_check] targetNode=[', targetNode, ']');
	
	var draggedNodeType = draggedNode.parent().parent().attr("module");
	console.log('[drop_check] draggedNodeType=[', draggedNodeType, ']');
	
	var validTargetNode = new ValidTargetNode(targetNode);
	
	switch (draggedNodeType) {
		
		case 'asol_Events':

			switch (validTargetNode.getModule()) {
				case 'asol_Process':
					validTargetNode.setIsValidTargetNode(true);
					break;
				default:
					validTargetNode.setIsValidTargetNode(false);
					break;
			}
			
			break;
		
		case 'asol_Activity':

			switch (validTargetNode.getModule()) {
				case 'asol_Activity':
				case 'asol_Events':
					validTargetNode.setIsValidTargetNode(true);
					break;
				default:
					validTargetNode.setIsValidTargetNode(false);
					break;
			}
			
			break;
		
		case 'asol_Task':

			switch (validTargetNode.getModule()) {
				case 'asol_Activity':
					validTargetNode.setIsValidTargetNode(true);
					break;
				default:
					validTargetNode.setIsValidTargetNode(false);
					break;
			}
			
			break;
		
		default:
			validTargetNode.setIsValidTargetNode(false);
			break;
	}
	
	console.log('[drop_check] validTargetNode=[', validTargetNode, ']');
	
	return validTargetNode.getIsValidTargetNode();
}

function createObjectAndRelationship(draggedNode, validTargetNode) {
	console.log('[createObjectAndRelationship(draggedNode, validTargetNode)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'createObjectAndRelationship',
				jsonDraggedNode : JSON.stringify(draggedNode),
				jsonValidTargetNode : JSON.stringify(validTargetNode),
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[createObjectAndRelationship] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
					if (validTargetNode.targetIsLayout == 'recycleBin') {
						recycleBinOpenTab(draggedNode.module);
					}
				} else {
					alert('createObjectAndRelationship: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("createObjectAndRelationship: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function createRelationship(sourceModule, sourceId, targetModule, targetId, targetRelationship) {
	console.log('[createRelationship(sourceModule, sourceId, targetModule, targetId, targetRelationship)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'createRelationship',
				sourceModule : sourceModule,
				sourceId : sourceId,
				targetModule : targetModule,
				targetId : targetId,
				targetRelationship : targetRelationship,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[createRelationship] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
				} else {
					alert('createRelationship: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("createRelationship: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function removeNode(module, id) {
	console.log('[removeNode(module, id)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'removeNode',
				module : module,
				id : id,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[removeNode] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
					recycleBinOpenTab(module);
				} else {
					alert('removeNode: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("removeNode: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function recycleBinOpenTab(module) {
	
	switch (module) {
		case 'asol_Events':
			$("#accordion").accordion("option", "active", 0);
			recycleBinEvents.repaintEverything();
			break;
		case 'asol_Activity':
			$("#accordion").accordion("option", "active", 1);
			recycleBinActivities.repaintEverything();
			break;
		case 'asol_Task':
			$("#accordion").accordion("option", "active", 2);
			break;
	}
}

function deleteNode(module, id) {
	console.log('[deleteNode(module, id)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'deleteNode',
				module : module,
				id : id,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[deleteNode] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
				} else {
					alert('deleteNode: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("deleteNode: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function moveNode(sourceRelationship, sourceModule, sourceId, targetModule, targetId) {
	console.log('[moveNode(sourceRelationship, sourceModule, sourceId, targetModule, targetId)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'moveNode',
				sourceModule : sourceModule,
				sourceId : sourceId,
				targetModule : targetModule,
				targetId : targetId,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[moveNode] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
				} else {
					alert('moveNode: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("moveNode: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function deleteRelationship(sourceModule, sourceId, targetModule, targetId) {
	console.log('[deleteRelationship(sourceModule, sourceId, targetModule, targetId)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'deleteRelationship',
				sourceModule : sourceModule,
				sourceId : sourceId,
				targetModule : targetModule,
				targetId : targetId,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[deleteRelationship] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
					if (response.recycleBinOpenTab) {
						recycleBinOpenTab(targetModule);
					}
				} else {
					alert('deleteRelationship: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("deleteRelationship: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function cloneNode(type, sourceRelationship, sourceModule, sourceId, targetModule, targetId) {
	console.log('[cloneNode(type, sourceRelationship, sourceModule, sourceId, targetModule, targetId)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'cloneNode',
				type : type,
				sourceModule : sourceModule,
				sourceId : sourceId,
				targetModule : targetModule,
				targetId : targetId,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[cloneNode] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
					if (targetId == 'recycleBin') {
						recycleBinOpenTab(sourceModule);
					}
				} else {
					alert('cloneNode: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("cloneNode: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function reorderTasks(sortedTask) {
	console.log('[reorderTasks(sortedTask)]');
	console.dir(arguments);
	
	var reorderTasksInfo = [];
	
	sortedTask.closest("[module='asol_Activity']").find(".activity_container_of_tasks").children().each(function() {
		reorderTasksInfo.push({
			'id' : $(this).attr("id"),
			'task_order' : $(this).index()
		});
	});
	
	console.log('[reorderTasks] reorderTasksInfo=[', reorderTasksInfo, ']');
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'reorderTasks',
				jsonReorderTasksInfo : JSON.stringify(reorderTasksInfo),
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[reorderTasks] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
				} else {
					alert('reorderTasks: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("reorderTasks: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

function emptyRecycleBin(module) {
	console.log('[emptyRecycleBin(module)]');
	console.dir(arguments);
	
	try {
		
		$.ajax({
			url : url,
			async : true,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : 'emptyRecycleBin',
				module : module,
				processId : $("[module='asol_Process']").attr("id"),
				wfe_operation_counter : wfe_operation_counter
			},
			beforeSend : function() {
				blockUI_type('save');
			},
			success : function(response) {
				
				if (response.ok) {
					console.log('[emptyRecycleBin] success -> response.ok==true');
					wfe_operation_counter++;
					loadFlowChart(false);
					
					recycleBinOpenTab(module);
				} else {
					alert('emptyRecycleBin: success -> response.ok==false');
					
					if ((typeof response.errorType !== 'undefined') && (response.errorType == 'wfe_operation_counter_error')) {
						alert(lang('LBL_WFE_WFE_OPERATION_COUNTER_ERROR'));
					} else {
						alert(lang('LBL_WFE_GENERIC_ERROR'));
					}
					
					document.location.reload();
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server
			
				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				alert("emptyRecycleBin: error -> " + errorMessage);
				alert(lang('LBL_WFE_FATAL_ERROR'));
				document.location.reload();
			},
			complete : function(response) {
			}
		});
		
	} catch (exception) {
		alert(exception);
		alert(lang('LBL_WFE_FATAL_ERROR'));
		document.location.reload();
	} finally {
	}
	
}

var loadGrowl = (function() {
	var executed = false;
	return function() {
		if (!executed) {
			executed = true;
			
			$('#flowchart_info').click(function() {
				// Check if it should be persistent (can set to a normal bool if you like!)
				createGrowl($(this).hasClass('persistent'));
			});
			
			window.createGrowl = function(persistent) {
				// Use the last visible jGrowl qtip as our positioning target
				var target = $('.qtip.jgrowl:visible:last');
				
				// Create your jGrowl qTip...
				$(document.body).qtip({
					// Any content config you want here really.... go wild!
					content : {
						text : SUGAR.language.get('asol_Process', 'LBL_ASOL_INFO_TEXT'),
						title : {
							text : SUGAR.language.get('asol_Process', 'LBL_ASOL_INFO_TITLE'),
							button : true
						}
					},
					position : {
						my : 'top right',
						// Not really important...
						at : (target.length ? 'bottom' : 'top') + ' right',
						// If target is window use 'top right' instead of 'bottom right'
						target : target.length ? target : $("body"),
						// Use our target declared above
						adjust : {
							x : -5,
							y : 47
						}, // y = bar height + bar border
						effect : function(api, newPos) {
							// Animate as usual if the window element is the target
							$(this).animate(newPos, {
								duration : 200,
								queue : false
							});
							
							// Store the final animate position
							api.cache.finalPos = newPos;
						}
					},
					show : {
						event : false,
						// Don't show it on a regular event
						ready : true,
						// Show it when ready (rendered)
						effect : function() {
							$(this).stop(0, 1).fadeIn(400);
						},
						// Matches the hide effect
						delay : 0,
						// Needed to prevent positioning issues
						// Custom option for use with the .get()/.set() API, awesome!
						persistent : persistent
					},
					hide : {
						event : false,
						// Don't hide it on a regular event
						effect : function(api) {
							// Do a regular fadeOut, but add some spice!
							$(this).stop(0, 1).fadeOut(400).queue(function() {
								// Destroy this tooltip after fading out
								api.destroy();
								
								// Update positions
								updateGrowls();
							});
						}
					},
					style : {
						classes : 'jgrowl qtip-dark qtip-rounded',
						// Some nice visual classes
						tip : false
					// No tips for this one (optional ofcourse)
					},
					events : {
						render : function(event, api) {
							// Trigger the timer (below) on render
							timer.call(api.elements.tooltip, event);
						}
					}
				}).removeData('qtip');
			};
			
			// Make it a window property see we can call it outside via updateGrowls() at any point
			window.updateGrowls = function() {
				// Loop over each jGrowl qTip
				var each = $('.qtip.jgrowl'), width = each.outerWidth(), height = each.outerHeight(), gap = each.eq(0).qtip('option', 'position.adjust.y'), pos;
				
				each.each(function(i) {
					var api = $(this).data('qtip');
					
					// Set target to window for first or calculate manually for subsequent growls
					api.options.position.target = !i ? $(window) : [ pos.left + width, pos.top + (height * i) + Math.abs(gap * (i - 1)) ];
					api.set('position.at', 'top right');
					
					// If this is the first element, store its finak animation position
					// so we can calculate the position of subsequent growls above
					if (!i) {
						pos = api.cache.finalPos;
					}
				});
			};
			
			// Setup our timer function
			function timer(event) {
				var api = $(this).data('qtip'), lifespan = 5000; // 5 second lifespan
				
				// If persistent is set to true, don't do anything.
				if (api.get('show.persistent') === true) {
					return;
				}
				
				// Otherwise, start/clear the timer depending on event type
				clearTimeout(api.timer);
				if (event.type !== 'mouseover') {
					api.timer = setTimeout(api.hide, lifespan);
				}
			}
			
			// Utilise delegate so we don't have to rebind for every qTip!
			$(document).delegate('.qtip.jgrowl', 'mouseover mouseout', timer);
			
		}
	};
})();

// BEGIN - blockUI

var message_process = "Processing...";
var message_load = "Loading...";
var message_clear = "Clearing...";
var message_save = "Saving...";
var message_import = "Importing...";
var message_publish = "Publishing...";
var message_createBaseline = "Creating Baseline...";
var image_loading = "modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.blockUI/blockUI_loading.gif";
var message_blocked = "Action not allowed.";
var image_blocked = "blockUI_blocked.gif";
var message_undo = "Undoing...";
var message_redo = "Redoing...";

function blockUI(image, message, blockUI_cursor_type) {
	
	var aux_message = "" + "<table id='blockUI_table'>" + "<tr>" + "<td>" + "<img id='blockUI_image' src='" + image + "'/>" + "</td>" + "</tr>" + "<tr>" + "<td>" + "<h2 id='blockUI_message'>" + message + "</h2>" + "</td>" + "</tr>" + "</table>";
	
	var v = $.blockUI({
		message : aux_message,
		css : {
			width : 'auto',
			height : 'auto',
			left : '45%',
			top : '35%',
			border : 'none',
			padding : '15px',
			backgroundColor : '#000',
			'-webkit-border-radius' : '10px',
			'-moz-border-radius' : '10px',
			opacity : .5,
			color : '#F15B29',
			cursor : blockUI_cursor_type,
			minWidth : '-moz-fit-content'
		},
		overlayCSS : {
			opacity : .3,
			cursor : blockUI_cursor_type
		},
		baseZ : 10000000
	});
}

function unblockUI() {
	console.log('[unblockUI()]');
	
	$.unblockUI();
}

function blockUI_type(type) {
	console.log('[blockUI_type(type)]');
	console.dir(arguments);
	
	switch (type) {
		case 'process':
			blockUI(image_loading, message_process, 'wait');
			break;
		case 'load':
			blockUI(image_loading, message_load, 'wait');
			break;
		case 'publish':
			blockUI(image_loading, message_publish, 'wait');
			break;
		case 'createBaseline':
			blockUI(image_loading, message_createBaseline, 'wait');
			break;
		case 'clear':
			blockUI(image_loading, message_clear, 'wait');
			break;
		case 'save':
			blockUI(image_loading, message_save, 'wait');
			break;
		case 'import':
			blockUI(image_loading, message_import, 'wait');
			break;
		case 'blocked':
			blockUI(image_blocked, message_blocked, 'not-allowed');
			break;
		case 'undo':
			blockUI(image_loading, message_undo, 'wait');
			break;
		case 'redo':
			blockUI(image_loading, message_redo, 'wait');
			break;
	}
	
}
// END - blockUI

/** ************************************************ */
/** ********* BEGIN - DEFINE CLASSES *************** */
/** ************************************************ */

/**
 * Class asol_Event
 * 
 * @param trigger_type
 * @param trigger_event
 * @param scheduled_type
 * @param subprocess_type
 * @returns {asol_Event}
 */
function asol_Event(trigger_type, trigger_event, scheduled_type, subprocess_type) {
	this.trigger_type = trigger_type;
	this.trigger_event = trigger_event;
	this.scheduled_type = scheduled_type;
	this.subprocess_type = subprocess_type;
}

asol_Event.prototype.setTriggerType = function(trigger_type) {
	this.trigger_type = trigger_type;
};
asol_Event.prototype.setTriggerEvent = function(trigger_event) {
	this.trigger_event = trigger_event;
};
asol_Event.prototype.setScheduledType = function(scheduled_type) {
	this.scheduled_type = scheduled_type;
};
asol_Event.prototype.setSubprocessType = function(subprocess_type) {
	this.subprocess_type = subprocess_type;
};

asol_Event.prototype.getTriggerType = function() {
	return this.trigger_type;
};
asol_Event.prototype.getTriggerEvent = function() {
	return this.trigger_event;
};
asol_Event.prototype.getScheduledType = function() {
	return this.scheduled_type;
};
asol_Event.prototype.getSubprocessType = function() {
	return this.subprocess_type;
};

/**
 * Class asol_Activity
 * 
 * @returns {asol_Activity}
 */
function asol_Activity() {
	
}

/**
 * Class asol_Task
 * 
 * @param type
 * @returns {asol_Task}
 */
function asol_Task(task_type) {
	this.task_type = task_type;
}

/**
 * Class ValidTargetNode
 * 
 * @param targetNode
 * @returns {ValidTargetNode}
 */
function ValidTargetNode(targetNode) {
	this.id;
	this.module;
	this.isValidTargetNode;
	this.targetIsLayout;
	
	this.init(targetNode);
}

ValidTargetNode.prototype.setId = function(id) {
	this.id = id;
};
ValidTargetNode.prototype.setModule = function(module) {
	this.module = module;
};
ValidTargetNode.prototype.setIsValidTargetNode = function(isValidTargetNode) {
	this.isValidTargetNode = isValidTargetNode;
};
ValidTargetNode.prototype.setTargetIsLayout = function(targetIsLayout) {
	this.targetIsLayout = targetIsLayout;
};

ValidTargetNode.prototype.getId = function() {
	return this.id;
};
ValidTargetNode.prototype.getModule = function() {
	return this.module;
};
ValidTargetNode.prototype.getIsValidTargetNode = function() {
	return this.isValidTargetNode;
};
ValidTargetNode.prototype.getTargetIsLayout = function() {
	return this.targetIsLayout;
};

ValidTargetNode.prototype.init = function(targetNode) {
	
	if (targetNode.closest('.asol_Activity').length) {
		this.setModule('asol_Activity');
		this.setTargetIsLayout(null);
	} else if (targetNode.closest('.asol_Event').length) {
		this.setModule('asol_Events');
		this.setTargetIsLayout(null);
	} else if ((targetNode.attr('id') == 'workflow') || (targetNode.attr('id') == 'recycleBin')) {
		this.setModule('asol_Process');
		this.setTargetIsLayout(targetNode.attr('id'));
	} else {
		this.setTargetIsLayout(null);
		this.setModule(null);
	}
	
	switch (this.getModule()) {
		case 'asol_Process':
			this.setId($("#workflow [module='asol_Process']").attr('id'));
			break;
		case 'asol_Events':
			this.setId(targetNode.closest('.asol_Event').attr('id'));
			break;
		case 'asol_Activity':
			this.setId(targetNode.closest('.asol_Activity').attr('id'));
			break;
		default:
			this.setId(null);
	}
	
};

/**
 * Class DraggedNode
 * 
 * @param module
 * @param bean
 * @returns {DraggedNode}
 */
function DraggedNode(module, bean) {
	this.module = module;
	this.bean = bean;
}

/**
 * Class ValidTargetNode
 * 
 * @param targetNode
 * @returns {ValidTargetNode}
 */
function ValidTargetNodeForContextMenu(targetNode) {
	this.id;
	this.module;
	this.isValidTargetNodeForContextMenu;
	
	this.init(targetNode);
}

ValidTargetNodeForContextMenu.prototype.setId = function(id) {
	this.id = id;
};
ValidTargetNodeForContextMenu.prototype.setModule = function(module) {
	this.module = module;
};
ValidTargetNodeForContextMenu.prototype.setIsValidTargetNodeForContextMenu = function(isValidTargetNodeForContextMenu) {
	this.isValidTargetNodeForContextMenu = isValidTargetNodeForContextMenu;
};

ValidTargetNodeForContextMenu.prototype.getId = function() {
	return this.id;
};
ValidTargetNodeForContextMenu.prototype.getModule = function() {
	return this.module;
};
ValidTargetNodeForContextMenu.prototype.getIsValidTargetNodeForContextMenu = function() {
	return this.isValidTargetNodeForContextMenu;
};

ValidTargetNodeForContextMenu.prototype.init = function(targetNode) {
	
	if (targetNode.closest('.asol_Task').length) {
		this.setModule('asol_Task');
	} else if (targetNode.closest('.asol_Activity').length) {
		this.setModule('asol_Activity');
	} else if (targetNode.closest('.asol_Event').length) {
		this.setModule('asol_Events');
	} else {
		this.setType(null);
	}
	
	switch (this.getModule()) {
		case 'asol_Events':
			this.setId(targetNode.closest('.asol_Event').attr('id'));
			break;
		case 'asol_Activity':
			this.setId(targetNode.closest('.asol_Activity').attr('id'));
			break;
		case 'asol_Task':
			this.setId(targetNode.closest('.asol_Task').attr('id'));
			break;
		default:
			this.setId(null);
	}
	
};

// BEGIN - Class ConnectionError
function ConnectionError(message) {
	this.name = "ConnectionError";
	this.message = (message || "You are offline.");
}

ConnectionError.prototype = new Error();
ConnectionError.prototype.constructor = ConnectionError;
// END - Class ConnectionError

/** ************************************************** */
/** ************* END - DEFINE CLASSES *************** */
/** ************************************************** */

function lang(lbl) {
	
	return SUGAR.language.get('asol_Process', lbl);
}

/** *************************************************** */
/** ************* BEGIN - AUX FUNCTIONS *************** */
/** *************************************************** */

$.event.special.hoverintent = {
	setup : function() {
		$(this).bind("mouseover", jQuery.event.special.hoverintent.handler);
	},
	teardown : function() {
		$(this).unbind("mouseover", jQuery.event.special.hoverintent.handler);
	},
	handler : function(event) {
		var currentX, currentY, timeout, args = arguments, target = $(event.target), previousX = event.pageX, previousY = event.pageY;
		function track(event) {
			currentX = event.pageX;
			currentY = event.pageY;
		}
		;
		function clear() {
			target.unbind("mousemove", track).unbind("mouseout", clear);
			clearTimeout(timeout);
		}
		function handler() {
			var prop, orig = event;
			if ((Math.abs(previousX - currentX) + Math.abs(previousY - currentY)) < 7) {
				clear();
				event = $.Event("hoverintent");
				for (prop in orig) {
					if (!(prop in event)) {
						event[prop] = orig[prop];
					}
				}
				// Prevent accessing the original event since the new event
				// is fired asynchronously and the old event is no longer
				// usable (#6028)
				delete event.originalEvent;
				target.trigger(event);
			} else {
				previousX = currentX;
				previousY = currentY;
				timeout = setTimeout(handler, 100);
			}
		}
		timeout = setTimeout(handler, 100);
		target.bind({
			mousemove : track,
			mouseout : clear
		});
	}
};

/** ************************************************* */
/** ************* END - AUX FUNCTIONS *************** */
/** ************************************************* */
