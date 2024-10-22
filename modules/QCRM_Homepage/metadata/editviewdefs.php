<?php
$module_name = 'QCRM_Homepage';
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
          'label' => '7',
          'field' => '33',
        ),
        1 => 
        array (
          'label' => '7',
          'field' => '33',
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
        'LBL_EDITVIEW_PANEL2' => 
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
      'syncDetailEditViews' => false,
      'form' => 
      array (
        'buttons' => 
        array (
          0 =>          
		  array (
			'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById(\'EditView\'); _form.action.value=\'Save\'; storeCreates(\'creates_ul\',\'creates\');storeCharts(\'charts_ul\',\'charts\');storeHidden(\'hidden_ul\',\'hidden\');storeSearches(\'icons_ul\',\'icons\');storeSearches(\'dashlets_ul\',\'dashlets\');if(check_form(\'EditView\'))SUGAR.ajaxUI.submitForm(_form);return false;" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE" type="submit">',
		  ),
          1 => 'CANCEL',
        ),
      'buttons_footer' =>
        array (
          0 =>          
		  array (
			'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById(\'EditView\'); _form.action.value=\'Save\'; storeCreates(\'creates_ul\',\'creates\');storeCharts(\'charts_ul\',\'charts\');storeHidden(\'hidden_ul\',\'hidden\');storeSearches(\'icons_ul\',\'icons\');storeSearches(\'dashlets_ul\',\'dashlets\');if(check_form(\'EditView\'))SUGAR.ajaxUI.submitForm(_form);return false;" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE" type="submit">',
		  ),
          1 => 'CANCEL',
        ),
      ),
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
            'customCode' => '<input name="hidden"  id="hidden" size="25" type="hidden" value="{$fields.hidden.value}"><ul class="ISortable" id="nohhiden_ul">{$nohidden_list}</ul><div style="float:left;">{$unused_label}<div><ul class="ISortable" id="hidden_ul">{$hidden_list}</ul></div></div>',
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
            'customCode' => '<input name="creates"  id="creates" size="25" type="hidden" value="{$fields.creates.value}"><ul class="Sortable" id="creates_ul">{$creates_list}</ul><div style="float:left;">{$unused_label}<div><ul class="Sortable" id="nocreates_ul">{$nocreates_list}</ul></div></div>',
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
            'customCode' => '<input name="charts"  id="charts" size="25" type="hidden" value="{$fields.charts.value}"><ul class="Sortable" id="charts_ul">{$charts_list}</ul><div style="float:left;">{$unused_label}<div><ul class="Sortable" id="nocharts_ul">{$nocharts_list}</ul></div></div>',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'dashlets',
            'studio' => 'visible',
            'label' => 'LBL_DASHLETS',
            'customCode' => '<div style="float:left;">{$icons_label}<div><input name="icons"  id="icons" size="25" type="hidden" value="{$fields.icons.value}"><ul class="connectedSortable" id="icons_ul">{$icons_list}</ul></div></div><div style="float:left;">{$dashlets_label}<div><input name="dashlets"  id="dashlets" size="25" type="hidden" value="{$fields.dashlets.value}"><ul class="connectedSortable" id="dashlets_ul">{$dashlets_list}</ul></div></div><div style="float:left;">{$unused_label}<div><ul class="connectedSortable" id="unused_ul">{$unused_list}</ul></div></div><div style="clear:both"><div class="PublicSearch legend">{$public_label}</div><div class="PrivateSearch legend">{$private_label}</div></div>',
          ),
        ),
      ),
    ),
  ),
);
?>