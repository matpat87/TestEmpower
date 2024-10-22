<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Accounts&action=UpdateCountryStateCodes
updateCountryStateCodes();

function updateCountryStateCodes()
{
	global $db;

    $str = file_get_contents('custom/include/json/complete_country_list.json');
    $json = json_decode($str, true); // decode the JSON into an associative array

    $countriesCodesArray = [];

    foreach ($json as $key => $value) {
        if (strtolower($value['type']) == 'country') {
            $value['code'] ? array_push($countriesCodesArray, $value['code']) : '';
        }
    }

    $accountBean = BeanFactory::getBean('Accounts');

    $updateBillingUSACountries = "UPDATE accounts SET billing_address_country = 'US' WHERE billing_address_country = 'USA'";
    $updateBillingMEXCountries = "UPDATE accounts SET billing_address_country = 'MX' WHERE billing_address_country = 'MEX'";
    $updateBillingCANCountries = "UPDATE accounts SET billing_address_country = 'CA' WHERE billing_address_country = 'CAN'";

    $updateShippingUSACountries = "UPDATE accounts SET shipping_address_country = 'US' WHERE shipping_address_country = 'USA'";
    $updateShippingMEXCountries = "UPDATE accounts SET shipping_address_country = 'MX' WHERE shipping_address_country = 'MEX'";
    $updateShippingCANCountries = "UPDATE accounts SET shipping_address_country = 'CA' WHERE shipping_address_country = 'CAN'";

    $db->query($updateBillingUSACountries);
    $db->query($updateBillingMEXCountries);
    $db->query($updateBillingCANCountries);
    $db->query($updateShippingUSACountries);
    $db->query($updateShippingMEXCountries);
    $db->query($updateShippingCANCountries);

    echo '<br>';
    echo $updateBillingUSACountries;
    echo '<br>';

    echo '<br>';
    echo $updateBillingMEXCountries;
    echo '<br>';

    echo '<br>';
    echo $updateBillingCANCountries;
    echo '<br>';

    echo '<br>';
    echo $updateShippingUSACountries;
    echo '<br>';

    echo '<br>';
    echo $updateShippingMEXCountries;
    echo '<br>';

    echo '<br>';
    echo $updateShippingCANCountries;
    echo '<br>';

    foreach ($countriesCodesArray as $countryCode) {
        $accountBillingIdsArray = [];
        $accountShippingIdsArray = [];
        $accountBillingBeans = $accountBean->get_full_list('name', "accounts.billing_address_country = '{$countryCode}'", false, 0);
        $accountShippingBeans = $accountBean->get_full_list('name', "accounts.shipping_address_country = '{$countryCode}'", false, 0);

        $jsonCountryCodeKey = array_search($countryCode, array_column($json, 'country_code'));
        $jsonCountryCodeThreeKey = array_search($countryCode, array_column($json, 'country_code_3'));

        if ($jsonCountryCodeKey && ! $jsonCountryCodeThreeKey) {
            $countryStateCode = $json[$jsonCountryCodeKey]['country_code'];
        } else if (! $jsonCountryCodeKey && $jsonCountryCodeThreeKey) {
            $countryStateCode = $json[$jsonCountryCodeThreeKey]['country_code'];
        } else {
            continue;
        }
        
        if ($accountBillingBeans) {
            foreach($accountBillingBeans as $bean) {
                if ($bean->billing_address_state) {
                    $billingStateCodeKey = array_search("{$bean->billing_address_country}-{$bean->billing_address_state}", array_column($json, '3166_code'));

                    if ($billingStateCodeKey) {
                        $billingStateValue = $json[$billingStateCodeKey]['3166_code'];
                    }

                    if ($billingStateValue) {
                        $updateBillingStateQuery = "UPDATE accounts 
                        SET accounts.billing_address_state = '{$billingStateValue}' 
                        WHERE accounts.id = '{$bean->id}'";

                        echo '<br>';
                        echo $updateBillingStateQuery;
                        echo '<br>';

                        $db->query($updateBillingStateQuery);
                    }
                }   
            }
        }
        
        if ($accountShippingBeans) {
            foreach($accountShippingBeans as $bean) {
                if ($bean->shipping_address_state) {
                    $shippingStateCodeKey = array_search("{$bean->shipping_address_country}-{$bean->shipping_address_state}", array_column($json, '3166_code'));

                    if ($shippingStateCodeKey) {
                        $shippingStateValue = $json[$shippingStateCodeKey]['3166_code'];
                    }

                    if ($shippingStateValue) {
                        $updateShippingStateQuery = "UPDATE accounts 
                        SET accounts.shipping_address_state = '{$shippingStateValue}' 
                        WHERE accounts.id = '{$bean->id}'";

                        echo '<br>';
                        echo $updateShippingStateQuery;
                        echo '<br>';

                        $db->query($updateShippingStateQuery);
                    }
                }   
            }
        }
    }
}
