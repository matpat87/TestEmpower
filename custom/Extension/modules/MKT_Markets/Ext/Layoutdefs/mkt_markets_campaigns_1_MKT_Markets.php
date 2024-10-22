<?php 

$layout_defs['MKT_Markets']['subpanel_setup']['campaigns_markets'] = array(
        'order'             => 100,
        'module'            => 'Campaigns', //I believe this is the name of Subpanel Module's directory
        'get_subpanel_data' => 'campaigns_markets', 
        'sort_order'        => 'asc',
        'sort_by'           => 'id',
        'subpanel_name'     => 'default',
        'title_key'         => 'LBL_MKT_MARKETS_CAMPAIGNS_1_FROM_CAMPAIGNS_TITLE',
        'top_buttons'       => array (
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
