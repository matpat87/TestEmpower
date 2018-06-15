"use strict";
if( !commonRouter ){
var commonRouter = (function($, window) {

	var views = {
		list : 'listContainer',
		edit : 'editContainer',
		detail : 'detailContainer',
	};
	
	var urlAction = '&action=index';
	
	var history = {};
	
	var init = function() {
		
		var urlParams = getUrlParams();
		
		var state = null;
		
		if (typeof urlParams.view == 'undefined' && !urlParams.hasOwnProperty('type')) {
			state = 'list';
		} else {
			state = urlParams.view;
		}
		
		if (state != null && state != "detail") {
			
			window.history.replaceState(state, document.title, window.location.href);
			window.currentLocationState = state;
			
		} else {
			
			 var readyInterval = setInterval(function(){
				 
				 if(/loaded|complete/.test(document.readyState)) {
			          clearInterval(readyInterval);	          
			          var newState = {
			  				"url" : window.location.href,
			  				"container" : '#content',
			  				"triger" : 'window.location.href='+window.location.href,
			  				"html" : $('#content').html(),
			  			};
			     
			  			setNewState(newState, true);
				 }
			}, 80);

		}
		
		window.onpopstate = onStateChange ;
	};
	
	var onStateChange = function(event){
		
		if (typeof event.state === 'object' && event.state != null) {
			
			if(history[event.state.url]){
						
				$(event.state.container).html(history[event.state.url].html);
				
				if(window.currentLocationState == 'list'){
					hideAll();
					$("#" + views[getUrlParams('view',event.state.url)]).show();
				}
				
			}else eval(event.state.triger);
			
		} else {
			moveTo(event.state, undefined, undefined, true);
		}
		window.currentLocationState = event.state;
	};
	
	var moveTo = function(dest, record, unique, back) {
		
		dest = typeof dest !== 'undefined' ? dest : 'list';
		dest = (typeof dest === 'object'? getUrlParams('view',dest.url) : dest);
		record = typeof record !== 'undefined' ? record : '';
		unique = typeof unique !== 'undefined' ? unique : '';
		
		if (views[dest] !== undefined) {
			
			var urlView = '&view=' + dest;
			var	urlRecord = (record !== '') ? '&record=' + record : '';
			var urlUnique = (unique !== '') ? '&unique=' + unique : '';
			
			var url = window.location.origin + window.location.pathname +'?module='+getUrlParams('module')+ urlAction + urlView + urlRecord + urlUnique;
			
			hideAll();
			$("#" + views[dest]).show();
			
			if (!back) {
				if (dest == 'edit' || dest == 'list') {
					var newState = dest;
					window.history.pushState(newState, dest, url);
					window.currentLocationState = window.history.state;
				} else {
					var newState = {
						"url" : url,
						"container" : "#" + views[dest],
						"html" : $("#" + views[dest]).html(),
					};
					setNewState(newState);
				}
			}
		}
		
	};

	var hideAll = function() {
		
		$.each(views, function(key, value) {
			$("#" + value).hide();
		});
		
	};
	
	var getUrlParams = function(param, url) {
		
		param = (typeof param == "string" ?  param : false);
		url = (typeof url == "string" ? url : window.location.search);
		
		var params = {}
		if (url != '') {
			url.split('?')[1].split('&').forEach(function(param){ param = param.split('='); params[param[0]] = param[1] });
		}
		
		if (!param) {
			return params;
		} else {
			return params[param];
		}
		
	}
	
	var getNewUrl = function(idView, record) {
		
		var newUrl;
		
		if (getUrlParams('module') == 'asol_Views') {
			
			newUrl = window.location.href.replace(/(record=).*?(&|$)/,'$1' + idView + '$2').replace(/(id=).*?(&|$)/,'$1' + record + '$2');
		
		} else {
			
			newUrl = window.location.href.replace(/(id=).*?(&|$)/,'$1' + idView + '$2');

			if (typeof record == 'string') {
				if (getUrlParams('record') == undefined) {
					newUrl = newUrl+'&record='+record; 
				} else {
					newUrl = newUrl.replace(/(record=).*?(&|$)/,'$1' + record + '$2');
				}
			} else { 
				newUrl = newUrl.replace(/(record=).*?(&|$)/,'').replace(/&$/,'');;
			}
			
		}
		
		return newUrl;
		
	}
	
	var setNewState = function(newState, update) {
		
		history[newState.url] = {
			html : newState.html,
			triger : newState.triger
		};
		
		delete newState.html;
		if (update) {
			window.history.replaceState(newState, document.title, newState.url);
		} else {
			window.history.pushState(newState, document.title, newState.url);
		}
		window.currentLocationState = window.history.state;
		
	}
	
	//********************//
	//***Initialization***//
	//********************//

	init();
		
	//********************//
	//***Initialization***//
	//********************//

	return {
		hideAll : hideAll,
		moveTo : moveTo,
		getNewUrl : getNewUrl,
		setNewState : setNewState,
		history : history, 
	};

})($, window);

var viewsRouter = commonRouter,
formsRouter  = commonRouter,
reportsRouter = commonRouter; 

}else console.error('New load of commonRouter');



