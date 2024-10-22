<?php
$module_name = 'Emails';
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
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          4 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=ReplyTo&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_REPLY_TITLE}">',
          ),
          5 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=ReplyToAll&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_REPLY_ALL}">',
          ),
          6 => 
          array (
            'customCode' => '<input type=button onclick="window.location.href=\'index.php?module=Emails&action=Forward&return_module=Emails&return_action=index&folder=INBOX.TestInbox&folder=inbound&inbound_email_record={$bean->inbound_email_record}&uid={$bean->uid}&msgno={$bean->msgno}&record={$bean->id}\';" value="{$MOD.LBL_BUTTON_FORWARD}">',
          ),
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
        'LBL_EMAIL_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_EMAIL_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'highlights_c',
            'label' => 'LBL_HIGHLIGHTS',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'opt_in',
            'label' => 'LBL_OPT_IN',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'from_addr_name',
            'label' => 'LBL_FROM',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'to_addrs_names',
            'label' => 'LBL_TO',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cc_addrs_names',
            'label' => 'LBL_CC',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'bcc_addrs_names',
            'label' => 'LBL_BCC',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'description_html',
            'label' => 'LBL_BODY',
          ),
        ),
        8 => 
        array (
          0 => 'parent_name',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'date_sent',
            'label' => 'LBL_DATE_SENT',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        11 => 
        array (
          0 => 'category_id',
        ),
      ),
    ),
  ),
);
;
?>
