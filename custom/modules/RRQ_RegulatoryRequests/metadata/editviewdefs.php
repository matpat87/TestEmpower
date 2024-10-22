<?php
$module_name = 'RRQ_RegulatoryRequests';
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
            'name' => 'id_num_c',
            'label' => 'LBL_ID_NUM',
            'type' => 'readonly',
            'customCode' => '<span class="sugar_field" id="id_num_c">{$fields.id_num_c.value}</span><input type="hidden" name="custom_action" id="custom_action" value="{$fields.custom_action.value}" /><input type="hidden" name="db_status" id="db_status" value="{$fields.status_c.value}" /><input type="hidden" name="db_created_by" id="db_created_by" value="{$fields.created_by.value}" /><input type="hidden" name="db_req_by_id" id="db_req_by_id" value="{$fields.user_id_c.value}" /><input type="hidden" name="db_req_by_name" id="db_req_by_name" value="{$fields.req_by_c.value}" />',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'req_type_c',
            'studio' => 'visible',
            'label' => 'LBL_REQ_TYPE',
          ),
          1 => 
          array (
            'name' => 'accounts_rrq_regulatoryrequests_1_name',
            'displayParams' => 
            array (
              'initial_filter' => '&filter_regulatory_request_accounts_data=true',
            ),
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'contacts_rrq_regulatoryrequests_1_name',
            'displayParams' => 
            array (
              'initial_filter' => '&from_module=3DRRQ_RegulatoryRequests&account_name="+encodeURIComponent(document.getElementById("accounts_rrq_regulatoryrequests_1_name").value.substring(0, 
                ( document.getElementById("accounts_rrq_regulatoryrequests_1_name").value.indexOf("(") !== -1 ) ? document.getElementById("accounts_rrq_regulatoryrequests_1_name").value.lastIndexOf("(") : 
                document.getElementById("accounts_rrq_regulatoryrequests_1_name").value.length ).trim())+"',
            ),
          ),
        ),
        3 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'status_update_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_UPDATE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'req_date_c',
            'label' => 'LBL_REQ_DATE',
          ),
          1 => 
          array (
            'name' => 'req_by_c',
            'studio' => 'visible',
            'label' => 'LBL_REQ_BY',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'customCode' => '{if $IS_EDITABLE_ASSIGNED_TO_FIELD == true}@@FIELD@@{else}<span class="sugar_field" id="assigned_user_name">{$fields.assigned_user_name.value}<input type="hidden" name="assigned_user_id" id="assigned_user_id" value="{$fields.assigned_user_id.value}"></span>{/if}'
          ),
          1 => 
          array (
            'name' => 'submit_by_c',
            'studio' => 'visible',
            'label' => 'LBL_SUBMIT_BY',
            'type' => 'readonly',
            'customCode' => '<span class="sugar_field" id="submit_by_c">{$fields.submit_by_c.value}<input type="hidden" name="user_id1_c" id="user_id1_c" value="{$fields.user_id1_c.value}"></span>',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'total_requests_c',
            'label' => 'LBL_TOTAL_REQUESTS',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'customer_products_panel_nondb',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'custom_customer_products_html',
            'customCode' => '{$CUSTOMER_PRODUCTS_HTML}',
          ),
        ),
      ),
    ),
  ),
);
;
?>
