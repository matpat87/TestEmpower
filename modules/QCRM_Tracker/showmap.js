	var tmp=[],
		markers = []; // Create a marker array to hold your markers
    var JJWG ={};

	JJWG.GoogleLoaded=function(){
        var i, MarkersDir = 'themes/default/images/jjwg_Maps/0-25/';
		document.getElementById("SearchMap").disabled = false;
        if (custom_dir)
            MarkersDir = 'custom/' + MarkersDir;

    	JJWG.markers = {};
        for (i=0;i<25;i++){
            JJWG.markers[i] = new google.maps.MarkerImage(MarkersDir+'marker_'+(i+1).toString()+'.png',
                                new google.maps.Size(20,34), new google.maps.Point(0,0), new google.maps.Point(10,34));
        }
	}
	
    JJWG.init = function(google_key){
	    var google_url= 'https://maps.googleapis.com/maps/api/js',
    		script = document.createElement('script');

    	google_url+='?key='+google_key+'&callback=JJWG.GoogleLoaded';
    	script.src = google_url;
    	script.type = 'text/javascript';
    	document.getElementsByTagName('head')[0].appendChild(script);
    		
    }


    JJWG.ShowBeansInMap = function(beanslist,mapdiv,withRoute){
        //$('#map_canvas').html();
        var i,marker,markerdef,markerIcon,
            len=beanslist.length,

        // first meeting
            origin,
        // last meeting
            destination,
        // center of map is the location of the "middle" meeting
            centerbean=beanslist[len==1?0:len%2];
        var centerpoint= new google.maps.LatLng(centerbean.jjwg_maps_lat_c, centerbean.jjwg_maps_lng_c),

            // intermediate points when drawing route
            waypoints =[];

			$('#'+mapdiv).empty();
            map = new google.maps.Map(document.getElementById(mapdiv), {
                    zoom: 10
                    ,center: centerpoint
                    ,zoomControl: true
                    ,mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infoWindow = new google.maps.InfoWindow;
        // Loop through markers and set map to null for each
        for (var i=0; i<markers.length; i++) {
            markers[i].setMap(null);
        }

        // Reset the markers array
        markers = [];
        for(i=0; i<len; i++) {
            var values=beanslist[i];
            var pt = new google.maps.LatLng(values.jjwg_maps_lat_c, values.jjwg_maps_lng_c);
            if (withRoute && len >1){
                if (i==0) origin = pt;
                else if (i==len-1) destination = pt;
                else waypoints.push({ location: pt });
            }
            markerdef= {position: pt,
                map: map,
                icon: JJWG.markers[ i % 25]
            };
            marker = new google.maps.Marker(markerdef);
            marker.set("id", values.id);
            marker.set("address", values.jjwg_maps_address_c);

/*
            google.maps.event.addListener(marker, 'click', (function(marker, point) {
                return function() {

                    result_html = mapDialog('QCRM_Tracker', marker.id, 'marker_' + marker.id, true, marker.address);
                        label='<div id="marker_'+marker.id+'" ><img src="themes/default/images/loading.gif"></div>';
                        infoWindow.setContent(label);
                        infoWindow.open(map, marker);
                    setTimeout(function(){infoWindow.close(map, marker)},1500);
                }
            })(marker, values));
*/
            markers.push(marker);
        }
        if (withRoute && len >1){
            var directionsDisplay,
                directionsService = new google.maps.DirectionsService(),
                request = {
                    origin: origin,
                    destination: destination,
                    waypoints: waypoints,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };
            directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
            directionsDisplay.setMap(map);
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);
                }
            });
        }
    };
    var withRoute = true;
    var beanslist = '';
    var mapdiv ='map-container';

	function StringToDbDate(dtStr){
		var m='',d='',y='',index,key;
		if (dtStr=='') return false;
		var dateParts=dtStr.match(date_reg_format);
		for(key in date_reg_positions){
			index=date_reg_positions[key];
			if(key=='m'){
				m += dateParts[index];
			}
			else if(key=='d'){
				d += dateParts[index];
			}
			else{
				y += dateParts[index];
			}
		}
	    if (m.length < 2)
    	    m = '0' + m;
    	if (d.length < 2) 
        	d = '0' + d;
		
		return [y, m, d].join('-');
	}

    function initMap(module){
    	var date = $('#date_tracking').val();
    	var user_id = $('#assigned_to').val();
    	if (!module) module = 'QCRM_Tracker';
        if(date && user_id){
            closeMessage();
            $.ajax(
                {url: "index.php?module=QCRM_Tracker&action=QCRM_TrackerData&to_pdf=1",
                    data: 'date='+StringToDbDate(date)+'&user='+user_id+'&module='+module,
                    type: "POST",
                    dataType:"json",
                    success: function(beanslist){
                    	if (typeof beanslist == 'string') beanslist=JSON.decode(beanslist);
                        if(beanslist.length>0){
                            JJWG.ShowBeansInMap(beanslist,mapdiv,withRoute);
                        }else {
                            showMessage();
                        }
                    }});
        }

    }

    // hide no geodata div
    function closeMessage(){
        $('#no_data').hide();
        $('#map-container-outer').show();

    }
    // shows no geodata div
    function showMessage() {
        $('#no_data').show();
        $('#map-container-outer').hide();
    }

    $(document).ready(function(){

		document.getElementById("SearchMap").disabled = true;
        JJWG.init(google_key);

        $('#route_checkbox').change(function(){
            var checked_route = $('#route_checkbox').prop('checked');
            withRoute = $('#route_checkbox').prop('checked');
            initMap();
            google.maps.event.trigger(map, 'resize')
        });

    });

