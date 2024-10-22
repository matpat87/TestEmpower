<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


global $app_strings;

$dashletMeta['bc_QuoteDashlet'] = array('module' => 'bc_Quote',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_Quote'),
    'description' => 'A customizable view into bc_Quote',
    'icon' => 'icon_bc_Quote_32.gif',
    'category' => 'Module Views');
