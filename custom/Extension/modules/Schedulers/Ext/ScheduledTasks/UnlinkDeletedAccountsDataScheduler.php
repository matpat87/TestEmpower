<?php  
  $job_strings[] = 'UnlinkDeletedAccountsDataScheduler';

  function UnlinkDeletedAccountsDataScheduler() {
    global $db, $log;
    
    $GLOBALS['log']->fatal("Soft Deleted accounts: Unlink relationships - START");

    // GET Accounts where deleted = 1
    // get account relationships: use get_linked_beans
    $accountBeans = BeanFactory::getBean('Accounts')->get_full_list("id" ,"accounts.deleted = 1", false, 1);
    $accountBean = BeanFactory::getBean('Accounts');
    
    $account_relationships = $accountBean->get_linked_fields(); // retrieve all relationships for Accounts
    
    foreach ($accountBeans as $account) {
        
        foreach($account_relationships as $relationship => $attributes) {
            if ($account->load_relationship($relationship)) {
                
                $items = $account->{$relationship}->get();

                if (is_array($items) && count($items) > 0) {

                  array_push($items, $relationship);
                  $account->{$relationship}->delete($account->id); // unlink all accounts of this ID in this $relationship
                }
            }
            
        }
       
    }

    $GLOBALS['log']->fatal("Soft Deleted accounts: Unlink relationships - END");
    
    return true;
    
  }