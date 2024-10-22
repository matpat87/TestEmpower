
<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
require_once('include/MVC/View/views/view.detail.php');

class bc_Quote_CategoryViewLoginquotedisplay extends SugarView {

    public function bc_Quote_CategoryViewLoginquotedisplay() {
        parent::SugarView();
    }

    function display() {
        //-----------------------checking sugar and include js if required----------------------------
        global $current_user, $sugar_config;
        require_once 'modules/CL_custom_login/slider_function.php';
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

            echo "<script src='modules/bc_Quote_Category/js/login_quote.js'></script>";
            $html.="<p align='center'><label id='label' align='center' style='display:none;'></label></p>";
            $html .= "<br/><h2 id='header_main'>Choose your quote category to display quotes on login screen.</h2><br/>";
            $html.="<input type='button' value='Save' onclick='savecat()' />&nbsp;";
            $html.="<input type='button' name='clear' onclick='cancel()' value='Return To Admin'/><br/>";
            $html.="<div id='loginquote' style='width:98%; '>"
                    . "<br/>"
                    . "<label><div style='border:1px solid #d6d6d6; padding:10px; margin:10px; width:250px;'>";
            $html.="<table id='tbl_loginquote' align='center' style='border-radius:10px;  width:250px;'  cellpadding=20 cellspacing=20><tr><th>Quote Category</th></tr><td><br/>";

            //---------------------display category---------------------------------------- 
            $current_cat = array();
            $bc_quotes = new bc_Quote_Category();
            $bc_quotes_result = $bc_quotes->get_list("", "");

            foreach ($bc_quotes_result['list'] as $key => $value) {
                if ($value->description == '1') {
                    array_push($current_cat, $value->id);
                }
            }
            if (count($bc_quotes_result['list']) <= 0) {
                $html.="<p align='center' style='color:red;'>Quote Category not found</p></p><p align='center'>To configure it  <a href='index.php?module=bc_Quote_Category&action=loginquotecategory'> click here </a></p>";
            } else {
                $html.="<p align='center'><select name='sm' class='my' style='height:300px; width:150px;' multiple>";
                $bc_quotes_result['list'] = sortingGetBeansArrayData($bc_quotes_result['list'], 'name', 'asc');
                foreach ($bc_quotes_result['list'] as $key => $value) {
                    $catid = $value->id;
                    $catname = $value->name;

                    if (in_array($catid, $current_cat)) {
                        $html.= "<option value='$catid' selected='selected' class='my'/>    " . $catname . "</option>    ";
                    } else {
                        $html.= "<option  value='$catid' class='my'>    " . $catname . "</option>    ";
                    }
                }
                $html.="</select></p><br/><p align=center><button id='sel' onclick='sel()'>Select All</button>&nbsp;<button id='dsel' onclick='dsel()'>Deselect All</button></p>";
            }
            $html.="</td></tr>";
            $html.="</table></div></label><br/><br/></div>";
            $html.="<input type='button' value='Save' onclick='savecat()' />&nbsp;";
            $html.="<input type='button' name='clear' onclick='cancel()' value='Return To Admin'/>";
            echo $html;

            parent::display();
        }
    }

}

?>
