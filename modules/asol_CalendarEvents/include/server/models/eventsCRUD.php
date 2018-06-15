<?php
/**
 * @author AlineaSol
 */
class asol_EventsCRUD {
	public static $calendarevents_id = "asol_CalendarEvents";
	public static $calendarevents_table = "asol_calendarevents";
	/**
	 * @param string $type
	 */
	static public function deleteAllEventAssocType($type) {
		global $db;
		
		$db->query ( "DELETE FROM " . self::$calendarevents_id . " WHERE " . self::$calendarevents_id . ".category='" . $type . "'" );
	}
	/**
	 * @param string $timezone
	 * @param string $month - Format: MMYYYY -
	 * @return $db -> query
	 */
	static public function ObtainEvents($timezone, $month) {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		global $db, $current_user;
		
		$cstmExist = $db->query ( "SHOW TABLES LIKE '" . self::$calendarevents_table . "_cstm'" );
		
		$sqlSelect = "";
		$sqlWhere = "";
		$sqlJoin = "";
		
		$sqlSelect .= "SELECT " . self::$calendarevents_table . ".id, " . self::$calendarevents_table . ".allDay, " . self::$calendarevents_table . ".impact, ";
		$sqlSelect .= self::$calendarevents_table . ".country, " . self::$calendarevents_table . ".action, " . self::$calendarevents_table . ".visibility, " . self::$calendarevents_table . ".role, ";
		$sqlSelect .= self::$calendarevents_table . ".workflow, " . self::$calendarevents_table . ".info, " . self::$calendarevents_table . ".category, " . self::$calendarevents_table . ".title, ";
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			$sqlSelect .= self::$calendarevents_table . ".asol_domain_id, " . self::$calendarevents_table . ".asol_domain_published_mode, " . self::$calendarevents_table . ".asol_domain_child_share_depth, " . self::$calendarevents_table . ".asol_multi_create_domain, " . self::$calendarevents_table . ".asol_published_domain, ";
		}
		
		$sqlSelect .= self::$calendarevents_table . ".timezone, ";
		
		if ($cstmExist->num_rows > 0)
			$sqlSelect .= self::$calendarevents_table . "_cstm.*, ";
		
		$sqlSelect .= "IF(" . self::$calendarevents_table . ".allDay = '1', " . self::$calendarevents_table . ".start, convert_tz(" . self::$calendarevents_table . ".start, '+00:00', '" . $timezone . "')) AS start, ";
		$sqlSelect .= "IF(" . self::$calendarevents_table . ".allDay = '1', DATE_ADD(" . self::$calendarevents_table . ".end, INTERVAL 1 DAY), convert_tz(" . self::$calendarevents_table . ".end, '+00:00', '" . $timezone . "')) AS end ";
		$sqlWhere .= " WHERE " . self::$calendarevents_table . ".deleted=0 AND " . self::$calendarevents_table . ".month BETWEEN " . ($month - 1) . " AND " . ($month + 1) . " ";
		
		// **************************//
		// ***Is Domains Installed***//
		// **************************//
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			$sqlJoin .= " LEFT JOIN asol_domains ON asol_calendarevents.asol_domain_id=asol_domains.id ";
			
			if ((! $current_user->is_admin) || (($current_user->is_admin) && (! empty ( $current_user->asol_default_domain )))) {
				require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
				$domainsBean = BeanFactory::getBean ( 'asol_Domains', $current_user->asol_default_domain );
				if ($domainsBean->asol_domain_enabled) {
					$sqlWhere .= " AND ( (asol_calendarevents.asol_domain_id='" . $current_user->asol_default_domain . "')";
					
					if ($current_user->asol_only_my_domain == 0) {
						// asol_domain_child_share_depth
						$sqlWhere .= asol_manageDomains::getChildShareDepthQuery ( 'asol_calendarevents.' );
						// asol_domain_child_share_depth
						
						// asol_multi_create_domain
						$sqlWhere .= asol_manageDomains::getMultiCreateQuery ( 'asol_calendarevents.' );
						// asol_multi_create_domain
						
						// ***asol_publish_to_all***//
						$sqlWhere .= asol_manageDomains::getPublishToAllQuery ( 'asol_calendarevents.' );
						// ***asol_publish_to_all***//
						
						// ***asol_child_domains***//
						$sqlWhere .= asol_manageDomains::getChildHierarchyQuery ( 'asol_calendarevents.' );
						// ***asol_child_domains***//
					} else {
						$sqlWhere .= ") ";
					}
				} else {
					$sqlWhere .= " AND (1!=1) ";
				}
			}
		}
		
		// **************************//
		// ***Is Domains Installed***//
		// **************************//
		
		$roles = array ();
		
		if (! ($current_user->is_admin)) {
			$resultRoles = $db->query ( "SELECT DISTINCT role_id FROM acl_roles_users WHERE user_id='" . $current_user->id . "' AND deleted=0" );
			
			while ( $row = $db->fetchByAssoc ( $resultRoles ) )
				$roles [] = $row ['role_id'];
			
			$sqlWhere .= " AND (" . self::$calendarevents_table . ".visibility = 'public' OR " . self::$calendarevents_table . ".assigned_user_id = '" . $current_user->id . "' OR " . self::$calendarevents_table . ".created_by = '" . $current_user->id . "'";
			
			$sqlWhereRoles = " OR ((" . self::$calendarevents_table . ".visibility LIKE 'role') AND ( ";
			foreach ( $roles as $role )
				$sqlWhereRoles .= self::$calendarevents_table . ".role LIKE '%" . $role . "%' OR";
			$sqlWhereRoles = substr ( $sqlWhereRoles, 0, - 2 ) . "))";
			
			if (empty ( $role ))
				$sqlWhereRoles = "";
			
			$sqlWhere .= $sqlWhereRoles . " )";
		}
		
		if ($cstmExist->num_rows > 0)
			$resultSet = $db->query ( $sqlSelect . " FROM " . self::$calendarevents_table . " LEFT JOIN " . self::$calendarevents_table . "_cstm ON ( " . self::$calendarevents_table . ".id = " . self::$calendarevents_table . "_cstm.id_c ) " . $sqlJoin . " " . $sqlWhere );
		else
			$resultSet = $db->query ( $sqlSelect . " FROM " . self::$calendarevents_table . " " . $sqlJoin . " " . $sqlWhere );
		
		return $resultSet;
	}
}
