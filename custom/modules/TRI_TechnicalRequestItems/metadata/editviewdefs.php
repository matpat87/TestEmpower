<?php
$module_name = 'TRI_TechnicalRequestItems';
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
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
            'customCode' => '
              <input type="hidden" name="{$fields.distro_generated_c.name}" id="{$fields.distro_generated_c.name}" value="{$fields.distro_generated_c.value}"> 
              <input type="checkbox" style="margin-top: 6px;" id="distro_generated_c_readonly" name="distro_generated_c_readonly" value="1" title="" tabindex="0" {if $fields.distro_generated_c.value}checked="checked"{/if} disabled>
            ',
          ),
          1 => 
          array (
            'name' => 'name',
            'customCode' => '{$TR_ITEM}',
          ),
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
            'customCode' => '
              <input type="hidden" name="aos_products_tri_technicalrequestitems_1aos_products_ida" id="aos_products_tri_technicalrequestitems_1aos_products_ida" value="{$product_master_id}"> 
              <input type="text" name="{$fields.product_number.name}" id="{$fields.product_number.name}" value="{$fields.product_number.value}" maxlength="{$fields.product_number.len}" class="custom-readonly" readonly="readonly" />
            ',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'technical_request_number_non_db',
            'customCode' => '
              {if ! $fields.distro_generated_c.value || ! $fields.due_date.value}<input type="hidden" name="tri_techni0387equests_ida" id="tri_techni0387equests_ida" value="{$TR_ID}">{/if}
              <input type="hidden" name="tr_status" id="tr_status" value="{$TR_STATUS}">
              <input type="text" name="{$fields.technical_request_number_non_db.name}" id="{$fields.technical_request_number_non_db.name}" value="{$fields.technical_request_number_non_db.value}" maxlength="{$fields.technical_request_number_non_db.len}" class="custom-readonly" readonly="readonly" />
            ',
          ),
          1 => 
          array (
            'name' => 'qty',
            'label' => 'LBL_QTY',
            'customCode' => '<input type="text" name="{$fields.qty.name}" id="{$fields.qty.name}" value="{$fields.qty.value}" maxlength="{$fields.qty.len}" {if $fields.distro_generated_c.value}class="custom-readonly" readonly="readonly"{/if} />',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'technical_request_version_non_db',
            'label' => 'LBL_TECHNICAL_REQUEST_VERSION_NON_DB',
            'customCode' => '<input type="text" name="{$fields.technical_request_version_non_db.name}" id="{$fields.technical_request_version_non_db.name}" value="{$fields.technical_request_version_non_db.value}" maxlength="{$fields.technical_request_version_non_db.len}" class="custom-readonly" readonly="readonly" />',
          ),
          1 => 
          array (
            'name' => 'uom',
            'label' => 'LBL_UOM',
            'customCode' => '
              <input type="text" name="{$fields.uom.name}" id="{$fields.uom.name}" value="{$fields.uom.value}" maxlength="{$fields.uom.len}" {if $fields.distro_generated_c.value}class="custom-readonly" readonly="readonly"{/if}/>',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'due_date',
            'label' => 'LBL_DUE_DATE',
            'customCode' => '
              <span class="dateTime">
                <input class="date_input {if $fields.distro_generated_c.value && $fields.due_date.value}custom-readonly{/if}" autocomplete="off" type="text" name="{$fields.due_date.name}" id="{$fields.due_date.name}" value="{$fields.due_date.value}" title="" tabindex="0" size="{$fields.due_date.size}" {if $fields.distro_generated_c.value && $fields.due_date.value}readonly="readonly"{/if}">
                {if ! $fields.distro_generated_c.value || ! $fields.due_date.value}<button type="button" id="due_date_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="Enter Date"></span></button>{/if}
              </span>
            ',
          ),
          1 => 
          array (
            'name' => 'est_completion_date_c',
            'label' => 'LBL_EST_COMPLETION_DATE',
            'customCode' => '
              <span class="dateTime">
                <input class="date_input {if $fields.distro_generated_c.value && $fields.est_completion_date_c.value}custom-readonly{/if}" autocomplete="off" type="text" name="{$fields.est_completion_date_c.name}" id="{$fields.est_completion_date_c.name}" value="{$fields.est_completion_date_c.value}" title="" tabindex="0" size="{$fields.est_completion_date_c.size}" {if $fields.distro_generated_c.value && $fields.est_completion_date_c.value}readonly="readonly"{/if}">
                {if ! $fields.distro_generated_c.value || ! $fields.est_completion_date_c.value}<button type="button" id="est_completion_date_c_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="Enter Date"></span></button>{/if}
              </span>
            ',
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
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'work_performed_non_db',
            'label' => 'LBL_WORK_PERFORMED_NON_DB',
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
