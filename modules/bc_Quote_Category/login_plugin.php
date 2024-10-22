<?php

function validateLoginSubscription() {
    //load license validation config
    require_once('modules/bc_Quote_Category/license/OutfittersLicense.php');
    global $current_user;
    $user_id = $current_user->id;
    $checkLoginSubscription = OutfittersLicense::isValid('bc_Quote_Category', $user_id, true);
    $response = array();
    if ($checkLoginSubscription === true) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = html_entity_decode($checkLoginSubscription);
    }
    return $response;
}
