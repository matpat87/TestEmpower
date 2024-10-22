<?php
// created: 2023-03-30 08:57:28
$viewdefs['Users']['DetailView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
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
      'LBL_USER_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_EMPLOYEE_INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'collapsed',
      ),
    ),
  ),
  'panels' => 
  array (
    'LBL_USER_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 'full_name',
        1 => 'user_name',
      ),
      1 => 
      array (
        0 => 'status',
        1 => 
        array (
          'name' => 'UserType',
          'customCode' => '{$USER_TYPE_READONLY}',
        ),
      ),
      2 => 
      array (
        0 => 'photo',
        1 => 
        array (
          'name' => 'e_signature_c',
          'studio' => 'visible',
          'label' => 'LBL_E_SIGNATURE',
        ),
      ),
    ),
    'LBL_EMPLOYEE_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 'employee_status',
        1 => 'show_on_employees',
      ),
      1 => 
      array (
        0 => 'title',
        1 => 'phone_work',
      ),
      2 => 
      array (
        0 => 'department',
        1 => 'phone_mobile',
      ),
      3 => 
      array (
        0 => 'reports_to_name',
        1 => 'phone_other',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'role_c',
          'studio' => 'visible',
          'label' => 'LBL_ROLE',
        ),
        1 => 'phone_fax',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'sales_group_c',
          'studio' => 'visible',
          'label' => 'LBL_SALES_GROUP',
        ),
        1 => 'phone_home',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'site_c',
          'studio' => 'visible',
          'label' => 'LBL_SITE',
        ),
        1 => 
        array (
          'name' => 'division_c',
          'studio' => 'visible',
          'label' => 'LBL_DIVISION',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'employee_type_c',
          'studio' => 'visible',
          'label' => 'LBL_EMPLOYEE_TYPE',
        ),
        1 => 
        array (
          'name' => 'date_of_hire_c',
          'label' => 'LBL_DATE_OF_HIRE',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'gender_c',
          'studio' => 'visible',
          'label' => 'LBL_GENDER',
        ),
        1 => 
        array (
          'name' => 'date_of_birth_c',
          'label' => 'LBL_DATE_OF_BIRTH',
        ),
      ),
      9 => 
      array (
        0 => 'messenger_type',
        1 => 'messenger_id',
      ),
      10 => 
      array (
        0 => 'address_street',
        1 => 'address_city',
      ),
      11 => 
      array (
        0 => 'address_state',
        1 => 'address_postalcode',
      ),
      12 => 
      array (
        0 => 'address_country',
        1 => '',
      ),
      13 => 
      array (
        0 => 'description',
      ),
    ),
  ),
);