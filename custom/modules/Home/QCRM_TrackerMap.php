<?php
	global $app_list_strings,$app_strings,$sugar_config,$timedate;
	
	require_once('custom/modules/Administration/QuickCRM_utils.php');
	$qutils=new QUtils();
	$qutils->LoadMobileConfig(true); // refresh first open only

	$current_tracker_mode = $qutils->mobile['trackermode'];
	$current_tracker_group = $qutils->mobile['trackergroup'];
	$current_tracker_role = $qutils->mobile['trackerrole'];
	
	$assigned_options ='';
	$users = get_user_array(true);// add blank if simple select
	foreach($users as $user_id=>$label){
		$display_user = false;
		if (empty($user_id) || $current_tracker_mode == 'all'){
			$display_user = true;
		}
		else if ($current_tracker_mode == 'ACLRoles'){
			$display_user = in_array($current_tracker_role,QUtils::get_user_roles($user_id,true));
		}
		else{ // security groups
			$display_user =array_key_exists($current_tracker_group,SecurityGroup::getUserSecurityGroups($user_id));
		}
		if ($display_user){
			$assigned_options .= '<option value="'.$user_id.'" >'.$label.'</option>';
		}
	}

    $time_format = $timedate->get_user_time_format();
    $date_format = $timedate->get_cal_date_format();
    $time_separator = ":";
    $match = array();
    if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)) {
        $time_separator = $match[1];
    }
    $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
    if (!isset($match[2]) || $match[2] == '') {
        $CALENDAR_FORMAT = $date_format . ' ' . $t23 . $time_separator . "%M";
    } else {
        $pm = $match[2] == "pm" ? "%P" : "%p";
        $CALENDAR_FORMAT = $date_format . ' ' . $t23 . $time_separator . "%M" . $pm;
    }
    
    
    $user_label = $app_strings['LBL_SELECT_USER_BUTTON_LABEL'];
    $date_label = $app_strings['LBL_DATE'];
    
    $google_maps_api_key = '';
	$administration = new Administration();
	$administration->retrieveSettings('',true);
	$google_key = '';
	if (isset($administration->settings['jjwg_google_maps_api_key'])){
		$google_key=$administration->settings['jjwg_google_maps_api_key'];
	}
	else if (isset($sugar_config['google_maps_api_key'])) {
		$google_key = $sugar_config['google_maps_api_key'];
	}

    $suitecrm_version = false;
    if (isset($sugar_config['suitecrm_version'])) $suitecrm_version = $sugar_config['suitecrm_version'];
        
    $custom_dir = true;
    if ($suitecrm_version){
        $custom_dir = version_compare($suitecrm_version, '7.5', '<');
    }
    $custom_dir = (int)$custom_dir; 

	echo getClassicModuleTitle(
    	"Administration",
    		array(
        		"<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Home')."</a>",
        		'QuickCRM Tracker ',
    		),
    		false
	);

echo <<<EOQ
		<script src="modules/QCRM_Tracker/showmap.js?_v=0.2"></script>

		<form name="synthesis" method="POST" action="index.php">
			<input type="hidden" name="module" value="Home">
			<input type="hidden" name="action" value="QCRM_TrackerMap">
			<input type="hidden" name="return_module" value="Home">
			<input type="hidden" name="return_action" value="index">
			<input type="hidden" id="to_pdf" name="tmp_to_pdf" value="1">

<table>

<tr>

<td>
<div>
<span class="dateTime">

&nbsp;&nbsp;$date_label 
<input class="date_input" autocomplete="off" name="date_tracking" id="date_tracking" value="" title="" tabindex="1" size="11" maxlength="10" type="text">
<img src="themes/default/images/jscalendar.gif?v=aydv3Ze8HTdMY3HNLDqegA" alt="Enter Date" style="position:relative; top:6px" id="date_tracking_trigger" border="0">

</span>
<script type="text/javascript">
var custom_dir = $custom_dir;
var google_key = '$google_key';
Calendar.setup ({
inputField : "date_tracking",
form : "",
ifFormat : "$CALENDAR_FORMAT",
daFormat : "$CALENDAR_FORMAT",
button : "date_tracking_trigger",
singleClick : true,
dateStr : "",
startWeekday: 0,
step : 1,
weekNumbers:false
}
);

function check_required(){
	var has_no_user = $('#assigned_to').val().length == 0;
	if (has_no_user){
		alert('Please select a user');
		return false;
	}
	return true;
}

</script>
</div> 
</td>
<td>
	&nbsp;&nbsp;$user_label&nbsp;<select style="vertical-align:middle;" id="assigned_to" name="assigned_to">
		$assigned_options
	</select>
</td>
</tr>

</table>

<br>
<br>
<input id="SearchMap" title='{$app_strings['LBL_SEARCH_BUTTON_LABEL']}' accessKey='S' class='button primary' onclick="initMap()" name='button' type='button' value='  {$app_strings['LBL_SEARCH_BUTTON_LABEL']}  '>
<input title='{$app_strings['LBL_CANCEL_BUTTON_LABEL']}' accessKey='X' class='button' onclick="location.href='index.php?module=Home&action=index';" type='button' name='button' value='  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  '>

</form>
<br style='clear:both;'>
<div id="map_container">
    <div id="no_data" style="text-align: center;display: none"><h3 style="color: #000000">No Data</h3></div>
    <div style="display: none" id="routes">

        <label for="route">Route</label>
        <input type="checkbox" name="route"  id="route_checkbox">
    </div>
    <div id="map-container-outer" style="display:none;width: 100%;height:600px;">
        <div id="map-container" style="width: 100%;height:600px;"></div>

    </div>

</div>
EOQ;
