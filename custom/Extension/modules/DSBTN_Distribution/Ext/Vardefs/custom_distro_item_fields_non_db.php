<?php

$dictionary['DSBTN_Distribution']['fields']['distro_item_non_db']= array(
        'name' => 'distro_item_non_db',
        'vname' => 'LBL_DISTRO_ITEM',
        'type' => 'enum',
        'options' => 'distro_item_list',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '0',
);

$dictionary['DSBTN_Distribution']['fields']['distro_item_qty_non_db']= array(
        'name' => 'distro_item_qty_non_db',
        'vname' => 'LBL_DISTRO_ITEM_QTY',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '0',
);

$dictionary['DSBTN_Distribution']['fields']['distro_item_delivery_method_non_db']= array(
        'name' => 'distro_item_delivery_method_non_db',
        'vname' => 'LBL_DISTRO_ITEM_DELIVERY_METHOD',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '0',
);

$dictionary['DSBTN_Distribution']['fields']['distro_item_status_non_db']= array(
        'name' => 'distro_item_status_non_db',
        'vname' => 'LBL_DISTRO_ITEM_STATUS',
        'type' => 'enum',
        'options' => 'distribution_item_status_list',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '1',
);

$dictionary['DSBTN_Distribution']['fields']['distro_item_assigned_to_id_non_db']= array(
        'name' => 'distro_item_assigned_to_id_non_db',
        'vname' => 'LBL_DISTRO_ITEM_ASSIGNED_TO',
        'group' => 'assigned_user_name',
        'type' => 'relate',
        'table' => 'users',
        'module' => 'Users',
        'len' => '255',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '1',
);

$dictionary['DSBTN_Distribution']['fields']['distro_item_id_non_db']= array(
        'name' => 'distro_item_id_non_db',
        'vname' => 'LBL_DISTRO_ITEM_ID',
        'type' => 'varchar',
        'source' => 'non-db',
        'inline_edit' => '0',
        'massupdate' => '0',
);

?>