<?php

	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "SELECT id, first_name, last_name
				FROM users 
			LEFT JOIN users_cstm
				ON users.id = users_cstm.id_c
			WHERE (users_cstm.site_c LIKE '%^{$_GET['selectedSite']}^%' OR users_cstm.site_c LIKE '%{$_GET['selectedSite']}%')
				AND deleted = 0
				AND status = 'Active'
				AND role_c LIKE '%QualityManager%'
			ORDER BY id ASC
			LIMIT 1";

	$result = $db->query($sql);
	$row = $db->fetchByAssoc($result);

	echo json_encode($row);
?>