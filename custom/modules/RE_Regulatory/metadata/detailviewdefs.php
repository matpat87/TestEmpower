<?php
$module_name = 'RE_Regulatory';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'visit_type_c',
            'studio' => 'visible',
            'label' => 'LBL_VISIT_TYPE',
          ),
          1 => 
          array (
            'name' => 'inspection_date_c',
            'label' => 'LBL_INSPECTION_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'regulatory_agency_c',
            'studio' => 'visible',
            'label' => 'LBL_REGULATORY_AGENCY',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'reason_visit_c',
            'label' => 'LBL_REASON_VISIT',
          ),
          1 => 
          array (
            'name' => 'date_received_c',
            'label' => 'LBL_DATE_RECEIVED',
          ),
        ),
        4 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'date_filed_c',
            'label' => 'LBL_DATE_FILED',
          ),
        ),
        5 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'total_fine_c',
            'label' => 'LBL_TOTAL_FINE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
