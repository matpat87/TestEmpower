<?php
    $module_name = 'jckl_DashboardDeployments';
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
                                            4 => array('customCode' => '<a class="button" href="index.php?module=jckl_DashboardDeployments&action=Restore&record={$fields.id.value}">{$MOD.LBL_RESTORE_DASHBOARD}</a>'),
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
                                    1 =>
                                        array (
                                            0 =>
                                                array (
                                                    'name' => 'copied_from_user',
                                                    'studio' => 'visible',
                                                    'label' => 'LBL_COPIED_FROM_USER',
                                                ),
                                            1 => '',
                                        ),
                                    2 =>
                                        array (
                                            0 => 'date_entered',
                                            1 => 'date_modified',
                                        ),
                                    3 =>
                                        array (
                                            0 => 'description',
                                            1 =>
                                                array (
                                                    'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_name',
                                                ),
                                        ),
                                ),
                        ),
                ),
        );
?>
