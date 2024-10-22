<?php

global $sugar_config;

// Checking reCAPTCHA

$recaptcha_site_secret = $sugar_config['reCaptchaSecretKey'];

if (isset($_POST) && !empty($_POST)) {

$captcha_response = htmlspecialchars($_POST['g-recaptcha-response']);
$curl = curl_init();
$captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";

        curl_setopt($curl, CURLOPT_URL,$captcha_verify_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=".$recaptcha_site_secret."&response=".$captcha_response);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $captcha_output = curl_exec ($curl);
        curl_close ($curl);

        $decoded_captcha = json_decode($captcha_output);
        $captcha_status = $decoded_captcha->success; 
        if($captcha_status === FALSE){
              //Landing page for when the Captcha fails
              header("Location: " . $captcha_verify_url);
              exit();
        }
}
?>