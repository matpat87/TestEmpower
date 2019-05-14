<?php
$module_name = 'CI_CustomerItems';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
        'headerTpl' => 'modules/CI_CustomerItems/tpls/EditViewHeader.tpl',
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/CI_CustomerItems/js/products.js',
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
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'ci_customeritems_im_itemmaster_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_IM_ITEMMASTER_FROM_IM_ITEMMASTER_TITLE',
          ),
          1 => 
          array (
            'name' => 'ci_customeritems_accounts_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
