<?php
// created: 2023-03-30 08:57:28
$viewdefs['AOS_Products']['EditView'] = array (
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
      'headerTpl' => 'modules/AOS_Products/tpls/EditViewHeader.tpl',
    ),
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'modules/AOS_Products/js/products.js',
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
      'LBL_EDITVIEW_PANEL4' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_EDITVIEW_PANEL5' => 
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
          'name' => 'workflow_section_non_db',
          'label' => 'Workflow Section',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'type',
          'label' => 'LBL_TYPE',
        ),
        1 => 
        array (
          'name' => 'status_c',
          'studio' => 'visible',
          'label' => 'LBL_STATUS',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'overview_section_non_db',
          'label' => 'Overview Section',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'product_number_c',
          'label' => 'LBL_PRODUCT_NUMBER',
          'customCode' => '<input type="text" name="{$fields.product_number_c.name}" id="{$fields.product_number_c.name}" value="{$fields.product_number_c.value}" maxlength="{$fields.product_number_c.len}" class="custom-readonly" readonly="readonly" /> <input type="hidden" name="{$fields.id.name}" id="{$fields.id.name}" value="{$fields.id.value}"  /> <input type="hidden" name="{$fields.custom_related_product_id.name}" id="{$fields.custom_related_product_id.name}" value="{$fields.custom_related_product_id.value}"  />',
        ),
        1 => 
        array (
          'name' => 'tr_technicalrequests_aos_products_2_name',
          'displayParams' => 
          array (
            'field_to_name_array' => 
            array (
              'id' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
              'name' => 'tr_technicalrequests_aos_products_2_name',
              'resin_compound_type_c' => 'custom_carrier_resin',
              'color_c' => 'custom_color',
              'fda_food_contact_c' => 'custom_fda_eu_food_contact',
              'cm_product_form_c' => 'custom_geometry',
              'resin_type_c' => 'custom_resin_compound_type',
            ),
          ),
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'version_c',
          'label' => 'LBL_VERSION',
          'customCode' => '<input type="text" name="{$fields.version_c.name}" id="{$fields.version_c.name}" value="{$fields.version_c.value}" maxlength="{$fields.version_c.len}" class="custom-readonly" readonly="readonly" />',
        ),
        1 => 
        array (
          'name' => 'name',
          'label' => 'LBL_NAME',
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
          'name' => 'related_product_c',
          'studio' => 'visible',
          'label' => 'LBL_RELATED_PRODUCT',
          'customCode' => '<span class="sugar_field" id="related_product_c">{$fields.related_product_c.value} <input type="hidden" name="{$fields.aos_products_id_c.name}" value="{$fields.aos_products_id_c.value}" /> <input type="hidden" id="{$fields.custom_rematch_type.name}" name="{$fields.custom_rematch_type.name}" value="{$fields.custom_rematch_type.value}" /> <input type="hidden" name="{$fields.related_product_number_c.name}" value="{$fields.related_product_number_c.value}" /></span>',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'user_lab_manager_c',
          'studio' => 'visible',
          'label' => 'LBL_USER_LAB_MANAGER',
          'customCode' => '<select name="user_id_c" id="user_id_c" style="width: 50%" data-value="{$fields.user_id_c.value}">
              <option value=""></option>
            </select>',
        ),
        1 => '',
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'cost',
          'label' => 'LBL_COST',
        ),
        1 => 
        array (
          'name' => 'scheduling_code_c',
          'label' => 'LBL_SCHEDULING_CODE',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'priority_level_c',
          'studio' => 'visible',
          'label' => 'LBL_PRIORITY_LEVEL',
        ),
        1 => 
        array (
          'name' => 'complexity_c',
          'studio' => 'visible',
          'label' => 'LBL_COMPLEXITY',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'label' => 'LBL_DESCRIPTION',
        ),
        1 => 
        array (
          'name' => 'product_image_pic_c',
          'studio' => 'visible',
          'label' => 'LBL_PRODUCT_IMAGE_PIC',
        ),
      ),
      10 => 
      array (
        0 => 
        array (
          'name' => 'number_of_attempts_c',
          'label' => 'LBL_NUMBER_OF_ATTEMPTS',
          'customCode' => '<input type="text" name="{$fields.number_of_attempts_c.name}" id="{$fields.number_of_attempts_c.name}" size="30" maxlength="{$fields.number_of_attempts_c.len}" value="{$fields.number_of_attempts_c.value}" title="" tabindex="0" style="width: 20%" />',
        ),
        1 => 
        array (
          'name' => 'number_of_hours_c',
          'label' => 'LBL_NUMBER_OF_HOURS',
          'customCode' => '<input type="text" name="{$fields.number_of_hours_c.name}" id="{$fields.number_of_hours_c.name}" size="30" maxlength="{$fields.number_of_hours_c.len}" value="{$fields.number_of_hours_c.value}" title="" tabindex="0" style="width: 20%" />',
        ),
      ),
      11 => 
      array (
        0 => 
        array (
          'name' => 'created_by_name',
          'label' => 'LBL_CREATED',
          'type' => 'readonly',
        ),
        1 => 
        array (
          'name' => 'date_entered',
          'comment' => 'Date record created',
          'label' => 'LBL_DATE_ENTERED',
        ),
      ),
      12 => 
      array (
        0 => 
        array (
          'name' => 'due_date_c',
          'label' => 'LBL_DUE_DATE',
        ),
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
      ),
    ),
    'lbl_editview_panel4' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'base_resin_c',
          'label' => 'LBL_BASE_RESIN',
        ),
        1 => 
        array (
          'name' => 'color_c',
          'label' => 'LBL_COLOR',
        ),
      ),
    ),
    'lbl_editview_panel5' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'product_category_c',
        ),
        1 => array (
            'name' => 'brand_c',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'resin_type_c',
          'studio' => 'visible',
          'label' => 'LBL_RESIN_TYPE',
        ),
        1 => 
        array (
          'name' => 'resin_grade_c',
          'label' => 'LBL_RESIN_GRADE',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'geometry_c',
          'label' => 'LBL_GEOMETRY',
        ),
        1 => 
        array (
          'name' => 'fda_eu_food_contract_c',
          'label' => 'LBL_FDA_EU_FOOD_CONTRACT',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'comments_c',
          'studio' => 'visible',
          'label' => 'LBL_COMMENTS',
        ),
      ),
    ),
  ),
);