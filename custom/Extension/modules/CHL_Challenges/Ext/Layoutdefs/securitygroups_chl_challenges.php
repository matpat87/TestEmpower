<?php
    //OnTrack #1056
    $layout_defs["CHL_Challenges"]["subpanel_setup"]['securitygroups_chl_challenges'] = array (
        'order' => 100,
        'module' => 'SecurityGroups',
        'subpanel_name' => 'default',
        'sort_order' => 'asc',
        'sort_by' => 'id',
        'title_key' => 'LBL_SECUIRTYGROUPS_CHL_CHALLENGES_TITLE',
        'get_subpanel_data' => 'SecurityGroups',
        'top_buttons' => 
        array (
          0 => 
          array (
            'widget_class' => 'SubPanelTopButtonQuickCreate',
          ),
          1 => 
          array (
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
          ),
        ),
    );
?>