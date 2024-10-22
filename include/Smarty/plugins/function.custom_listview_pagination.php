<?php

function smarty_function_custom_listview_pagination($params, &$smarty): string
{
    global $sugar_config;

    $moduleString = $params['moduleString'];
    $rowsPerPage = $sugar_config['list_max_entries_per_page'];
    $pageOffsets = generateOffset($params);
    $currentOffset = $params['pageDataOffsets']['current'];
    $currentKey = array_search($currentOffset, $pageOffsets);
    $numberOfPages = count($pageOffsets);
    $totalRecords = $params['pageDataOffsets']['total'];
    
    $jumpToPage = "<td nowrap='nowrap' width='1%' class='paginationActionButtons' align='right' style='vertical-align: top'>";
//    $jumpToPage .= "<div class='pageNumbers col-xs-12 col-sm-4'>";
    $jumpToPage .= "<div class='input-group input-group-sm'>";
    $jumpToPage .= "<input type='text' class='form-control' name='page_number' id='go_to_page' value='{$currentKey}' maxlength='255' style='width:6rem; text-align:center;' />";
    
    $jumpToPage .= "<input type='hidden' id='module_string' name='module_string' value='{$moduleString}' />";
    $jumpToPage .= "<input type='hidden' id='total_records' name='total_records' value='{$totalRecords}' />";
    $jumpToPage .= "<input type='hidden' id='records_per_page' name='records_per_page' value='{$rowsPerPage}' />";
    $jumpToPage .= "<span class='input-group-btn'>";
    $jumpToPage .= "<button type='button' id='go-to-page-btn' class='btn btn-danger' onclick='return handleGoToPage()' style='margin-left: auto;'>Go</span></button>";
    $jumpToPage .= "</span>";
    
    $jumpToPage .= "</div><h6 style='text-align:center;margin-top:1px !important;margin-bottom:0px !important'>Page {$currentKey} of {$numberOfPages} ({$totalRecords} Records)</h6></td>";
   
    return $jumpToPage;
}

function generateOffset(&$params): array {
    global $sugar_config, $log;
    
    $rowsPerPage = $sugar_config['list_max_entries_per_page'];
    $pageData = $params['pageDataOffsets'];
    $offsetCompute = $pageData['total'] / $rowsPerPage;
    
    $numberOfPages = ceil($offsetCompute);
    
    // create a loop to that stores a key-value array of page numbers and their respective offsets
    $pageDataOffsets = array();
    for ($i = 1; $i <= $numberOfPages; $i++) {
        // fibonacci sequence to calculate the offset
        $offset = $rowsPerPage * ($i - 1);
        $pageDataOffsets[$i] = $offset;
    }
    
    return $pageDataOffsets;
    
}