<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


global $app_strings;

$dashletMeta['bc_Quote_CategoryDashlet'] = array('module' => 'bc_Quote_Category',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_Quote_Category'),
    'description' => 'A customizable view into bc_Quote_Category',
    'icon' => 'icon_bc_Quote_Category_32.gif',
    'category' => 'Module Views');
