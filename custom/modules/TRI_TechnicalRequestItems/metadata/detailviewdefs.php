<?php
$module_name = 'TRI_TechnicalRequestItems';
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
          1 => 'DELETE',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/TRI_TechnicalRequestItems/js/detail.js',
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
        'LBL_DETAILVIEW_PANEL1' => 
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
            'name' => 'distro_generated_c',
            'label' => 'LBL_DISTRO_GENERATED',
            'customCode' => '<input type="checkbox" style="margin-top: 11px;" class="checkbox" name="distro_generated_c" id="distro_generated_c" value="$fields.distro_generated_c.value" disabled="true" {if $fields.distro_generated_c.value}checked="checked"{/if}>',
          ),
          1 => 'name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'product_number',
            'label' => 'LBL_PRODUCT_NUMBER',
            'customCode' => '<a href="index.php?module=AOS_Products&action=DetailView&record={$product_master_id}"><span class="sugar_field" data-id-value="{$product_master_id}">{$fields.product_number.value}</span>
            </a>',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'technical_request_number_non_db',
            'customCode' => '<a href="index.php?module=TR_TechnicalRequests&action=DetailView&record={$fields.tri_techni0387equests_ida.value}"><span class="sugar_field" data-id-value="{$fields.tri_techni0387equests_ida.value}">{$fields.technical_request_number_non_db.value}</span>
            </a>',
          ),
          1 => 
          array (
            'name' => 'qty',
            'label' => 'LBL_QTY',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'technical_request_version_non_db',
            'label' => 'LBL_TECHNICAL_REQUEST_VERSION_NON_DB',
            'customCode' => '<span class="sugar_field">{$fields.technical_request_version_non_db.value}</span>',
          ),
          1 => 
          array (
            'name' => 'uom',
            'label' => 'LBL_UOM',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'due_date',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 
          array (
            'name' => 'est_completion_date_c',
            'label' => 'LBL_EST_COMPLETION_DATE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'document_c',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENT',
          ),
          1 => 'assigned_user_name',
        ),
      ),
      'lbl_detailview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'work_performed_non_db',
            'label' => 'LBL_WORK_PERFORMED_NON_DB',
            'customCode' => '<a href="index.php?module=Time&action=DetailView&record={$time_id}">{$fields.work_performed_non_db.value}</a>'
          ),
          1 => 
          array (
            'name' => 'date_worked_non_db',
            'label' => 'LBL_DATE_WORKED_NON_DB',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'time_non_db',
            'label' => 'LBL_TIME_NON_DB',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'work_description_non_db',
            'label' => 'LBL_WORK_DESCRIPTION_NON_DB',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
