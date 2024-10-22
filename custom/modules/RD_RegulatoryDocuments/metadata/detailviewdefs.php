<?php
$module_name = 'RD_RegulatoryDocuments';
$_object_name = 'rd_regulatorydocuments';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'form' => 
      array (
      ),
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
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'uploadfile',
          1 => 'status',
        ),
        1 => 
        array (
          0 => 'document_name',
          1 => '',
        ),
        2 => 
        array (
          0 => 'active_date',
          1 => 'exp_date',
        ),
        3 => 
        array (
          0 => 'category_id',
          1 => 'subcategory_id',
        ),
        4 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'rd_regulatorydocuments_rd_regulatorydocuments_1_name',
          ),
        ),
        5 => 
        array (
          0 => 'assigned_user_name',
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
