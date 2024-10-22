<?php

$dictionary['bc_Quote_Category'] = array(
    'table' => 'bc_Quote_Category',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('bc_Quote_Category', 'bc_Quote_Category', array('basic', 'assignable'));
