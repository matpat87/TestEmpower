<?php
if(!defined('sugarEntry')){
  define('sugarEntry', true);
}
require_once 'service/v4_1/SugarWebServiceImplv4_1.php';
class SugarWebServiceImplv4_1_custom extends SugarWebServiceImplv4_1
{	
    function tr_printout($session_id, $product_id)
    {
        $result = null;
        global $log;

        require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
        require_once('custom/entrypoints/classes/TRPrintout.php');
        require_once('custom/modules/AOS_Products/helper/ProductHelper.php');

        try {
            if(!empty($product_id) && ProductHelper::is_id_exists($product_id))
            {
                $product_bean = BeanFactory::getBean('AOS_Products', $product_id);
                $product_bean->load_relationship('tr_technicalrequests_aos_products_2');
                $tr_beans = $product_bean->tr_technicalrequests_aos_products_2->getBeans();

                if(count($tr_beans) > 0){
                    $tr_bean = array_values($tr_beans)[0];
                    $trPrintout = new TRPrintout();
                    $trPrintout->technical_request_id = $tr_bean->id ;
                    $trPrintout->product_id = $product_id;
                    $trPrintout->process();
                    $result = json_encode($trPrintout->pdf_data);
                }
                else{
                    $log->fatal('SugarWebServiceImplv4_1_custom.tr_printout: Invalid Technical Request');
                }
            }
            else{
                $log->fatal('SugarWebServiceImplv4_1_custom.tr_printout: Invalid Product');
            }

            return $result;
        }
        catch (exception $e) {
            //code to handle the exception
            $log->fatal('Error in tr_printout. Details: ' . $e->getMessage());
        }
    
        return true;
    }

    /**
     * $user_credentials: {"user_name": "Test", "password": "TestPwd"}
     * $method: "update_record_bean"
     * $record_parameters: {
     *  "module": "TR_TechnicalRequests",
     *  "record_id": "c97d30e6-b53e-3839-20f5-6166d8e87197",
     *  "data": {
     *      "approval_stage": "closed_won",
     *      "status": "order_received"
     *  }
     * }
     * 
     * POST URL: <site_url>/custom/service/v4_1_custom/rest.php
     * JSON SAMPLE:
     * {
     *  "method": auth_with_record_update,
     *  "input_type": "JSON",
     *  "response_type": "JSON"
     *  "rest_data": {
     *   "user_credentials": {"user_name": "Test", "password": "TestPwd"},
     *   "method": "update_record_bean",
     *   "record_parameters": {
     *     "module": "TR_TechnicalRequests",
     *     "record_id": "c97d30e6-b53e-3839-20f5-6166d8e87197",
     *     "data": {
     *       "approval_stage": "closed_won",
     *       "status": "order_received"
     *   }
     *  }
     * }
     */

    // URL POST SAMPLE:
    // <site_url>/custom/service/v4_1_custom/rest.php?method=auth_with_record_update&input_type=JSON&response_type=JSON&rest_data={"user_credentials": {"user_name": "rsiasat", "password": "Welcome2018"}, "method": "update_record_bean", "record_parameters": { "module": "TR_TechnicalRequests", "record_id": "c97d30e6-b53e-3839-20f5-6166d8e87197", "data": { "approval_stage": "closed_won", "status": "order_received" }}}

    function auth_with_record_update($user_credentials, $method, $record_parameters)
    {
        global $log;

        try {
            if (! $user_credentials) {
                $log->fatal("SugarWebServiceImplv4_1_custom.auth_with_record_update: No user_credentials parameter provided");
                return "No user_credentials parameter provided";
            }
    
            if (! $method) {
                $log->fatal("SugarWebServiceImplv4_1_custom.auth_with_record_update: No method parameter provided");
                return "No method parameter provided";
            }
    
            if (! $record_parameters) {
                $log->fatal("SugarWebServiceImplv4_1_custom.auth_with_record_update: No record_parameters parameter provided");
                return "No record_parameters parameter provided";
            }
    
            $auth_args = [
                'user_auth' => [
                    'user_name' => $user_credentials['user_name'],
                    'password' => md5($user_credentials['password']),
                ]
            ];
    
            $login_result = self::restRequest('login', $auth_args);
            $session_id = (isset($login_result['id']) && $login_result['id']) ? $login_result['id'] : '';
            
            if (! $session_id) {
                $log->fatal("SugarWebServiceImplv4_1_custom.auth_with_record_update: Authentication Failed!");
                return "Authentication Failed!";
            }
    
            $record_parameters['logged_user_id'] = $login_result['name_value_list']['user_id']['value'];
    
            $formattedParameters['session_id'] = $session_id;
            $formattedParameters['record_parameters'] = $record_parameters;
            
            self::restRequest($method, $formattedParameters);
        } catch (exception $e) {
            $log->fatal("ERROR SugarWebServiceImplv4_1_custom.auth_with_record_update: {$e->getMessage()}");
        }
    }

    function update_record_bean($session_id, $record_parameters)
    {
        global $log, $current_user;

        try {
            if (! isset($record_parameters['module'])) {
                $log->fatal("SugarWebServiceImplv4_1_custom.update_record_bean: 'module' parameter does not exist!");
                return "'module' parameter does not exist!";
            }
    
            if (! isset($record_parameters['record_id'])) {
                $log->fatal("SugarWebServiceImplv4_1_custom.update_record_bean: 'record_id' parameter does not exist!");
                return "'record_id' parameter does not exist!";
            }
    
            if (! isset($record_parameters['data'])) {
                $log->fatal("SugarWebServiceImplv4_1_custom.update_record_bean: 'data' parameter does not exist!");
                return "'data' parameter does not exist!";
            }
            
            $bean = BeanFactory::getBean($record_parameters['module'], $record_parameters['record_id']);
    
            if (! $bean->id) {
                $log->fatal("SugarWebServiceImplv4_1_custom.update_record_bean: Record does not exist!");
                return "Record does not exist!";
            }
    
            if (isset($record_parameters['data']) && count($record_parameters['data']) > 0) {
                $current_user = new User();
                $current_user->retrieve($record_parameters['logged_user_id']);
                $bean_updated = false;

                foreach ($record_parameters['data'] as $key => $value) {
                    if ($bean->$key !== $value) {
                        $bean->$key = $value;
                        $bean_updated = true;
                    }
                }
    
                if ($bean_updated) {
                    $_REQUEST['action'] = 'Save'; // Default action is DetailView, need to change to Save to fit overall business logic requirements
                    $bean->save();
                    $log->fatal("SugarWebServiceImplv4_1_custom.update_record_bean: [{$record_parameters['module']}][{$record_parameters['record_id']}]: Record Successfully Updated by {$current_user->name}");
                    echo "Record has been updated!";
                }
            }
    
            self::restRequest('logout', $session_id);
        } catch (exception $e) {
            $log->fatal("ERROR SugarWebServiceImplv4_1_custom.update_record_bean: {$e->getMessage()}");
        }
    }

    private function restRequest($method, $arguments)
    {
        global $sugar_config, $log;
        
        $url =  "{$sugar_config['site_url']}/custom/service/v4_1_custom/rest.php";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $post = array (
            "method" => $method,
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => json_encode($arguments),
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result,1);
    }
}