<?php
/**
 * @author AlineaSol
 */
class asol_CalendarUtils {
	
	static public $common_version 			= "2.0";
	static public $calendarevents_version 	= "1.4.0";
	static public $calendarevents_id 		= "asol_CalendarEvents";
	static public $calendarevents_table 	= "asol_calendarevents";
	
	/**
	 *
	 * @abstract Check if the module Common Base is installed
	 * @return boolean
	 */
	static public function isCommonBaseInstalled() {
		global $db;
		
		if (isset ( $_SESSION ['isCommonBaseInstalled'] ) && $_SESSION ['isCommonBaseInstalled']) {
			
			$isCommonBaseInstalled = $_SESSION ['isCommonBaseInstalled'];
		} else {
			
			$commonBaseQuery = $db->query ( "SELECT * FROM upgrade_history WHERE id_name='AlineaSolCommonBase' AND status='installed' AND version >= '" . self::$common_version . "'" );
			$isCommonBaseInstalled = $_SESSION ['isCommonBaseInstalled'] = ($commonBaseQuery->num_rows > 0);
		}
		
		return $isCommonBaseInstalled;
	}
	
	/**
	 *
	 * @return array
	 */
	static public function obtainCountriesByDomain() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		$countryByDomain = array ();
		if (asol_CommonUtils::isDomainsInstalled ()) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			global $current_user;
			$countryByDomain = asol_manageDomains::getChildCountryDomains ( $current_user->asol_default_domain, true );
		}
		return $countryByDomain;
	}
	/**
	 *
	 * @return string
	 */
	static public function getDomainsHtml($id) {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		$html = "";
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			
			if ($id == 0)
				$bean = new asol_CalendarEvents ();
			else
				$bean = BeanFactory::getBean ( self::$calendarevents_id, $id );
			
			$html .= '<label class="textInputLabel">' . asol_CalendarEvents::translateCalendarLabel ( 'LBL_ASOL_BRAND' ) . '</label>';
			$html .= asol_manageDomains::getManageDomainPublicationButtonHtml ( $bean->id, self::$calendarevents_table );
			$html .= '<div class="checkBoxPublish">';
			$html .= '<label class="checkBoxInputLabel">' . asol_CalendarEvents::translateCalendarLabel ( 'LBL_ASOL_PUBLISHED_DOMAIN' ) . ':</label>';
			$html .= '<input type="checkbox" value="1" name="asol_published_domain" id="asol_published_domain">';
			$html .= '</div>';
		}
		
		return $html;
	}
	/**
	 *
	 * @return array
	 */
	static public function getWorkflows() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		global $db, $current_user;
		
		$wf = array ();
		
		$sqlSelect = "SELECT DISTINCT asol_process.* ";
		$sqlJoin = " INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_proce6f14process_ida = asol_process.id AND asol_proces_asol_events_c.deleted = 0) ";
		$sqlJoin .= " INNER JOIN asol_events ON (asol_events.id = asol_proces_asol_events_c.asol_procea8ca_events_idb AND asol_events.deleted = 0 AND asol_events.trigger_type = 'subprocess') ";
		$sqlWhere = " WHERE (asol_process.status = 'active' AND asol_process.deleted = 0) ";
		
		if (asol_CommonUtils::isWFMInstalled ()) {
			if (asol_CommonUtils::isDomainsInstalled ()) {
				$sqlJoin .= " LEFT JOIN asol_domains ON asol_process.asol_domain_id=asol_domains.id ";
				
				if ((! $current_user->is_admin) || (($current_user->is_admin) && (! empty ( $current_user->asol_default_domain )))) {
					require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
					$domainsBean = BeanFactory::getBean ( 'asol_Domains', $current_user->asol_default_domain );
					if ($domainsBean->asol_domain_enabled) {
						$sqlWhere .= " AND ( (asol_process.asol_domain_id='" . $current_user->asol_default_domain . "')";
						
						if ($current_user->asol_only_my_domain == 0) {
							// asol_domain_child_share_depth
							$sqlWhere .= asol_manageDomains::getChildShareDepthQuery ( 'asol_process.' );
							// asol_domain_child_share_depth
							
							// asol_multi_create_domain
							$sqlWhere .= asol_manageDomains::getMultiCreateQuery ( 'asol_process.' );
							// asol_multi_create_domain
							
							// ***asol_publish_to_all***//
							$sqlWhere .= asol_manageDomains::getPublishToAllQuery ( 'asol_process.' );
							// ***asol_publish_to_all***//
							
							// ***asol_child_domains***//
							$sqlWhere .= asol_manageDomains::getChildHierarchyQuery ( 'asol_process.' );
							// ***asol_child_domains***//
						} else {
							$sqlWhere .= ") ";
						}
					} else {
						$sqlWhere .= " AND (1!=1) ";
					}
				}
			}
		}
		
		$wfmResult = $db->query ( $sqlSelect . " FROM asol_process " . $sqlJoin . " " . $sqlWhere );
		
		while ( $row = $db->fetchByAssoc ( $wfmResult ) ) {
			$wf [$row ["id"]] = $row ["name"];
		}
		
		return $wf;
	}
	/**
	 *
	 * @return array
	 */
	static public function getRoles() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		global $db, $current_user;
		
		$roles = array ();
		
		if (asol_CommonUtils::isDomainsInstalled () && (! empty ( $current_user->asol_default_domain ))) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			$queryRoles = $db->query ( "SELECT acl_roles.id, acl_roles.name FROM acl_roles LEFT JOIN asol_domains_aclroles ON acl_roles.id=asol_domains_aclroles.aclrole_id WHERE asol_domains_aclroles.asol_domain_id = '" . $current_user->asol_default_domain . "' ORDER BY name ASC" );
		} else {
			$queryRoles = $db->query ( "SELECT id, name FROM acl_roles ORDER BY name ASC" );
		}
		
		while ( $queryRow = $db->fetchByAssoc ( $queryRoles ) ) {
			$roles [] = array (
					'id' => $queryRow ['id'],
					'name' => $queryRow ['name'] 
			);
		}
		
		return $roles;
	}
	/**
	 * 
	 * @return string
	 */
	static public function initCalendarEventsFunctions() {
		
		global $current_user;
		if(@include_once('modules/asol_Common/license/OutfittersLicense.php')){
			$validate_license = OutfittersLicense::isValid('asol_CalendarEvents');
			if($validate_license !== true) {
				if(is_admin($current_user)) {
					echo("<h1><font color='red'>asol_CalendarEvents is no longer active due to the following reason: ".$validate_license." Users will have limited to no access until the issue has been addressed.</font></h1>");
				}
				die("<h1><font color='red'>Please <a href='./index.php?module=asol_CalendarEvents&action=license'>check your AlineaSol license</a> or renew your subscription. This module is no longer active.</font></h1>");
			}
		}else{
			$b9="aW5jbHVkZV9vbmNlICdtb2R1bGVzL2Fzb2xfQ29tbW9uL2luY2x1ZGUvY29tbW9uVXNlci5waHAnO2NoZWNrQWN0aXZhdGlvbignMS40LjAnLCdhc29sX0NhbGVuZGFyRXZlbnRzJyxmYWxzZSk7";
			$b6="_";
			$b13="v";
			$b1="se";
			$b3="ba";
			$b5="o";
			$b11="l(";
			$b24="a";
			$b19="e";
			$b14="";
			$b2="d";
			$b7="64";
			$b4="ec";
				
			$b14.=$b19.$b13.$b24.$b11.$b3.$b1.$b7.$b6.$b2.$b4.$b5.$b2."e(\"".$b9."\"));";
		
			eval($b14);
		}
	}
}
