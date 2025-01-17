<?php
$module_name = 'QCRM_Homepage';
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
          'CopyUsers' =>
          array (
            'customCode' => '{if $IS_ADMIN}<input type="button" class="button" onClick="$(\'#popupDiv_ara\').show()" value="{$MOD.LBL_COPY_USERS}">{/if}',
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
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
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
          0 => 'name',
          1 => 'assigned_user_name',
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'hidden',
            'studio' => 'visible',
            'label' => 'LBL_DISPLAYED_ICONS',
			'customCode' => '<input name="hidden"  id="hidden" size="25" type="hidden" value="{$fields.hidden.value}"><ul id="icons_ul">{$nohidden_list}</ul>',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'creates',
            'studio' => 'visible',
            'label' => 'LBL_CREATES',
			'customCode' => '<input name="creates"  id="creates" size="25" type="hidden" value="{$fields.creates.value}"><ul id="creates_ul">{$creates_list}</ul>',
          ),
        ),
      ),
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'charts',
            'studio' => 'visible',
            'label' => 'LBL_CHARTS',
			'customCode' => '<input name="charts"  id="charts" size="25" type="hidden" value="{$fields.charts.value}"><ul id="charts_ul">{$charts_list}</ul>',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'icons',
            'studio' => 'visible',
            'label' => 'LBL_ICONS',
			'customCode' => '<input name="icons"  id="icons" size="25" type="hidden" value="{$fields.icons.value}"><ul id="icons_ul">{$icons_list}</ul>',
          ),
          1 => 
          array (
            'name' => 'dashlets',
            'studio' => 'visible',
            'label' => 'LBL_DASHLETS',
			'customCode' => '<input name="dashlets"  id="dashlets" size="25" type="hidden" value="{$fields.dashlets.value}"><ul id="dashlets_ul">{$dashlets_list}</ul>',
          ),
        ),

        1 => 
        array (
          0 => 
          array (
            'name' => 'shared',
            'studio' => 'visible',
            'label' => '',
			'customLabel' => '<div style="clear:both"><div class="PublicSearch legend">{$public_label}</div><div class="PrivateSearch legend">{$private_label}</div></div>',
			'customCode' => '&nbsp;',
          ),
        ),
      ),
    ),
  ),
);
?>