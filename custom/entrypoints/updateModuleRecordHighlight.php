<?php

	$bean = BeanFactory::getBean($_GET['activityName'], $_GET['activityRecordId']);
	$bean->highlights_c = ! $bean->highlights_c;
	$bean->save();
	echo json_encode(true);
?>