<?php
/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

//  APX Custom Codes -- START
function get_customer_products($aos_product_quote_id)
{
    global $db;
    $result = array();

    if(!empty($aos_product_quote_id)){
        $sql = "SELECT capq.id,
                    capq.ci_customeritems_aos_products_quotesci_customeritems_ida as customer_product_id,
                    capq.ci_customeritems_aos_products_quotesaos_products_quotes_idb as product_quote_id
                FROM ci_customeritems_aos_products_quotes_c as capq
                where capq.deleted = 0
                    and capq.ci_customeritems_aos_products_quotesaos_products_quotes_idb = '{$aos_product_quote_id}'
                ";
        $data = $db->query($sql);
        
        $i = 0;
        while($rowData = $db->fetchByAssoc($data)){
            $result[$i] = $rowData['customer_product_id'];
            $i++;
        }
    }

    return $result;
}
//  APX Custom Codes -- END

//  APX Custom Codes -- START
function get_order($order_id)
{
    global $db;
    $result = array();

    if(!empty($order_id)){
        $sql = "SELECT id, name
                FROM odr_salesorders o
                where o.deleted = 0
                    and o.id = '{$order_id}'
                ";
        $data = $db->query($sql);
        $dbData = $db->fetchByAssoc($data);
        $result = $dbData['name'];
    }

    return $result;
}
//  APX Custom Codes -- END

