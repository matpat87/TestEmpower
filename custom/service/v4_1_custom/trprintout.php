<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
ini_set('memory_limit', '-1');

//usage - http://localhost:8080/empower/custom/service/v4_1_custom/trprintout.php

require_once('common.php');

$url =  base_url() . 'rest.php';

function restRequest($method, $arguments){
 global $url;
 $curl = curl_init($url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
 $post = array(
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

$userAuth = array(
    'user_name' => $_POST['username'],
    'password' => md5($_POST['password']),
);
$appName = 'SuiteCRM TR Printout Client';
$nameValueList = array();

$args = array(
            'user_auth' => $userAuth,
            'application_name' => $appName,
            'name_value_list' => $nameValueList);

$result = restRequest('login',$args);

if(isset($result['id']))
{
    $sessId = $result['id'];
    $entryArgs = array(
        'session' => $sessId,
        'product_id' => $_POST['product_id'],
    );
    $result = restRequest('tr_printout', $entryArgs);

    if(!empty($result))
    {
        chdir('../../..');
        require_once('custom/entrypoints/classes/TRPrintout.php');
        $trPrintout = new TRPrintout();
        $result_decoded = json_decode($result, true);
        $trPrintout->pdf_data = $result_decoded;
        $trPrintout->printPDF();   
    }
    else{
        die('Invalid Product ID');
    }
}
else{
    die('Invalid Login');
}



?>