<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
	die ( 'Not A Valid Entry Point' );

error_reporting ( 1 ); // E_ERROR

require_once ('include/Dashlets/DashletGeneric.php');
require_once ('modules/asol_CalendarEvents/asol_CalendarEvents.php');
require_once ('modules/asol_CalendarEvents/include/server/controllers/controllerCalendar.php');
class asol_CalendarEventsDashlet extends DashletGeneric {
	function asol_CalendarEventsDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require ('modules/asol_CalendarEvents/metadata/dashletviewdefs.php');
		
		parent::DashletGeneric ( $id, $def );
		
		if (empty ( $def ['title'] ))
			$this->title = translate ( 'LBL_HOMEPAGE_TITLE', 'asol_CalendarEvents' );
		
		$this->seedBean = new asol_CalendarEvents ();
	}
	public function displayOptions() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $current_user, $timedate;
		
		$categories = asol_ConfigCRUD::getLanguage ();
		$timezoneVisibility = asol_ConfigCRUD::getTimezoneVisible ();
		$timezoneList = asol_ConfigCRUD::getTimezone ();
		
		$html = "";
		
		$html .= '<table width="100%" class="edit view">';
		$html .= '<tbody>';
		
		$html .= '<tr>';
		$html .= '<td scope="row" colspan="2">';
		$html .= '<h2>' . asol_CalendarEvents::translateCalendarLabel ( "LBL_DASHLET_TABLE_TITLE" ) . '</h2>';
		$html .= '</td>';
		$html .= '</tr>';
		
		if ($timezoneVisibility != '0') {
			$html .= '<tr>';
			$html .= '<td scope="row">';
			$html .= asol_CalendarEvents::translateCalendarLabel ( "LBL_FILTER_TIMEZONE" );
			$html .= '</td>';
			$html .= '<td>';
			$html .= '<select id="tzFilterPanel">';
			$html .= '<option selected value="' . $timedate->userTimezone ( $current_user ) . '">User/Timezone</option>';
			
			foreach ( $timezoneList as $zone ) {
				$html .= '<option value="' . $zone . '">' . $zone . '</option>';
			}
			
			$html .= '</select>';
			$html .= '</td>';
			$html .= '</tr>';
		}
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			
			$enableCountries = asol_manageDomains::getChildCountryDomains ( $current_user->asol_default_domain, true );
			
			$html .= '<tr>';
			$html .= '<td scope="row">';
			$html .= asol_CalendarEvents::translateCalendarLabel ( "LBL_FILTER_COUNTRIES" );
			$html .= '</td>';
			
			$html .= '<td>';
			$html .= '<select multiple id="countriesFilterPanel">';
			
			foreach ( $enableCountries as $country ) {
				$html .= '<option selected value="' . $country . '">' . $country . '</option>';
			}
			
			$html .= '</select>';
			$html .= '</td>';
			$html .= '</tr>';
		}
		
		$html .= '<tr>';
		$html .= '<td scope="row">';
		$html .= asol_CalendarEvents::translateCalendarLabel ( "LBL_FILTER_CATEGORIES" );
		$html .= '</td>';
		
		$html .= '<td>';
		$html .= '<select multiple id="categoriesFilterPanel">';
		
		foreach ( ($categories) as $key => $value ) {
			if ($current_language != "")
				$html .= '<option selected value="' . $key . '">' . $value [$current_language] . '</option>';
			else
				$html .= '<option selected value="' . $key . '">' . $value ['en_us'] . '</option>';
		}
		
		$html .= '</select>';
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '</tbody>';
		$html .= '</table>';
		
		$html .= '<script> 

    			if( $("#tzFilterPanel").length !== 0 )
					$("#tzFilterPanel").val(controllerCalendar.getTimezone());
		
				if (arrayCategory.length !== 0)
					 $("#categoriesFilterPanel").val(arrayCategory);
	
				if (arrayCountry.length !== 0)
					$("#countriesFilterPanel").val(arrayCountry);
    			
    			</script>';
		
		$html .= '<input onclick="pullEvents(jQueryCalendar(\'#calendar\').fullCalendar(\'getView\').intervalStart)" style="margin-left: 75%;" type="button" value="' . asol_CalendarEvents::translateCalendarLabel ( "LBL_BUTTON_SAVE" ) . '"/>';
		
		return $html;
	}
	public function display() {
		return asol_ControllerCalendar::displayDashlet ();
	}
}