function display_lines($focus, $field, $value, $view)
{
    global $sugar_config, $locale, $app_list_strings, $mod_strings;

    $enable_groups = (int)$sugar_config['aos']['lineItems']['enableGroups'];
    $total_tax = (int)$sugar_config['aos']['lineItems']['totalTax'];

    $html = '';

    if ($view == 'EditView') {
        $html .= '<script src="modules/AOS_Products_Quotes/line_items.js"></script>';
        if (file_exists('custom/modules/AOS_Products_Quotes/line_items.js')) {
            $html .= '<script src="custom/modules/AOS_Products_Quotes/line_items.js"></script>';
        }
        $html .= '<script language="javascript">var sig_digits = '.$locale->getPrecision().';';
        $html .= 'var module_sugar_grp1 = "'.$focus->module_dir.'";';
        $html .= 'var enable_groups = '.$enable_groups.';';
        $html .= 'var total_tax = '.$total_tax.';';
        $html .= '</script>';

        $html .= "<table border='0' cellspacing='4' id='lineItems'></table>";

        if ($enable_groups) {
            $html .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
            $html .= "<input type=\"button\" tabindex=\"116\" class=\"button\" value=\"".$mod_strings['LBL_ADD_GROUP']."\" id=\"addGroup\" onclick=\"insertGroup(0)\" />";
            $html .= "</div>";
        }
        $html .= '<input type="hidden" name="vathidden" id="vathidden" value="'.get_select_options_with_id($app_list_strings['vat_list'], '').'">
				  <input type="hidden" name="discounthidden" id="discounthidden" value="'.get_select_options_with_id($app_list_strings['discount_list'], '').'">';
        if ($focus->id != '') {
            require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');
            require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php');

            // APX Custom Codes: Changed ORDER BY from "lig.number ASC, pg.number ASC" to "cast(pg.order_line_number as SIGNED) ASC"
            if (in_array($focus->module_dir, ['AOS_Invoices', 'ODR_SalesOrders'])) {
                $sql = "SELECT pg.id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '" . $focus->object_name . "' AND pg.parent_id = '" . $focus->id . "' AND pg.deleted = 0 ORDER BY cast(pg.order_line_number as SIGNED) ASC";
            } else {
                $sql = "SELECT pg.id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '" . $focus->object_name . "' AND pg.parent_id = '" . $focus->id . "' AND pg.deleted = 0 ORDER BY lig.number ASC, pg.number ASC";
            }

            $result = $focus->db->query($sql);
            $html .= "<script>
                if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}
                </script>";

            while ($row = $focus->db->fetchByAssoc($result)) {
                $line_item = BeanFactory::newBean('AOS_Products_Quotes');
                $line_item->retrieve($row['id'], false);
                $line_item = json_encode($line_item->toArray());

                $group_item = 'null';
                if ($row['group_id'] != null) {
                    $group_item = BeanFactory::newBean('AOS_Line_Item_Groups');
                    $group_item->retrieve($row['group_id'], false);
                    $group_item = json_encode($group_item->toArray());
                }
                $html .= "<script>
                        insertLineItems(" . $line_item . "," . $group_item . ");
                    </script>";
            }
        }
        if (!$enable_groups) {
            $html .= '<script>insertGroup();</script>';
        }
    } elseif ($view == 'DetailView') {
        $params = array('currency_id' => $focus->currency_id);

        // APX Custom Codes: Changed ORDER BY from "lig.number ASC, pg.number ASC" to "cast(pg.order_line_number as SIGNED) ASC"
        if (in_array($focus->module_dir, ['AOS_Invoices', 'ODR_SalesOrders'])) {
            $sql = "SELECT pg.id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '".$focus->object_name."' AND pg.parent_id = '".$focus->id."' AND pg.deleted = 0 ORDER BY cast(pg.order_line_number as SIGNED) ASC";
        } else {
            $sql = "SELECT pg.id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '".$focus->object_name."' AND pg.parent_id = '".$focus->id."' AND pg.deleted = 0 ORDER BY lig.number ASC, pg.number ASC";
        }


        $result = $focus->db->query($sql);
        $sep = get_number_separators();

        $html .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

        $i = 0;
        $productCount = 0;
        $serviceCount = 0;
        $group_id = '';
        $groupStart = '';
        $groupEnd = '';
        $product = '';
        $service = '';

        $rowCount = 0; // APX Custom Codes: OnTrack #815
        while ($row = $focus->db->fetchByAssoc($result)) {
            $line_item = BeanFactory::newBean('AOS_Products_Quotes');
            $line_item->retrieve($row['id']);


            if ($enable_groups && ($group_id != $row['group_id'] || $i == 0)) {
                $html .= $groupStart.$product.$service.$groupEnd;
                if ($i != 0) {
                    $html .= "<tr><td colspan='9' nowrap='nowrap'><br></td></tr>";
                }
                $groupStart = '';
                $groupEnd = '';
                $product = '';
                $service = '';
                $i = 1;
                $productCount = 0;
                $serviceCount = 0;
                $group_id = $row['group_id'];

                $group_item = BeanFactory::newBean('AOS_Line_Item_Groups');
                $group_item->retrieve($row['group_id']);

                $groupStart .= "<tr>";
                $groupStart .= "<td class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>&nbsp;</td>";
                $groupStart .= "<td class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_GROUP_NAME'].":</td>";
                $groupStart .= "<td class='tabDetailViewDL' colspan='7' style='text-align: left;padding:2px;'>".$group_item->name."</td>";
                $groupStart .= "</tr>";

                $groupEnd = "<tr><td colspan='9' nowrap='nowrap'><br></td></tr>";
                $groupEnd .= "<tr>";
                $groupEnd .= "<td class='tabDetailViewDL' colspan='8' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_AMT'].":&nbsp;&nbsp;</td>";
                $groupEnd .= "<td class='tabDetailViewDL' style='text-align: right;padding:2px;'>".currency_format_number($group_item->total_amt, $params)."</td>";
                $groupEnd .= "</tr>";
                $groupEnd .= "<tr>";
                $groupEnd .= "<td class='tabDetailViewDL' colspan='8' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_DISCOUNT_AMOUNT'].":&nbsp;&nbsp;</td>";
                $groupEnd .= "<td class='tabDetailViewDL' style='text-align: right;padding:2px;'>".currency_format_number($group_item->discount_amount, $params)."</td>";
                $groupEnd .= "</tr>";
                $groupEnd .= "<tr>";
                $groupEnd .= "<td class='tabDetailViewDL' colspan='8' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_SUBTOTAL_AMOUNT'].":&nbsp;&nbsp;</td>";
                $groupEnd .= "<td class='tabDetailViewDL' style='text-align: right;padding:2px;'>".currency_format_number($group_item->subtotal_amount, $params)."</td>";
                $groupEnd .= "</tr>";
                $groupEnd .= "<tr>";
                $groupEnd .= "<td class='tabDetailViewDL' colspan='8' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_TAX_AMOUNT'].":&nbsp;&nbsp;</td>";
                $groupEnd .= "<td class='tabDetailViewDL' style='text-align: right;padding:2px;'>".currency_format_number($group_item->tax_amount, $params)."</td>";
                $groupEnd .= "</tr>";
                $groupEnd .= "<tr>";
                $groupEnd .= "<td class='tabDetailViewDL' colspan='8' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_GRAND_TOTAL'].":&nbsp;&nbsp;</td>";
                $groupEnd .= "<td class='tabDetailViewDL' style='text-align: right;padding:2px;'>".currency_format_number($group_item->total_amount, $params)."</td>";
                $groupEnd .= "</tr>";
            }
            if ($line_item->product_id != '0' && $line_item->product_id != null) {
                // APX Custom Codes: OnTrack #815 - Invoice module not to have duplicate header -- START
                if ($rowCount > 0 && ($focus->module_dir == 'AOS_Invoices' || $focus->module_dir == 'ODR_SalesOrders')) {
                    $productCount = -1;
                }
                // APX Custom Codes: OnTrack #815 - Invoice module not to have duplicate header -- END
                
                if ($productCount == 0) {
                    $product .= "<tr>";
                    
                    // APX Custom Codes -- START
                    if($focus->module_dir == 'AOS_Quotes') {
                        $product .= "<td width='5%' class='tabDetailViewDL'  style='padding:2px;' scope='row'>&nbsp;</td>";
                        $product .= "<td width='10%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_QUANITY']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_NAME']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_CUSTOMER_ID']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_LDR']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_RESIN']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_UNIT_PRICE']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
                    } else if($focus->module_dir == 'ODR_SalesOrders') {
                        //$product .= "<td width='5%' class='tabDetailViewDL'  style='padding:2px;' scope='row'>&nbsp;</td>";
                        $product .= "<td width='3%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_ORDER_LINE_NUMBER'] . "</td>"; //Line #
                        $product .= "<td width='7%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_PART_NUMBER']."</td>"; //Item Number
                        $product .= "<td width='30%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" .
                            $mod_strings['LBL_PRODUCT_NAME'] . "</td>"; //Item Name
                        $product .= "<td width='6%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_PRODUCT_QUANITY'] . "</td>"; //Qty Ordered
                        $product .= "<td width='7%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_UNIT_PRICE'] . "</td>"; //Unit Price
                        $product .= "<td width='7%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DISCOUNT_AMT'] . "</td>"; //Discount
                        $product .= "<td width='6%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_TOTAL_PRICE'] . "</td>"; //Total
                        $product .= "<td width='8%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DUE_DATE'] . "</td>"; //Requested Date
                        $product .= "<td width='8%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_REQUIRED_SHIP_DATE'] . "</td>"; //Req Shipped Date
                        $product .= "<td width='8%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_PROMISED_DATE'] . "</td>"; //Promised Date
                        $product .= <<<EOD
                        <td width='2%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'></td>
EOD;
                    } 
                    else if($focus->module_dir == 'AOS_Invoices'){
                        $width = 100 / 13; //100 divided by # of columns
                        //$product .= "<td width='2%' class='tabDetailViewDL'  style='padding:2px;' scope='row'>&nbsp;</td>";

                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_LINE_NO'] . "</td>"; //Line #
                            $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_ORDER_NUMBER'] . "</td>"; //Order #
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_ITEM_NO'] . "</td>"; //Item #
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DETAIL_ITEM_NAME'] . "</td>"; //Item Name
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_QTY_ORDERED'] . "</td>"; //Qty Ordered
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_UNIT_PRICE'] . "</td>"; //Unit Price
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DISCOUNT'] . "</td>"; //Discount
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_LINE_TOTAL'] . "</td>"; //Total
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DETAIL_REQUESTED_DATE'] . "</td>"; //Requested Date
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DETAIL_REQUIRED_SHIP_DATE'] . "</td>"; //Req Ship Date
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_QTY_SHIPPED'] . "</td>"; //Qty Shipped
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_SHIPPED_DATE'] . "</td>"; //Shipped Date
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_DAYS_LATE'] . "</td>"; //Days Late
                        $product .= "<td width='{$width}%' class='tabDetailViewDL' style='padding:2px; text-align: center;' scope='row'>" . 
                            $mod_strings['LBL_PROMISED_DATE'] . "</td>"; //Promised Date
                    }
                    else if ($focus->module_dir == 'Cases') {
                        $product .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>&nbsp;</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'><b>".$mod_strings['LBL_LOT_NUMBER']."</b></td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'><b>".$mod_strings['LBL_PRODUCT_NUMBER']."</b></td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'><b>".$mod_strings['LBL_PRODUCT_NAME']."</b></td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'><b>".$mod_strings['LBL_PRODUCT_AMOUNT_LBS']."</b></td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'><b>".$mod_strings['LBL_CREATED']."</b></td>";
                    }
                    else {
                        $product .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>&nbsp;</td>";
                        $product .= "<td width='10%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_QUANITY']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_NAME']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_LIST_PRICE']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_DISCOUNT_AMT']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_UNIT_PRICE']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_VAT']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_VAT_AMT']."</td>";
                        $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
                    }
                    // APX Custom Codes -- END
                    $product .= "</tr>";
                }

                $product .= "<tr>";
                $product_note = wordwrap($line_item->description, 40, "<br />\n");

                // APX Custom Codes -- START
                if($focus->module_dir != 'AOS_Invoices' && $focus->module_dir != 'ODR_SalesOrders') {
                    $product .= "<td class='tabDetailViewDF' style='text-align: left; padding:2px;'>".++$productCount."</td>";
                }
                
                if($focus->module_dir == 'AOS_Quotes') {
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".stripDecimalPointsAndTrailingZeroes(format_number($line_item->product_qty),$sep[1])."</td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=AOS_Products&action=DetailView&record=".$line_item->product_id."' class='tabDetailViewDFLink'>".$line_item->name."</a></td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".$line_item->customer_id_c."</td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".$line_item->ldr_c." %</td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".$line_item->resin_c."</td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($line_item->product_unit_price,$params )."</td>";
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($line_item->product_total_price,$params )."</td>";
                } else if ($focus->module_dir == 'ODR_SalesOrders') {
                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: right;'>" .
                        stripDecimalPointsAndTrailingZeroes(format_number($line_item->order_line_number) ,$sep[1]) ."</td>"; //Line #
                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'>" .
                        $line_item->part_number."</td>"; //Item Number

                    //Item Name
                    $customer_products = get_customer_products($line_item->id);
                    if (! empty($customer_products) && count($customer_products) > 0) {
                        $cust_id = array_values($customer_products)[0];
                        $cust_prod_bean =  BeanFactory::getBean('CI_CustomerItems', $cust_id);
                        $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'><a href='index.php?module=CI_CustomerItems&action=DetailView&record=". $cust_prod_bean->id."' class='tabDetailViewDFLink'>". $cust_prod_bean->name ."</a></td>"; 
                    } else {
                        $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'></td>";
                    }

                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: right;'>"
                        . stripDecimalPointsAndTrailingZeroes(format_number($line_item->product_qty) ,$sep[1]) ."</td>"; //Qty Ordered
                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: right;'>" . 
                        currency_format_number($line_item->product_unit_price) ."</td>"; //Unit Price
                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: right;'>" . 
                        currency_format_number($line_item->product_discount). "</td>"; //Discount
                    $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: right;'>" .
                        currency_format_number($line_item->product_total_price) ."</td>"; //Total
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;  text-align: center;'>" 
                        .$line_item->requested_date_c . "</td>"; //Requested Date
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;  text-align: center;'>" 
                        .$line_item->required_ship_date_c . "</td>"; //Req Ship Date
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;  text-align: center;'>" 
                        .$line_item->promised_date . "</td>"; //Promised Date
                    if (! empty($line_item->req_ship_date_reason_code)) {
                        $product .= <<<EOD
                        <td class='tabDetailViewDF' style='text-align: left; vertical-align: bottom;'>
                            <span style="line-height: 1.5; font-size: 18px; cursor:pointer; font-weight: bolder;" id="adspan_{$line_item->id}" onclick="showAdditionalInfo('adspan_{$line_item->id}', '{$line_item->req_ship_date_reason_code}', '{$line_item->req_ship_date_orig}')" class="suitepicon suitepicon-action-info"></span>
                        </td>
EOD;
                    } else {
                        $product .= '<td></td>';
                    }
                } 
                else if($focus->module_dir == 'AOS_Invoices'){
                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        stripDecimalPointsAndTrailingZeroes(format_number($line_item->order_line_number) ,$sep[1]) ."</td>"; //Line #

                    

                    if ($line_item->parent_type == 'AOS_Invoices') {
                        $invoiceBean = ($line_item->parent_type == 'AOS_Invoices') 
                            ? BeanFactory::getBean('AOS_Invoices', $line_item->parent_id)
                            : null;
                    }                    
                    
                    if ($invoiceBean && $invoiceBean->id) {                        
                        $orderBean = BeanFactory::getBean('ODR_SalesOrders')->retrieve_by_string_fields(
                            array(
                                "number" => $invoiceBean->order_number_c,
                            ), false, true
                        );
                
                        $product .= ($orderBean && $orderBean->id)
                            ? "<td class='tabDetailViewDF' style='padding: 2px; text-align: center;'>
                                <a href='{$sugar_config['site_url']}/index.php?module=ODR_SalesOrders&action=DetailView&record={$orderBean->id}'>{$invoiceBean->order_number_c}</a>
                               </td>"
                            : "<td class='tabDetailViewDF' style='padding: 2px; text-align: center;'>{$invoiceBean->order_number_c}</td>";
                    } else {
                        //Order Name
                        $order_name = get_order($line_item->order_id);

                        if(!empty($order_name)){
                            $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'>" . $order_name
                            ."</td>"; 
                        }else{
                            $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'>" . $line_item->order_number
                            ."</td>";
                        }
                    }
                    

                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        $line_item->item_number_c ."</td>"; //Item #

                    //Item Name
                    $customer_products = get_customer_products($line_item->id);
                    if(!empty($customer_products) && count($customer_products) > 0){
                        $cust_id = array_values($customer_products)[0];
                        $cust_prod_bean =  BeanFactory::getBean('CI_CustomerItems', $cust_id);
                        $product .= "<td class='tabDetailViewDF' style='padding:2px; text-align: center;'><a href='index.php?module=CI_CustomerItems&action=DetailView&record=". $cust_prod_bean->id."' class='tabDetailViewDFLink'>". $cust_prod_bean->name ."</a></td>"; 
                    }
                    else{
                        $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                            $line_item->name ."</td>"; //Item Name
                    }

                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        stripDecimalPointsAndTrailingZeroes(format_number($line_item->product_qty), $sep[1]) ."</td>"; //Qty Ordered
                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        format_number($line_item->product_unit_price) ."</td>"; //Unit Price
                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        format_number($line_item->product_discount) ."</td>"; //Discount
                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        format_number($line_item->product_total_price) ."</td>"; //Total Price
                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        $line_item->requested_date_c ."</td>"; //Requested Date
                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        $line_item->required_ship_date_c ."</td>"; //Reqrd Ship Date
                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        stripDecimalPointsAndTrailingZeroes(format_number($line_item->qty_shipped_c ), $sep[1]) ."</td>"; //Qty Shipped
                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        $line_item->shipped_date_c ."</td>"; //Shipped Date
                    $product .= "<td class='tabDetailViewDF' style='text-align: right;'>" .
                        stripDecimalPointsAndTrailingZeroes(format_number($line_item->days_late_c ), $sep[1]) ."</td>"; //Days Late
                    $product .= "<td class='tabDetailViewDF' style='text-align: center;'>" .
                        $line_item->promised_date ."</td>"; //Promised Date
                        
                    $product .= "<td class='tabDetailViewDF' style='text-align: left; vertical-align: bottom;'>
                        <span style=\"line-height: 1.5; font-size: 18px; cursor:pointer; font-weight: bolder;\" id=\"adspan_{$line_item->id}\" onclick=\"showAdditionalInfo('{$line_item->id}')\" class=\"suitepicon suitepicon-action-info\"></span>
                    </td>";
                    
                }
                else if ($focus->module_dir == 'Cases') {
                    $createdByBean = BeanFactory::getBean('Users', $line_item->created_by);
                    $lotBean = BeanFactory::getBean('APX_Lots', $line_item->lot_id);

                    $product .= ($lotBean && $lotBean->id)
                        ? "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=APX_Lots&action=DetailView&record=".$line_item->lot_id."' class='tabDetailViewDFLink'>".$line_item->lot_name."</a></td>"
                        : "<td class='tabDetailViewDF' style='padding:2px;'>".$line_item->lot_name."</td>";

                    $product .= ($line_item->customer_product_id)
                        ? "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=CI_CustomerItems&action=DetailView&record=".$line_item->customer_product_id."' class='tabDetailViewDFLink'>".$line_item->customer_product_number."</a></td>"
                        : "<td class='tabDetailViewDF' style='padding:2px;'></td>";

                    $product .= ($line_item->customer_product_id)
                        ? "<td class='tabDetailViewDF' style='padding:2px;'>".$line_item->customer_product_name."</td>"
                        : "<td class='tabDetailViewDF' style='padding:2px;'></td>";

                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".stripDecimalPointsAndTrailingZeroes(format_number($line_item->customer_product_amount_lbs), $sep[1])."</td>";
                    $product .= ($createdByBean && $createdByBean->id)
                        ? "<td class='tabDetailViewDF' style='padding:2px;'>".$createdByBean->name."</td>"
                        : "<td class='tabDetailViewDF' style='padding:2px;'></td>";
                }
                else {
                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".stripDecimalPointsAndTrailingZeroes(format_number($line_item->product_qty), $sep[1])."</td>";

                    $product .= "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=AOS_Products&action=DetailView&record=".$line_item->product_id."' class='tabDetailViewDFLink'>".$line_item->name."</a><br />".$product_note."</td>";
                    $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_list_price, $params)."</td>";

                    $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".get_discount_string($line_item->discount, $line_item->product_discount, $params, $locale, $sep)."</td>";

                    $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_unit_price, $params)."</td>";
                    if ($locale->getPrecision()) {
                        $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".rtrim(rtrim(format_number($line_item->vat), '0'), $sep[1])."%</td>";
                    } else {
                        $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".format_number($line_item->vat)."%</td>";
                    }
                    $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->vat_amt, $params)."</td>";
                    $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_total_price, $params)."</td>";
                }
                // APX Custom Codes -- END

                $product .= "</tr>";
            } else {
                if ($serviceCount == 0) {
                    $service .= "<tr>";
                    $service .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>&nbsp;</td>";
                    $service .= "<td width='46%' class='dataLabel' style='text-align: left;padding:2px;' colspan='2' scope='row'>".$mod_strings['LBL_SERVICE_NAME']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_SERVICE_LIST_PRICE']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_SERVICE_DISCOUNT']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_SERVICE_PRICE']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_VAT']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_VAT_AMT']."</td>";
                    $service .= "<td width='12%' class='dataLabel' style='text-align: right;padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
                    $service .= "</tr>";
                }

                $service .= "<tr>";
                $service .= "<td class='tabDetailViewDF' style='text-align: left; padding:2px;'>".++$serviceCount."</td>";
                $service .= "<td class='tabDetailViewDF' style='padding:2px;' colspan='2'>".$line_item->name."</td>";
                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_list_price, $params)."</td>";

                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".get_discount_string($line_item->discount, $line_item->product_discount, $params, $locale, $sep)."</td>";


                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_unit_price, $params)."</td>";
                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".rtrim(rtrim(format_number($line_item->vat), '0'), $sep[1])."%</td>";
                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->vat_amt, $params)."</td>";
                $service .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->product_total_price, $params)."</td>";
                $service .= "</tr>";
            }

            $rowCount++; // APX Custom Codes: OnTrack #815
        }
        $html .= $groupStart.$product.$service.$groupEnd;
        $html .= "</table>";
    }
    return $html;
}

