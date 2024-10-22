<?php
$module_name = 'DSBTN_Distribution';
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
            'name' => 'custom_overview_label_non_db',
            'studio' => 'visible',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'distribution_number_c',
            'label' => 'LBL_DISTRIBUTION_NUMBER',
            'type' => 'readonly',
            'customCode' => '<span class="sugar_field" id="distribution_number_c">{$fields.distribution_number_c.value}</span><input type="hidden" name="custom_technical_request_id_non_db" id="custom_technical_request_id_non_db" value="{$fields.custom_technical_request_id_non_db.value}" /> <input type="hidden" name="distribution_id" id="distribution_id" value="{$fields.id.value}" />',
          ),
          1 => 'assigned_user_name',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'technical_request_c',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL_REQUEST',
          ),
        ),
        3 => 
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
        4 => 
        array (
          0 => 
          array (
            'name' => 'custom_recipient_information_label_non_db',
            'studio' => 'visible',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'account_c',
            'studio' => 'visible',
            'label' => 'LBL_ACCOUNT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'contact_c',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
            'displayParams' => 
            array (
              'initial_filter' => '&from_module=DSBTN_Distribution&account_id="+encodeURIComponent(document.getElementById("account_id_c").value)+"&account_name="+encodeURIComponent(document.getElementById("account_c").value.substring(0, document.getElementById("account_c").value.lastIndexOf("(")).trim())+"',
              'field_to_name_array' => 
              array (
                'id' => 'contact_id_c',
                'name' => 'contact_c',
                'primary_address_street' => 'primary_address_street',
                'primary_address_city' => 'primary_address_city',
                'primary_address_state' => 'primary_address_state',
                'primary_address_postalcode' => 'primary_address_postalcode',
                'primary_address_country' => 'primary_address_country',
              ),
            ),
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'ship_to_address_c',
            'studio' => 'visible',
            'label' => 'LBL_SHIP_TO_ADDRESS',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'primary_address_street',
            'hideLabel' => true,
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'id' => NULL,
              'key' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
              'is_hide_title' => true,
            ),
          ),
          1 => 
          array (

          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'custom_contact_id',
            'label' => 'LBL_CONTACT',
          ),
          1 => '',
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'custom_distribution_items_label_non_db',
            'studio' => 'visible',
          ),
          1 => array (
            'name' => 'sync_to_contact_distribution_items',
            'studio' => 'visible',
          )
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'custom_line_items_non_db',
            'customCode' => '
              <table id="tbl_line_items" class="list view table-responsive">
                <input type="hidden" id="site_colormatch_coordinator_id" value="">
                <input type="hidden" id="site_colormatch_coordinator_name" value="">
                <thead>
                  <tr>
                    
                    <th scope="col" style="width: 20%; text-align: center;">Distribution Item</th>
                    <th scope="col" style="width: 4%; text-align: center;">Qty</th>
                    <th scope="col" style="width: 4%; text-align: center;">UOM</th>
                    <th scope="col" style="width: 15%; text-align: center;">Delivery Method</th>
                    <th scope="col" style="width: 15%; text-align: center;">Additional Information</th>
                    <th scope="col" style="width: 15%; text-align: center;">Status</th>
                    <th scope="col" style="width: 15%; text-align: center;">Assigned To</th>
                    <th scope="col" style="width: 30%; text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            ',
          ),
        ),
      ),
    ),
  ),
);
;
?>
