<?php
    use Carbon\Carbon;

    class MapMarkersHelper
    {
        /* For Ontrack #1861: to add custom columns on Maps Data table for Accounts only */
        public static function handleMapMarkersForAccounts($module, $mapMarkers =[])
        {
            global $log, $db;

            if (empty($module) || empty($mapMarkers || $module != 'Accounts')) {
                return null;
            }

            foreach ($mapMarkers as $marker) {
                $accountBean = BeanFactory::getBean('Accounts', $marker['id']);

            }

            // Updates the markers array and add the custom column data for Accounts only
            $mapMarkers = array_map(function($marker) {
                $accountBean = BeanFactory::getBean('Accounts', $marker['id']);
                $marker['custom_acct_last_activity_date'] = Carbon::parse($accountBean->last_activity_date_c)->format('Y-m-d');
                $marker['custom_acct_ytd_sales'] = (!empty($accountBean->sls_ytd_c)) ? NumberHelper::GetCurrencyValue($accountBean->sls_ytd_c) : '0.00';

                return $marker;
                
            }, $mapMarkers);
            
            return $mapMarkers;
            
        }

    } // End of Class

