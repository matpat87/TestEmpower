<?php
    $layout_defs['ProspectLists']['subpanel_setup']['contacts']['top_buttons'] = array (
        0 => array (
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array (
            'widget_class' => 'SubPanelTopSelectWithFilterButton',
            'mode' => 'MultiSelect',
            'initial_filter_fields' => array('status_c_advanced[]' => 'Active', 'account_status_non_db_advanced[]' => 'Active', 'email_opt_out_advanced' => '0')
        ),
    );
?>