<?php

	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "SELECT id, first_name, last_name
				FROM users 
			LEFT JOIN users_cstm
				ON users.id = users_cstm.id_c
			WHERE site_c = '".$_GET['selectedSite']."'
				AND deleted = 0
				AND status = 'Active'
				AND role_c LIKE '%^LabManager^%'
			ORDER BY id ASC
			LIMIT 1";

	$result = $db->query($sql);
	$row = $db->fetchByAssoc($result);

	echo json_encode($row);
?>