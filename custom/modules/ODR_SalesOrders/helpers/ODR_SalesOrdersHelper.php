<?php

class ODR_SalesOrdersHelper
{
    public static function checkOrderNumber($number)
    {
        $db =  DBManagerFactory::getInstance();

        $check = $db->fetchOne("SELECT 1 as is_exists FROM odr_salesorders WHERE odr_salesorders.number = 'SO-{$number}'");

        return (isset($check['is_exists']) && $check['is_exists'] == 1);

    }
}