//Bug #598
//The original approach to trimming the characters was rtrim(rtrim(format_number($line_item->product_qty), '0'),$sep[1])
//This however had the unwanted side-effect of turning 1000 (or 10 or 100) into 1 when the Currency Significant Digits
//field was 0.
//The approach below will strip off the fractional part if it is only zeroes (and in this case the decimal separator
//will also be stripped off) The custom decimal separator is passed in to the function from the locale settings
function stripDecimalPointsAndTrailingZeroes($inputString, $decimalSeparator)
{
    return preg_replace('/'.preg_quote((string) $decimalSeparator).'[0]+$/', '', (string) $inputString);
}

function get_discount_string($type, $amount, $params, $locale, $sep)
{
    if ($amount != '' && $amount != '0.00') {
        if ($type == 'Amount') {
            return currency_format_number($amount, $params)."</td>";
        } elseif ($locale->getPrecision()) {
            return rtrim(rtrim(format_number($amount), '0'), $sep[1])."%";
        }
        return format_number($amount)."%";
    }
    return "-";
}

function display_shipping_vat($focus, $field, $value, $view)
{
    if ($view == 'EditView') {
        global $app_list_strings;

        if ($value != '') {
            $value = format_number($value);
        }

        $html = "<input id='shipping_tax_amt' type='text' tabindex='0' title='' value='".$value."' maxlength='26,6' size='22' name='shipping_tax_amt' onblur='calculateTotal(\"lineItems\");'>";
        $html .= "<select name='shipping_tax' id='shipping_tax' onchange='calculateTotal(\"lineItems\");' >".get_select_options_with_id($app_list_strings['vat_list'], (isset($focus->shipping_tax) ? $focus->shipping_tax : ''))."</select>";

        return $html;
    }
    return format_number($value);
}
