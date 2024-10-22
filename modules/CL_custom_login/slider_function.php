<?php

function getSliderConfiguration() {
    $administrationObj = new Administration();
    $administrationObj->retrieveSettings('image_slider_conf');
    $image_count = $administrationObj->settings['image_slider_conf_image_count'];
    return $image_count;
}

function getImageListConfiguration() {
    $administrationObj = new Administration();
    $administrationObj->retrieveSettings('upload_image_list');
    if (isset($administrationObj->settings['upload_image_list_imagelist_count'])) {
        $imagelist_count = $administrationObj->settings['upload_image_list_imagelist_count'];
    }
    return $imagelist_count;
}

function getCurrentThemeAndCompanyLogoDetails() {
    $currentThemeAndLogoDetailsArray = array();
    $themeObject = SugarThemeRegistry::current();
    $companyLogoURL = $themeObject->getImageURL('company_logo.png');
    $company_logo_attributes = sugar_cache_retrieve('company_logo_attributes');
    $currentThemeAndLogoDetailsArray['theme_name'] = $themeObject->name;
    $currentThemeAndLogoDetailsArray['theme_dirName'] = $themeObject->dirName;
    $currentThemeAndLogoDetailsArray['logo_url'] = $companyLogoURL;
    $currentThemeAndLogoDetailsArray['logo_width'] = $company_logo_attributes[1];
    $currentThemeAndLogoDetailsArray['logo_height'] = $company_logo_attributes[2];

    return $currentThemeAndLogoDetailsArray;
}

function getImagesFromUpload($folder) {
    global $sugar_config, $db;
    $custom_query = "select id,image_type from cl_custom_login where deleted=0 order by date_modified";
    $custom_result = $db->query($custom_query);
    $image_ids = array();
    while ($rows = $db->fetchByAssoc($custom_result)) {
        array_push($image_ids, $folder . $rows['id'] . '.' . $rows['image_type']);
    }
    return $image_ids;
}

function getConvertedUploadImageSizeInMB($size) {
    $imageSize = round($size / pow(1024, 2));
    return $imageSize;
}

function sortingGetBeansArrayData($dataArray, $sort_field, $sort_order) {
    $returnData = array();
    $sortDataArray = array();
    foreach ($dataArray as $qid => $qDetails) {
        $returnData[$qid] = $qDetails->$sort_field;
    }
    if ($sort_order == 'asc' || $sort_order == 'ASC') {
        asort($returnData);
    }
    if ($sort_order == 'desc' || $sort_order == 'DESC') {
        arsort($returnData);
    }
    foreach ($returnData as $sortQID => $value) {
        $sortDataArray[$sortQID] = $dataArray[$sortQID];
    }
    return $sortDataArray;
}
