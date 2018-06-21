<?php
$module_name = 'EHS_EHS';
$_object_name = 'ehs_ehs';
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'LBL_EDITVIEW_PANEL1' => 
      array (
        0 => 
        array (
          0 => 'ehs_ehs_number',
          1 => 'status',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'label' => 'LBL_TYPE',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'skilled_lang_c',
            'studio' => 'visible',
            'label' => 'LBL_SKILLED_LANG',
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
            'name' => 'personal_factors_c',
            'studio' => 'visible',
            'label' => 'LBL_PERSONAL_FACTORS',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'first_name_c',
            'label' => 'LBL_FIRST_NAME',
          ),
          1 => 
          array (
            'name' => 'period_c',
            'studio' => 'visible',
            'label' => 'LBL_PERIOD',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'last_name_c',
            'label' => 'LBL_LAST_NAME',
          ),
          1 => 'priority',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'individual_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INDIVIDUAL_TYPE',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'age_injured_person_c',
            'studio' => 'visible',
            'label' => 'LBL_AGE_INJURED_PERSON',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'gender_c',
            'studio' => 'visible',
            'label' => 'LBL_GENDER',
          ),
          1 => '',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'disabilities_c',
            'label' => 'LBL_DISABILITIES',
          ),
          1 => '',
        ),
        10 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'division_c',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
      ),
      'LBL_EDITVIEW_PANEL2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'incident_location_c',
            'label' => 'LBL_INCIDENT_LOCATION',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'fatality_injury_c',
            'studio' => 'visible',
            'label' => 'LBL_FATALITY_INJURY',
          ),
          1 => 
          array (
            'name' => 'injury_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INJURY_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'incident_date_c',
            'label' => 'LBL_INCIDENT_DATE_C',
          ),
          1 => 
          array (
            'name' => 'injured_parts_c',
            'studio' => 'visible',
            'label' => 'LBL_INJURED_PARTS',
          ),
        ),
        3 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'unsafe_act_c',
            'studio' => 'visible',
            'label' => 'LBL_UNSAFE_ACT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'witness_c',
            'label' => 'LBL_WITNESS',
          ),
          1 => 
          array (
            'name' => 'number_people_injured_c',
            'label' => 'LBL_NUMBER_PEOPLE_INJURED',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'job_factors_c',
            'studio' => 'visible',
            'label' => 'LBL_JOB_FACTORS',
          ),
          1 => 
          array (
            'name' => 'days_lost_through_injury_c',
            'label' => 'LBL_DAYS_LOST_THROUGH_INJURY',
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
          0 => 
          array (
            'name' => 'underlying_causes_c',
            'label' => 'LBL_UNDERLYING_CAUSES',
          ),
          1 => 
          array (
            'name' => 'root_cause_c',
            'studio' => 'visible',
            'label' => 'LBL_ROOT_CAUSE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'unsafe_conditions_c',
            'studio' => 'visible',
            'label' => 'LBL_UNSAFE_CONDITIONS',
          ),
          1 => 
          array (
            'name' => 'cause_c',
            'studio' => 'visible',
            'label' => 'LBL_CAUSE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'severity_c',
            'studio' => 'visible',
            'label' => 'LBL_SEVERITY',
          ),
          1 => 
          array (
            'name' => 'findings_corrective_action_c',
            'label' => 'LBL_FINDINGS_CORRECTIVE_ACTION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'potential_severity_rating_c',
            'studio' => 'visible',
            'label' => 'LBL_POTENTIAL_SEVERITY_RATING',
          ),
          1 => 
          array (
            'name' => 'investigator_c',
            'studio' => 'visible',
            'label' => 'LBL_INVESTIGATOR',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'actual_risk_c',
            'studio' => 'visible',
            'label' => 'LBL_ACTUAL_RISK',
          ),
          1 => 
          array (
            'name' => 'action_items_c',
            'label' => 'LBL_ACTION_ITEMS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'potential_risk_c',
            'studio' => 'visible',
            'label' => 'LBL_POTENTIAL_RISK',
          ),
          1 => 
          array (
            'name' => 'actionitem_assigned_user_c',
            'studio' => 'visible',
            'label' => 'LBL_ACTIONITEM_ASSIGNED_USER',
          ),
        ),
        7 => 
        array (
          0 => '',
          1 => '',
        ),
        8 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'signoff_date_c',
            'label' => 'LBL_SIGNOFF_DATE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
