<?php
$module_name = 'DSBTN_Distribution';
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
          1 =>
            //Colormatch 185, Colormatch 
            array (
            'customCode' => '<form action="index.php?module=DSBTN_Distribution&action=EditView&return_module=DSBTN_Distribution&return_action=DetailView" method="POST" name="CustomForm" id="form">
                <input type="hidden" name="is_copy_full" id="is_copy_full" value="true">
                <input type="hidden" name="distribution_id" id="distribution_id" value="{$DISTRIBUTION_ID}">
                <input type="submit" name="duplicate" id="duplicate" title="Copy" class="button" value="Copy">
                </form>',
            ),
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
            'name' => 'custom_overview_label_non_db',
            'label' => 'LBL_OVERVIEW',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'distribution_number_c',
            'label' => 'LBL_DISTRIBUTION_NUMBER',
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
          ),
          1 => 'date_entered',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'custom_recipient_information_label_non_db',
            'label' => 'LBL_RECIPIENT_INFORMATION',
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
          1 => array(),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'contact_c',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
          ),
          1 => array(),
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
            'label' => 'LBL_PRIMARY_ADDRESS',
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'key' => 'primary',
            ),
          ),
          1 => 
          array (
            // 'name' => 'alt_address_street',
            // 'label' => 'LBL_ALTERNATE_ADDRESS',
            // 'type' => 'DropdownCountryAddress',
            // 'displayParams' => 
            // array (
            //   'key' => 'alt',
            // ),
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'custom_distribution_items_label_non_db',
            'studio' => 'visible',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'custom_line_items_non_db',
            'label' => 'LBL_LINE_ITEMS',
            'customCode' => '
              <table id="tbl_line_items" class="view table-responsive">
                <thead>
                  <tr>
                  <th scope="col" style="width: 20%; text-align: center;">Distribution Item</th>
                    <th scope="col" style="width: 4%; text-align: center;">Qty</th>
                    <th scope="col" style="width: 4%; text-align: center;">UOM</th>
                    <th scope="col" style="width: 15%; text-align: center;">Delivery Method</th>
                    <th scope="col" style="width: 15%; text-align: center;">Additional Information</th>
                    <th scope="col" style="width: 15%; text-align: center;">Status</th>
                    <th scope="col" style="width: 15%; text-align: center;">Assigned To</th>
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
