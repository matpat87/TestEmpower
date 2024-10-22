<?php
// created: 2023-03-30 08:57:28
$viewdefs['Users']['EditView'] = array (
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
    'form' => 
    array (
      'headerTpl' => 'modules/Users/tpls/EditViewHeader.tpl',
      'footerTpl' => 'modules/Users/tpls/EditViewFooter.tpl',
    ),
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'custom/modules/Users/js/custom-editview.js',
      ),
    ),
    'useTabs' => false,
    'tabDefs' => 
    array (
      'LBL_USER_INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_EMPLOYEE_INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'LBL_USER_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'user_name',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 'first_name',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'status',
          'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$STATUS_READONLY}{/if}',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 'last_name',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'UserType',
          'customCode' => '{if $IS_ADMIN}{$USER_TYPE_DROPDOWN}{else}{$USER_TYPE_READONLY}{/if}',
        ),
      ),
      3 => 
      array (
        0 => 'photo',
        1 => 
        array (
          'name' => 'e_signature_c',
          'studio' => 'visible',
          'label' => 'LBL_E_SIGNATURE',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'factor_auth',
          'label' => 'LBL_FACTOR_AUTH',
        ),
      ),
    ),
    'LBL_EMPLOYEE_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'employee_status',
          'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$EMPLOYEE_STATUS_READONLY}{/if}',
        ),
        1 => 'show_on_employees',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'title',
          'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$TITLE_READONLY}{/if}',
        ),
        1 => 'phone_work',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'department',
          'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$DEPT_READONLY}{/if}',
        ),
        1 => 'phone_mobile',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'reports_to_name',
          'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$REPORTS_TO_READONLY}{/if}',
        ),
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