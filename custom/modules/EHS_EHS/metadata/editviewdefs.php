<?php
$module_name = 'EHS_EHS';
$_object_name = 'ehs_ehs';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/EHS_EHS/js/custom-edit.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'LBL_EDITVIEW_PANEL1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'ehs_ehs_number',
            'type' => 'readonly',
          ),
          1 => 
          array (
            'name' => 'near_miss_c',
            'label' => 'LBL_NEAR_MISS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
          ),
          1 => 'status',
        ),
        2 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'label' => 'LBL_TYPE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'return_date_c',
            'label' => 'LBL_RETURN_DATE',
          ),
          1 => 
          array (
            'name' => 'ehs_subtype_c',
            'studio' => 'visible',
            'label' => 'LBL_EHS_SUBTYPE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'incident_date_c',
            'label' => 'LBL_INCIDENT_DATE_C',
          ),
          1 => 
          array (
            'name' => 'severity_c',
            'studio' => 'visible',
            'label' => 'LBL_SEVERITY',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
          1 => 
          array (
            'name' => 'potential_severity_rating_c',
            'studio' => 'visible',
            'label' => 'LBL_POTENTIAL_SEVERITY_RATING',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'incident_location_c',
            'label' => 'LBL_INCIDENT_LOCATION',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'witness_c',
            'label' => 'LBL_WITNESS',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'number_people_injured_c',
            'label' => 'LBL_NUMBER_PEOPLE_INJURED',
          ),
          1 => '',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'individual_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INDIVIDUAL_TYPE',
          ),
          1 => 
          array (
            'name' => 'area_of_incident_c',
            'studio' => 'visible',
            'label' => 'LBL_AREA_OF_INCIDENT',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'age_injured_person_c',
            'studio' => 'visible',
            'label' => 'LBL_AGE_INJURED_PERSON',
          ),
          1 => '',
        ),
      ),
      'LBL_EDITVIEW_PANEL4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'legally_reportable_c',
            'studio' => 'visible',
            'label' => 'LBL_LEGALLY_REPORTABLE',
          ),
          1 => 
          array (
            'name' => 'likelihood_c',
            'studio' => 'visible',
            'label' => 'LBL_LIKELIHOOD',
          ),
        ),
        1 => 
        array (
          0 => 'root_cause_c',
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'personal_factors_c',
            'studio' => 'visible',
            'label' => 'LBL_PERSONAL_FACTORS',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'investigator_c',
            'studio' => 'visible',
            'label' => 'LBL_INVESTIGATOR',
          ),
          1 => 
          array (
            'name' => 'action_items_c',
            'label' => 'LBL_ACTION_ITEMS',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'actual_risk_c',
            'studio' => 'visible',
            'label' => 'LBL_ACTUAL_RISK',
          ),
          1 => 
          array (
            'name' => 'actionitem_assigned_user_c',
            'studio' => 'visible',
            'label' => 'LBL_ACTIONITEM_ASSIGNED_USER',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'potential_risk_c',
            'studio' => 'visible',
            'label' => 'LBL_POTENTIAL_RISK',
          ),
          1 => 
          array (
            'name' => 'injury_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INJURY_TYPE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'injured_parts_c',
            'studio' => 'visible',
            'label' => 'LBL_INJURED_PARTS',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'days_lost_through_injury_c',
            'label' => 'LBL_DAYS_LOST_THROUGH_INJURY',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'signoff_date_c',
            'label' => 'LBL_SIGNOFF_DATE',
          ),
          1 => 
          array (
            'name' => 'restricted_days_c',
            'label' => 'LBL_RESTRICTED_DAYS',
          ),
        ),
      ),
      'LBL_EDITVIEW_PANEL3' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
