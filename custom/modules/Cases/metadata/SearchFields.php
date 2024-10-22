<?php
// created: 2023-09-05 09:39:01
$searchFields['Cases'] = array (
  'name' => 
  array (
    'query_type' => 'default',
    'force_unifiedsearch' => true,
  ),
  'account_name' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'accounts.name',
    ),
  ),
  'status' => 
  array (
    'query_type' => 'default',
    'options' => 'case_status_dom',
    'template_var' => 'STATUS_OPTIONS',
  ),
  'priority' => 
  array (
    'query_type' => 'default',
    'options' => 'case_priority_dom',
    'template_var' => 'PRIORITY_OPTIONS',
    'options_add_blank' => true,
  ),
  'case_number' => 
  array (
    'query_type' => 'default',
    'operator' => 'in',
    'force_unifiedsearch' => true,
  ),
  'current_user_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'assigned_user_id',
    ),
    'my_items' => true,
    'vname' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
  ),
  'assigned_user_id' => 
  array (
    'query_type' => 'default',
  ),
  'open_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'status',
    ),
    'operator' => 'not in',
    'closed_values' => 
    array (
      0 => 'Closed',
      1 => 'Rejected',
      2 => 'Duplicate',
      3 => 'Closed_Closed',
      4 => 'Closed_Rejected',
      5 => 'Closed_Duplicate',
    ),
    'type' => 'bool',
  ),
  'range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'state' => 
  array (
    'query_type' => 'default',
  ),
  'product_number_non_db' => 
  array (
    'query_type' => 'like',
    'operator' => 'subquery',
    'subquery' => 'SELECT cases.id FROM ci_customeritems 
      LEFT JOIN ci_customeritems_cstm 
        ON ci_customeritems_cstm.id_c = ci_customeritems.id
      LEFT JOIN cases_ci_customeritems_1_c 
        ON cases_ci_customeritems_1_c.cases_ci_customeritems_1ci_customeritems_idb = ci_customeritems.id
        AND cases_ci_customeritems_1_c.deleted = 0
      LEFT JOIN ci_customeritems_cases_1_c
        ON ci_customeritems_cases_1_c.ci_customeritems_cases_1ci_customeritems_ida = ci_customeritems.id
        AND ci_customeritems_cases_1_c.deleted = 0
      LEFT JOIN cases 
        ON (
          cases.id = cases_ci_customeritems_1_c.cases_ci_customeritems_1cases_ida 
          OR 
          cases.id = ci_customeritems_cases_1_c.ci_customeritems_cases_1cases_idb
        )
        AND cases.deleted = 0
      WHERE ci_customeritems.deleted = 0 AND ci_customeritems_cstm.product_number_c LIKE',
    'db_field' => 
    array (
      0 => 'id',
    ),
    'force_unifiedsearch' => true,
  ),
  'favorites_only' => 
  array (
    'query_type' => 'format',
    'operator' => 'subquery',
    'checked_only' => true,
    'subquery' => 'SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = \'Cases\'
			                        and favorites.assigned_user_id = \'{1}\'',
    'db_field' => 
    array (
      0 => 'id',
    ),
  ),
  'type' => 
  array (
    'query_type' => 'default',
  ),
);