<?php

include_once('include/SugarPHPMailer.php');
include_once('include/utils/db_utils.php');

class MarketsHelper {

    public static function attachRecipients($moduleName, $moduleBean, $mail)
    {
        global $sugar_config, $app_list_strings, $log;
        $recipientBeans = array();

        switch ($moduleName) {
            case 'Opportunities':
                $accountID = 'account_id';
                $marketId = 'mkt_markets_opportunities_1mkt_markets_ida';
                break;
            case 'TR_TechnicalRequests':
                $accountID = 'tr_technicalrequests_accountsaccounts_ida';
                $marketId = 'mkt_markets_id_c';
                break;
            case 'CI_CustomerItems':
                $accountID = 'ci_customeritems_accountsaccounts_ida';
                $marketId = 'mkt_markets_ci_customeritems_1mkt_markets_ida';
                break;
            
        }

        $account = BeanFactory::getBean('Accounts', $moduleBean->$accountID);
        $marketBean = BeanFactory::getBean('MKT_Markets', $moduleBean->$marketId);
        
        if ($account) {
            // Salesperson assigned to the account related to the module
            $salesPersonBean = BeanFactory::getBean('Users', $account->assigned_user_id);
            $salesPerson = ($salesPersonBean) 
                ? array_push($recipientBeans, $salesPersonBean)
                : null;
            
            // Sales Manager - User Reports to value of the salesperson assigned to the account
            $salesMgrBean = $salesPersonBean ? BeanFactory::getBean('Users', $salesPersonBean->reports_to_id) : null;
            $salesMgr = ($salesMgrBean) 
                ? array_push($recipientBeans, $salesMgrBean)
                : null;
            
            // Sales VP - User Module.Reports To value of the sales manager of the salesperson assigned to the account
            $salesMgrVpBean = ($salesMgrBean) ? BeanFactory::getBean('Users', $salesMgrBean->reports_to_id) : null;
            $salesMgrVp = ($salesMgrVpBean)
                ? array_push($recipientBeans, $salesMgrVpBean)
                : null;
        }
        
        
        // Sales Controller - User Module Role = Sales Controller (Mark Heidelberger)
        $salesControllerBean = BeanFactory::getBean('Users')->retrieve_by_string_fields(
            [ 'division_c' => $marketBean->division, 'role_c' => 'SalesController' ],
            false,
            true
        );
        
        $salesController = ($salesControllerBean)
            ? array_push($recipientBeans, $salesControllerBean)
            : null;
        
        // Sales Controller - User Module Role = Sales Controller (Mark Heidelberger)
        $salesAdministratorBean = BeanFactory::getBean('Users')->retrieve_by_string_fields(
            [ 'division_c' => $marketBean->division, 'role_c' => 'SalesAdministrator' ],
            false,
            true
        );

        $salesAdmin = ($salesAdministratorBean)
            ? array_push($recipientBeans, $salesAdministratorBean)
            : null;
       
        
        // Attach email to $mail->AddAdress()
        foreach($recipientBeans as $user) {
            $mail->AddAddress($user->emailAddress->getPrimaryAddress($user), $user->name);
        }
        
    }

    
}