
<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
require_once('include/MVC/View/SugarView.php');

class bc_Quote_CategoryViewLoginquotecategory extends SugarView {

    public function bc_Quote_CategoryViewLoginquotecategory() {
        parent::SugarView();
    }

    function display() {
        //-----------------------checking sugar and include js if required----------------------------
        global $current_user, $sugar_config;
        if ($current_user->getPreference('suitecrm_version') != '') {
            $is_sugar = $current_user->getPreference('suitecrm_version');
        } else {
            $is_sugar = '';
            echo "<script src='modules/CL_custom_login/loginSlider/js/jquery.js'></script>";
        }
        //------------------------checking licence configuration status------------------------------
        require_once 'modules/CL_custom_login/slider_function.php';
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
            $qc = isset($_REQUEST['qc']) ? $_REQUEST['qc'] : '';
            global $db;
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


            $html = "";
            $html.="<p align='center'><b><label id='lbl_quotecat_msg' style='color:green; font-size:14px;'></label></b></p>";
            echo "<script src='modules/bc_Quote_Category/js/quote.js'></script>";

            $html.="<br/><h3>Manage Quote Category</h3><br/><button name='clear' class='button button-small' onclick='backtoquote()'>Return to Quote</button>";
            ////////////////////////////////////////////////////////////////////QUOTE CATEGORY//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $html.="<div id='quotecat'>";
            $html.="<div><div style='padding:10px; border:1px solid #d6d6d6; width:1000px;'>"
                    . "<table id='tab2'  style=' border-radius:10px; text-align:center;'>"
                    . "<tr><th id='thead'>Add New Quote Category</th><th></th></tr><tr id='newcat_row'><td>"
                    . "<br/>Quote Category :  <input type='text' id='new_cat' placeholder='Quote Category' style='width:200px;'/></td>";
            $html.="<td name='lbl_check'><br/><h3><label id='lbl_newcat_hidden'></label></h3></td></tr>";
            $html.="</table></div></div>";
            $html.="<br/><span id='buttons_cat'>"
                    . "<input type='button' id='btn_savenewcat' value='Save' onclick='savenewcategory()'/></span>";
            $html.="&nbsp;<input type='button' name='clear' onclick='cancelcat()' value='Clear'/><br/><br/>";
            $html.="<br/><div>";



            //------------------------------display quotes category------------------------------------------------
            $bc_quotes = new bc_Quote_Category();
            $bc_quotes_result = $bc_quotes->get_list("", "");
            if (count($bc_quotes_result['list']) > 0) {

                $html.="<div style='padding:10px; border:1px solid #d8d8d8; width:1000px; background-color:#f8f8f8;'><table id='tab3'   style='border-radius:10px; width:100%; '><tr><th height='40' style='font-size:16px;'>Quote Categories</th></tr><tr><td></td></tr><tr><td>";

                $bc_quotes_result['list'] = sortingGetBeansArrayData($bc_quotes_result['list'], 'name', 'asc');
                foreach ($bc_quotes_result['list'] as $key => $value) {
                    $cat_id = $value->id;
                    $cat_name = htmlspecialchars($value->name);
                    $html.= "<div id='category_block'><a href='javascript:void(0)' class='del'  onclick=\"delete_category('$cat_id')\"><img id='im' src='modules/bc_Quote_Category/images/quote/icon_Delete.gif' height='25px' width='20px'/></a> "
                            . "<a href='javascript:void(0)'   onclick=\"show_editcat_table('$cat_id'),set_editcat_value('$cat_id','$cat_name')\"><img id='im' src='modules/bc_Quote_Category/images/quote/edit.png' height='20px' width='20px'/></a> "
                            . "<span name='$cat_id'><a href='index.php?module=bc_Quote_Category&action=loginquote&qid=" . $cat_id . "&msg=0'>" . $value->name . "</a></span></div>";
                }
                $html.="</td></tr></table></div>";
            }
            $html.="</div><br/><button name='backtoadmin' class='button button-small' onclick='backtoadmin()'>Return to Admin</button></div>";
            //      }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////               
            echo $html;


            parent::display();
        }
    }

}

?>
