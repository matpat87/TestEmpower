<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Contacts&action=UpdateCountryStateCodes
updateCountryStateCodes();

function updateCountryStateCodes()
{
	global $db, $log;

    $str = file_get_contents('custom/include/json/complete_country_list.json');
    $json = json_decode($str, true); // decode the JSON into an associative array
    
    $countriesCodesArray = [];

    foreach ($json as $key => $value) {
        if (strtolower($value['type']) == 'country') {
            $value['code'] ? array_push($countriesCodesArray, $value['code']) : '';
        }
    }
    // $log->fatal(print_r($countriesCodesArray, true));
    $contactsBean = BeanFactory::getBean('Contacts');

    $updateBillingUSACountries = "UPDATE contacts SET primary_address_country = 'US' WHERE primary_address_country = 'USA' OR primary_address_country = 'United States of America'";
    $updateBillingMEXCountries = "UPDATE contacts SET primary_address_country = 'MX' WHERE primary_address_country = 'MEX'";
    $updateBillingCANCountries = "UPDATE contacts SET primary_address_country = 'CA' WHERE primary_address_country = 'CAN'";

    $updateShippingUSACountries = "UPDATE contacts SET alt_address_country = 'US' WHERE alt_address_country = 'USA' OR alt_address_country = 'United States of America'";
    $updateShippingMEXCountries = "UPDATE contacts SET alt_address_country = 'MX' WHERE alt_address_country = 'MEX'";
    $updateShippingCANCountries = "UPDATE contacts SET alt_address_country = 'CA' WHERE alt_address_country = 'CAN'";

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
        $contactsPrimaryBeans = $contactsBean->get_full_list('name', "contacts.primary_address_country = '{$countryCode}'", false, 0);
        $contactsAltBeans = $contactsBean->get_full_list('name', "contacts.alt_address_country = '{$countryCode}'", false, 0);
       
        $jsonCountryCodeKey = array_search($countryCode, array_column($json, 'country_code'));
        $jsonCountryCodeThreeKey = array_search($countryCode, array_column($json, 'country_code_3'));

        if ($jsonCountryCodeKey && ! $jsonCountryCodeThreeKey) {
            $countryStateCode = $json[$jsonCountryCodeKey]['country_code'];
        } else if (! $jsonCountryCodeKey && $jsonCountryCodeThreeKey) {
            $countryStateCode = $json[$jsonCountryCodeThreeKey]['country_code'];
        } else {
            continue;
        }
        
        if ($contactsPrimaryBeans) {
      
            foreach($contactsPrimaryBeans as $bean) {
                if ($bean->primary_address_state) {
                    $billingStateCodeKey = array_search("{$bean->primary_address_country}-{$bean->primary_address_state}", array_column($json, '3166_code'));
                    
                    if ($billingStateCodeKey) {
                        $primaryStateValue = $json[$billingStateCodeKey]['3166_code'];
                    }

                    if ($primaryStateValue) {
                        $updatePrimaryStateQuery = "UPDATE contacts 
                        SET contacts.primary_address_state = '{$primaryStateValue}' 
                        WHERE contacts.id = '{$bean->id}'";

                        echo '<br>';
                        echo $updatePrimaryStateQuery;
                        echo '<br>';

                        $db->query($updatePrimaryStateQuery);
                    }
                }   
            }
        }
        
        if ($contactsAltBeans) {
            foreach($contactsAltBeans as $bean) {
                if ($bean->alt_address_state) {
                    $altStateCodeKey = array_search("{$bean->alt_address_country}-{$bean->alt_address_state}", array_column($json, '3166_code'));

                    if ($altStateCodeKey) {
                        $altStateValue = $json[$altStateCodeKey]['3166_code'];
                    }

                    if ($altStateValue) {
                        $updateShippingStateQuery = "UPDATE contacts 
                        SET contacts.alt_address_state = '{$altStateValue}' 
                        WHERE contacts.id = '{$bean->id}'";

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
