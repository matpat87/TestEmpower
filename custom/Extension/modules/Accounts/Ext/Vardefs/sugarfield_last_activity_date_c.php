<?php
	// Manually added codes to generate dropdown list (retrieved and modified from cache\Modules\Accounts\Accountvardefs.php)
	$dictionary['Account']['fields']['last_activity_date_c'] = array (
		'inline_edit' => '',
		'options' => 'date_range_search_dom',
		'labelValue' => 'Last Activity Date',
		'enable_range_search' => '1',
		'required' => false,
		'source' => 'custom_fields',
		'name' => 'last_activity_date_c',
		'vname' => 'LBL_LAST_ACTIVITY_DATE',
		'type' => 'datetimecombo',
		'massupdate' => '0',
		'default' => '',
		'no_default' => false,
		'comments' => 'The use of this field is will be automatically updated once Account or relationship of Account has been updated.',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'true',
		'duplicate_merge_dom_value' => '1',
		'audited' => false,
		'reportable' => true,
		'unified_search' => false,
		'merge_filter' => 'disabled',
		'size' => '20',
		'dbType' => 'datetime',
		'id' => 'Accountslast_activity_date_c',
	);
?>