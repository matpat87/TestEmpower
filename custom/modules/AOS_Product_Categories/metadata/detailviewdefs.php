<?php
// created: 2023-03-30 08:57:28
$viewdefs['AOS_Product_Categories']['DetailView'] = array (
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
      'DEFAULT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'pcatid_c',
          'label' => 'LBL_PCATID',
        ),
        1 => 'status_c',
      ),
      1 => 
      array (
        0 => 'name',
        1 => 'assigned_user_name',
      ),
      2 => 
      array (
        0 => 'description',
        1 => 
        array (
          'name' => 'parent_category_name',
          'label' => 'LBL_PRODUCT_CATEGORYS_NAME',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'is_parent',
          'label' => 'LBL_IS_PARENT',
        ),
        1 => 
        array (
          'name' => 'division_c',
          'studio' => 'visible',
          'label' => 'LBL_DIVISION',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'company_no_c',
          'studio' => 'visible',
          'label' => 'LBL_COMPANY_NO',
        ),
        1 => 
        array (
          'name' => 'material_cost_type_c',
          'label' => 'LBL_MATERIAL_COST_TYPE',
        ),
      ),
    ),
  ),
);