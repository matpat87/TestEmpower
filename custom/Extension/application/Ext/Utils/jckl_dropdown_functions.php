<?php
/**
 * User: Shad Mickelberry
 * Company: Jackal Software
 * Date: 2019-04-29
 * File Name: dropdown_functions.php
 */

function jcklAppendGetDashboards()
{

    require_once 'modules/jacka_DashboardAppend/jacka_DashboardAppend.php';
    $append = new jacka_DashboardAppend();

    $dropdown = $append->retrieveDashboardsEnum();

    return $dropdown;
}
