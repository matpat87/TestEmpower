<?php

// created: 2015-09-03 09:46:28
$layout_defs["bc_Quote_Category"]["subpanel_setup"]['bc_quote_category_bc_quote'] = array(
    'order' => 100,
    'module' => 'bc_Quote',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_BC_QUOTE_CATEGORY_BC_QUOTE_FROM_BC_QUOTE_TITLE',
    'get_subpanel_data' => 'bc_quote_category_bc_quote',
    'top_buttons' =>
    array(
        0 =>
        array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 =>
        array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);
