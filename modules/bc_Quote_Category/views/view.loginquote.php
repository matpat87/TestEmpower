
<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
require_once('include/MVC/View/SugarView.php');

class bc_Quote_CategoryViewLoginquote extends SugarView {

    public function bc_Quote_CategoryViewLoginquote() {
        parent::SugarView();
    }

    function display() {
        //-----------------------checking sugar and include js if required----------------------------
        require_once 'modules/CL_custom_login/slider_function.php';
        global $current_user;
        if ($current_user->getPreference('suitecrm_version') != '') {
            $is_sugar = $current_user->getPreference('suitecrm_version');
        } else {
            $is_sugar = '';
            echo "<script src='modules/CL_custom_login/loginSlider/js/jquery.js'></script>";
        }
        //------------------------checking licence configuration status------------------------------
        require_once('modules/bc_Quote_Category/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (!$checkLoginSubscription['success']) {
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkLoginSubscription['message'] . '</div>';
            }
        } else { //--------- module enabled--------
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #f11147;font-size: 14px;left: 0;text-align: center;top: 50%;">' . $checkLoginSubscription['message'] . '</div>';
            }

            $html = "";
            global $db, $current_user, $sugar_config;
            $quote_id = isset($_REQUEST['qid']) ? $_REQUEST['qid'] : '';
            $quote = isset($_REQUEST['quote']) ? $_REQUEST['quote'] : '';
            $page = (int) isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
            echo "<script src='modules/bc_Quote_Category/js/quote.js'></script>";
            $current_theme = $current_user->getPreference('user_theme');
            $current_subTheme = $current_user->getPreference('subtheme');
            $random_num = mt_rand();
            $file = "custom/themes/{$current_theme}/css/quote.css";
            if (isset($sugar_config['suitecrm_version']) && $sugar_config['suitecrm_version'] != '') {
                if (file_exists($file)) {
                    echo "<link href='{$file}?{$random_num}' rel='stylesheet'>";
                } else {
                    echo "<link href='custom/themes/SuiteR/css/quote.css?{$random_num}' rel='stylesheet'>";
                }
                if($current_theme == "SuiteP"){
                    if($current_subTheme == "Night"){
                        $file = "custom/themes/{$current_theme}/css/quoteNight.css";
                         echo "<link href='{$file}?{$random_num}' rel='stylesheet'>";
                    }
                }
            } else {
                echo "<link href='modules/bc_Quote_Category/css/quote.css' rel='stylesheet'>";
            }

            global $db;

            echo "<label  id='hidden' style='display:none;'>$quote_id</label>";
            $html.="<p align='center'><b><label id='lbl_quote_msg' style='color:green; font-size:14px; display:none;'>";
            if ($_REQUEST['msg'] == 1) {
                $html.="<script>$('#lbl_quote_msg').show();</script>Updated successfully";
            }
            $html.= "</label></b></p>"
                    . "";
            $bc_quotes = new bc_Quote_Category();
            $bc_quotes_result = $bc_quotes->get_list("", "");
            $bc_quotes->retrieve($quote_id);
            $selected_cat_name = $bc_quotes->name;
            $lable_as_adminBased = return_module_language('en_us', 'Administration');
            $html.="<br/><h2 id='header_main'>{$lable_as_adminBased['LBL_QUOTE']}</h2><br/>";
            $html.="<button id='add' class='button button-small'  onclick='location.assign(\"index.php?module=bc_Quote_Category&action=loginquotecategory\")'>Manage Quote Category</button>";
            //////////////////////////////////////////////////////////////////////////////////////////QUOTE/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $html.="<div id='quote'><div>"
                    . "<div style='border:1px solid #d6d6d6; padding:10px; width:1000px;'>"
                    . "<table id='tab' style='border-radius:10px;' ><tr><th>Add New Quote<br/></th><th colspan=2></th></tr><tr><td><br/></td></tr>"
                    . "<tr><td>Quote Category : </td>";
            $html.="<td><select id='category_list'  onchange='get_category_list(0)'><option value='0'>----Select Quote Category----</option>";
            //-----------------------------------------dropdown---------------------------------------------
            $bc_quotes_result['list'] = sortingGetBeansArrayData($bc_quotes_result['list'], 'name', 'asc');
            foreach ($bc_quotes_result['list'] as $key => $value) {
                $html.="<option value='{$value->id}'>" . $value->name . "</option>";
            }
            $html.="</select>&nbsp;<label id='lbl_hidden_select'></label></h3></td><td><h3></td></tr>";
            $html.="<tr id='new_quote_row'><td>New Quote : </td><td><textarea id='new_quote' style='width:550px; height:80px;' placeholder='Quote'></textarea></td><td><h3><label id='lbl_newquote_hidden'></label></h3></td></tr>"
                    . "</table></div></div>"
                    . "<br/><br/><span id='buttons'><input id='save_quote_button' type='button' value='Save' onclick='savenewquote()'/></span>"
                    . "&nbsp;<input type='button' name='clear' onclick='cancel(\"$quote_id\")' value='Clear'/><br/><br/>";

