<?php
// created: 2023-03-30 08:57:28
$viewdefs['Contacts']['QuickCreate'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'hidden' => 
      array (
        0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
        1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
        2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
        3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
        4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
        5 => '{if !empty($smarty.request.contact_id)}<input type="hidden" name="reports_to_id" value="{$smarty.request.contact_id}">{/if}',
        6 => '{if !empty($smarty.request.contact_name)}<input type="hidden" name="report_to_name" value="{$smarty.request.contact_name}">{/if}',
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
          'name' => 'first_name',
          'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
        ),
        1 => 
        array (
          'name' => 'account_name',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'last_name',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 
        array (
          'name' => 'phone_work',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'title',
        ),
        1 => 
        array (
          'name' => 'phone_mobile',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'phone_fax',
        ),
        1 => 
        array (
          'name' => 'do_not_call',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'birthdate',
          'comment' => 'The birthdate of the contact',
          'label' => 'LBL_BIRTHDATE',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_country',
          'comment' => 'Country for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
        ),
        1 => '',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_state',
          'comment' => 'State for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_STATE',
        ),
        1 => '',
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_city',
          'comment' => 'City for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_CITY',
        ),
        1 => '',
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_street',
          'comment' => 'Street address for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_STREET',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_postalcode',
          'comment' => 'Postal code for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
        ),
      ),
      10 => 
      array (
        0 => 
        array (
          'name' => 'email1',
        ),
        1 => 
        array (
          'name' => 'lead_source',
        ),
      ),
      11 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
        ),
      ),
    ),
  ),
);