<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
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
 * @author SalesAgility Ltd <support@salesagility.com>
 */

require_once('modules/AOS_Invoices/controller.php');
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

class CustomAOS_InvoicesController extends AOS_InvoicesController
{
    public function action_retrieve_additional_details()
    {
        global $current_language, $timedate;

        $lineItemId = $_REQUEST['line_item_id'];

        $aosProductQuoteBean = BeanFactory::getBean('AOS_Products_Quotes', $lineItemId);
        $aosProductQuoteBean->load_relationship('apx_shippingdetails_aos_products_quotes_1');
        $shippingDetailBeanList = $aosProductQuoteBean->apx_shippingdetails_aos_products_quotes_1->getBeans();
        $dataArray = [];

        // Retrieve logged user timezone
        $timezone = $timedate->getInstance()->userTimezone();

        // Retrieve logged user date format
        $userDateFormat = $timedate->getInstance()->get_date_format();
            
        if (! empty($shippingDetailBeanList) && count($shippingDetailBeanList) > 0) {
            $shippingDetailsModStrings = return_module_language($current_language, 'APX_ShippingDetails');

            foreach($shippingDetailBeanList as $shippingDetailBean) {
                $dataArray['shipping_details'][] = [
                    'name' => [
                        'label' => $shippingDetailsModStrings['LBL_NAME'],
                        'value' => $shippingDetailBean->name
                    ],
                    'carrier' => [
                        'label' => $shippingDetailsModStrings['LBL_CARRIER'],
                        'value' => $shippingDetailBean->carrier
                    ],
                    'delivered_date' => [
                        'label' => $shippingDetailsModStrings['LBL_DELIVERED_DATE'],
                        'value' => ($shippingDetailBean->delivered_date) ? Carbon::parse($shippingDetailBean->delivered_date)->format($userDateFormat) : ''
                    ],
                    'ship_tracker' => [
                        'label' => $shippingDetailsModStrings['LBL_SHIP_TRACKER'],
                        'value' => $shippingDetailBean->ship_tracker
                    ],
                    'pl_line_number' => [
                        'label' => $shippingDetailsModStrings['LBL_PL_LINE_NUMBER'],
                        'value' => $shippingDetailBean->pl_line_number
                    ],
                    'qty_shipped' => [
                        'label' => $shippingDetailsModStrings['LBL_QTY_SHIPPED'],
                        'value' => $shippingDetailBean->qty_shipped
                    ],
                    'total_number_of_skids' => [
                        'label' => $shippingDetailsModStrings['LBL_TOTAL_NUMBER_OF_SKIDS'],
                        'value' => $shippingDetailBean->total_number_of_skids
                    ],
                ];
            }
        }

        $aosProductQuoteBean->load_relationship('apx_lots_aos_products_quotes_1');
        $lotBeanList = $aosProductQuoteBean->apx_lots_aos_products_quotes_1->getBeans();
        
        if (! empty($lotBeanList) && count($lotBeanList) > 0) {
            $lotsModStrings = return_module_language($current_language, 'APX_Lots');

            foreach($lotBeanList as $lotBean) {
                $dataArray['lots'][] = [
                    'lot_number' => [
                        'label' => $lotsModStrings['LBL_NAME'],
                        'value' => $lotBean->name
                    ]
                ];
            }
        }

        $jsonEncodedDataArray = json_encode($dataArray);

        echo json_encode($jsonEncodedDataArray);
    }
}