            $html.="<div id='data'>";

            if ($quote != '') {
                echo "<script> location.assign('index.php?module=bc_Quote_Category&action=loginquote&qid=$quote_id');</script>";
            }
            if (!empty($quote_id) || sizeof($quote_id, 36)) {
                $count = 0;

                foreach ($bc_quotes_result['list'] as $key => $value) {
                    if ($quote_id == $value->id) {
                        $bc_quotes->retrieve($value->id);
                        $bc_quotes->load_relationship('bc_quote_category_bc_quote');
                        foreach ($bc_quotes->bc_quote_category_bc_quote->getBeans() as $contact) {
                            $count++;
                        }
                    }
                }
                if ($page < 1 && $count != 0) {
                    $page = 1;
                }
                //check for page number and available quote
                $resultsPerPage = 10;
                $startResults = ($page - 1) * $resultsPerPage;
                $numberOfRows = $count;
                $totalPages = ceil($numberOfRows / $resultsPerPage);
                $start = ($page * $resultsPerPage - $resultsPerPage) + 1;
                $end = $page * $resultsPerPage;
                if ($count != 0) {
                    $html.="<div style='padding:10px; background-color:#f8f8f8; width:1000px; border:1px solid #d8d8d8;' >"
                            . "<table  style='border-radius:10px; width:100%;'  id='dis'><tr style='background-color:#0034567; color:#445; font-size:16px;'>"
                            . "<th colspan='2'>$selected_cat_name  Quotes</th></tr><tr><td colspan='2'><br/></td></tr>";
                }
                //------------------------------display quotes------------------------------------------------------------------------------
                //------------------------------display quotes------------------------------------------------------------------------------
                if (count($bc_quotes_result['list']) != 0) {
                    foreach ($bc_quotes_result['list'] as $key => $value) {
                        if ($quote_id == $value->id) {
                            $bc_quotes->retrieve($value->id);
                            $bc_quotes->load_relationship('bc_quote_category_bc_quote');
                            $bc_quotes_data = $bc_quotes->bc_quote_category_bc_quote->getBeans(array('offset' => $startResults, 'limit' => $resultsPerPage));
                            $bc_quotes_data = sortingGetBeansArrayData($bc_quotes_data, 'description', 'asc');
                            foreach ($bc_quotes_data as $contact) {
                                $list[$contact->description] = $contact->description;
                                $list[$contact->bc_quote_category_bc_quotebc_quote_category_ida] = $contact->bc_quote_category_bc_quotebc_quote_category_ida;

                                $html.= "<tr id='aa' style='text-align:left;'><td width='80px'><a href='javascript:void(0)' onclick=\"delete_quote('$contact->id')\">"
                                        . "<img id='im' src='modules/bc_Quote_Category/images/quote/icon_Delete.gif' height='15px' width='15px'/></a> "
                                        . "&nbsp;&nbsp;<a href='javascript:void(0)'   onclick=\" show_edit_table('$contact->id'),set_edit_value('$contact->id','$contact->description')\">"
                                        . "<img id='im' src='modules/bc_Quote_Category/images/quote/edit.png' height='15px' width='15px'/></a>"
                                        . "</td><td width='1500px' ><span name='$contact->id'>" . nl2br($contact->description) . "</span></td></tr>";
                            }
                        }
                    }
                }
                //////////////////////////////////paging display////////////////////////////////////////////////
                $html.= '<tr><td align="center" class="custom-pagination" colspan="2">';
                //---------------next page--------------
                if ($numberOfRows > 10) {
                    if ($page > 1)
                        $html.= '<a  href="index.php?module=bc_Quote_Category&action=loginquote&qid=' . $quote_id . '&page=' . ($page - 1) . '"><img src="modules/bc_Quote_Category/images/quote/prev.png" width="20px" height="20px" style="margin-bottom:-5px"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) //-----------current page--------------
                            $html.= '<strong style="font-size:13px;">' . $i . '</strong>&nbsp;&nbsp;&nbsp;';
                        else // ----------------other page--------------
                            $html.= '<strong style="text-decoration:underline;">'
                                    . '<a href="index.php?module=bc_Quote_Category&action=loginquote&qid=' . $quote_id . '&page=' . $i . '">' . $i . '</a></strong>&nbsp;&nbsp;&nbsp;';
                    }
                    $html.= '&nbsp;&nbsp;';
                    //-------------prev page----------------
                    if ($page >= 1 && $page != $totalPages)
                        $html.= '<a href="index.php?module=bc_Quote_Category&action=loginquote&qid=' . $quote_id . '&page=' . ($page + 1) . '"><img src="modules/bc_Quote_Category/images/quote/next.png" width="20px" height="20px" style="margin-bottom:-5px"/></a>&nbsp</td>';
                    $html.= '&nbsp;&nbsp;';
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////
                $html.="</td></tr>";
            }
            $html.="</table>";
            $html.="<br/><button name='backtoadmin' class='button button-small' onclick='backtoadmin()'>Return to Admin</button></div>";
            $html.="</div></div>";
        }
        echo $html;


        parent::display();
    }

}

?>
