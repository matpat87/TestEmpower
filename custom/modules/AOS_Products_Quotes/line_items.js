/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

var lineno;
var prodln = 0;
var servln = 0;
var groupn = 0;
var group_ids = {};


/**
 * Load Line Items
 */

function insertLineItems(product,group){

  var type = 'product_';
  var ln = 0;
  var current_group = 'lineItems';
  var gid = product.group_id;

  if(typeof group_ids[gid] === 'undefined'){
    current_group = insertGroup();
    group_ids[gid] = current_group;
    for(var g in group){
      if(document.getElementById('group'+current_group + g) !== null){
        document.getElementById('group'+current_group + g).value = group[g];
      }
    }
  } else {
    current_group = group_ids[gid];
  }

  if(product.product_id != '0' && product.product_id !== ''){
    ln = insertProductLine('product_group'+current_group,current_group);
    type = 'product_';
  } else {
    ln = insertServiceLine('service_group'+current_group,current_group);
    type = 'service_';
  }

  //OnTrack #704 - excempt fields below
  var excemptFields = [];

  if(module_sugar_grp1 == 'AOS_Invoices'){
    excemptFields = ['qty_shipped_c', 'order_line_number', 'product_qty', 'days_late_c'];
  }
  else if(module_sugar_grp1 == 'ODR_SalesOrders'){
    excemptFields = ['order_line_number', 'product_qty'];
  }
  else if(module_sugar_grp1 == 'Cases'){
    excemptFields = ['customer_product_amount_lbs']; // Add to array to exclude field from being formatted with decimal point
  }

  for(var p in product){
    if(document.getElementById(type + p + ln) !== null){
      if(excemptFields.indexOf(p) > -1){ //OnTrack #704 - Invoice and Orders module overhaul custom
        document.getElementById(type + p + ln).value = parseInt(product[p]);
      }else if(product[p] !== '' && isNumeric(product[p]) && p != 'vat'  && p != 'product_id' && p != 'name' && p != "part_number"){
        document.getElementById(type + p + ln).value = format2Number(product[p]);
      } 
      else {
        document.getElementById(type + p + ln).value = product[p];
      }
    }
  }

  // Skip modules like Cases from calculating line as it does not make use of the feature
  if (! ['Cases'].includes(module_sugar_grp1)) {
    calculateLine(ln,type);
  }

}


/**
 * Insert product line
 */

function insertProductLine(tableid, groupid) {

  if(!enable_groups){
    tableid = "product_group0";
  }

  if (document.getElementById(tableid + '_head') !== null) {
    document.getElementById(tableid + '_head').style.display = "";
  }

  var vat_hidden = document.getElementById("vathidden").value;
  var discount_hidden = document.getElementById("discounthidden").value;
  var cellCount = 0;

  if(module_sugar_grp1 == 'ODR_SalesOrders'){
    sqs_objects["product_ci_customeritems_aos_products_quotes_name[" + prodln + "]"] = {
      "form": "EditView",
      "method": "query",
      "modules": ["CI_CustomerItems"],
      "group": "or",
      "field_list": ["name", "id"],
      "populate_list": ["product_ci_customeritems_aos_products_quotes_name[" + prodln + "]",  "product_ci_customeritems_aos_products_quotesci_customeritems_ida[" + prodln + "]"],
      "required_list": ["product_id[" + prodln + "]"],
      "conditions": [{
        "name": "name",
        "op": "like_custom",
        "end": "%",
        "value": ""
      }],
      "order": "name",
      "limit": "30",
      "post_onblur_function": "formatListPrice(" + prodln + ");",
      "no_match_text": "No Match"
    };
  } else if (module_sugar_grp1 == 'Cases') {
    // On page load / New Line, set SQS conditions depending on if Account ID has value
    sqs_objects["product_lot_name[" + prodln + "]"] = {
      "form": "EditView",
      "method": "query",
      "modules": ["APX_Lots"],
      "group": "or",
      "field_list": ["name", "id"],
      "populate_list": ["product_lot_name[" + prodln + "]", "product_lot_id[" + prodln + "]"],
      "required_list": ["product_id[" + prodln + "]"],
      "conditions": [{
        "name": "name",
        "op": "like_custom",
        "end": "%",
        "value": ""
      }],
      "order": "name",
      "limit": "30",
      "no_match_text": "No Match"
    };

    if (document.getElementById('account_id').value.length > 0) {
      sqs_objects["product_lot_name[" + prodln + "]"]["group"] = "and";
      sqs_objects["product_lot_name[" + prodln + "]"]["conditions"][1] = {
        "name": "account_name_non_db",
        "op": "like_custom",
        "end": "%",
        "value": document.getElementById('account_name').value.split("(")[0].trim(),
      };
    }

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['product_lot_name[" + prodln + "]']) != 'undefined'",
        enableQS(false)
    );

    // If account is changed, update Lot # SQS fields
    YAHOO.util.Event.addListener('account_id', 'change', function() {
      for (let i = 0; i < prodln; i++) {
        if (this.value.length > 0) {
          sqs_objects["product_lot_name[" + i + "]"]["group"] = "and";
          sqs_objects["product_lot_name[" + i + "]"]["conditions"][1] = {
            "name": "account_name_non_db",
            "op": "like_custom",
            "end": "%",
            "value": document.getElementById('account_name').value.split("(")[0].trim(),
          };
        } else {
          sqs_objects["product_lot_name[" + i + "]"]["group"] = "or";
          sqs_objects["product_lot_name[" + i + "]"]["conditions"].splice(1, 1);
        }

        SUGAR.util.doWhen(
            "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['product_lot_name[" + i + "]']) != 'undefined'",
            enableQS(false)
        );
      }
    });

    YAHOO.util.Event.addListener(`product_lot_id${prodln}`, 'change', function() {
      let inputElement = document.getElementById(this.id);
      let inputElementLn = inputElement.getAttribute('name').match(/\d+/)[0]; // Fetch number from product_lot_id[0]

      jQuery.ajax({
        url: "index.php?module=Cases&action=retrieve_lot_customer_product_details&to_pdf=1",
        type: "POST",
        data: { 'product_lot_id': this.value }, // Do not use arrow function as this.value becomes undefined
        success: (result) => {
          let dataObj = JSON.parse(result);
          document.getElementById(`product_customer_product_id${inputElementLn}`).value = dataObj.id ?? '';
          document.getElementById(`product_customer_product_number${inputElementLn}`).value = dataObj.number ?? 'N/A';
          document.getElementById(`product_customer_product_name${inputElementLn}`).value = dataObj.name ?? 'N/A';
          document.getElementById(`product_name${inputElementLn}`).value = dataObj.name ?? 'N/A';
        },
        error: (response) =>{
          console.log("error: ", response)
        }
      });
    });
  }
  else{
    sqs_objects["product_name[" + prodln + "]"] = {
      "form": "EditView",
      "method": "query",
      "modules": ["AOS_Products"],
      "group": "or",
      "field_list": ["name", "id", "part_number", "cost", "price", "description", "currency_id"],
      "populate_list": ["product_name[" + prodln + "]", "product_product_id[" + prodln + "]", "product_part_number[" + prodln + "]", "product_product_cost_price[" + prodln + "]", "product_product_list_price[" + prodln + "]", "product_item_description[" + prodln + "]", "product_currency[" + prodln + "]"],
      "required_list": ["product_id[" + prodln + "]"],
      "conditions": [{
        "name": "name",
        "op": "like_custom",
        "end": "%",
        "value": ""
      }],
      "order": "name",
      "limit": "30",
      "post_onblur_function": "formatListPrice(" + prodln + ");",
      "no_match_text": "No Match"
    };

    sqs_objects["product_part_number[" + prodln + "]"] = {
      "form": "EditView",
      "method": "query",
      "modules": ["AOS_Products"],
      "group": "or",
      "field_list": ["part_number", "name", "id","cost", "price","description","currency_id"],
      "populate_list": ["product_part_number[" + prodln + "]", "product_name[" + prodln + "]", "product_product_id[" + prodln + "]",  "product_product_cost_price[" + prodln + "]", "product_product_list_price[" + prodln + "]", "product_item_description[" + prodln + "]", "product_currency[" + prodln + "]"],
      "required_list": ["product_id[" + prodln + "]"],
      "conditions": [{
        "name": "part_number",
        "op": "like_custom",
        "end": "%",
        "value": ""
      }],
      "order": "name",
      "limit": "30",
      "post_onblur_function": "formatListPrice(" + prodln + ");",
      "no_match_text": "No Match"
    };
  }
  

  tablebody = document.createElement("tbody");
  tablebody.id = "product_body" + prodln;
  document.getElementById(tableid).appendChild(tablebody);


  var x = tablebody.insertRow(-1);
  x.id = 'product_line' + prodln;

  if(module_sugar_grp1 == 'AOS_Quotes') {

    var a = x.insertCell(0);
    a.innerHTML = "<input type='text' name='product_product_qty[" + prodln + "]' id='product_product_qty" + prodln + "'  value='' title='' tabindex='116' onblur='Quantity_format2Number(" + prodln + ");calculateLine(" + prodln + ",\"product_\");' class='product_qty'>";

    var b = x.insertCell(1);
    b.innerHTML = "<input class='sqsEnabled product_name' autocomplete='off' type='text' name='product_name[" + prodln + "]' id='product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''><input type='hidden' name='product_product_id[" + prodln + "]' id='product_product_id" + prodln + "'  maxlength='50' value=''>";

    var b1 = x.insertCell(2);
    b1.innerHTML = "<input class='sqsEnabled product_part_number' autocomplete='off' type='text' name='product_part_number[" + prodln + "]' id='product_part_number" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>";

    var b2 = x.insertCell(3);
    b2.innerHTML = "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_part_number_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openProductPopup(" + prodln + ");'><span class=\"suitepicon suitepicon-action-select\"></span></button>";
    
    var c = x.insertCell(4);
    c.innerHTML = "<input type='text' name='product_customer_id_c[" + prodln + "]' id='product_customer_id_c" + prodln + "' maxlength='10'>"

    var c1 = x.insertCell(5);
    c1.innerHTML = "<input type='text' name='product_ldr_c[" + prodln + "]' id='product_ldr_c" + prodln + "' maxlength='6'>"

    var c2 = x.insertCell(6);
    c2.innerHTML = "<input type='text' name='product_resin_c[" + prodln + "]' id='product_resin_c" + prodln + "' maxlength='20'>"

    var e = x.insertCell(7);
    e.innerHTML = "<input type='text' name='product_product_unit_price[" + prodln + "]' id='product_product_unit_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' onblur='calculateLine(" + prodln + ",\"product_\");' onblur='calculateLine(" + prodln + ",\"product_\");' class='product_unit_price'>";

    var g = x.insertCell(8);
    g.innerHTML = "<input type='text' name='product_product_total_price[" + prodln + "]' id='product_product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_total_price'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";
  
    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("product_product_total_price" + prodln);
    }
    var h = x.insertCell(9);
    h.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''><button type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";
  } else if(module_sugar_grp1 == 'ODR_SalesOrders') {
    //OnTrack #704 - Order Module Overhaul
    cellCount = 0;
    var product_order_line_number_obj = x.insertCell(cellCount);
    product_order_line_number_obj.innerHTML = "<input class='product_order_line_number' autocomplete='off' type='text' name='product_order_line_number[" + prodln + "]' id='product_order_line_number" + prodln + "' onblur='' maxlength='50' value='' title='' tabindex='116' value='' style='width: 100%'>";
    cellCount++;

    var product_part_number_obj = x.insertCell(cellCount);
    product_part_number_obj.innerHTML = "<input class='sqsEnabled product_part_number' autocomplete='off' type='text' name='product_part_number[" + prodln + "]' id='product_part_number" + prodln + "' maxlength='50' value='' title='' tabindex='116' value='' style='width: 100%'>";
    cellCount++;

    //var btn_select = x.insertCell(2);
    /*btn_select.innerHTML = "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_part_number_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openProductPopup(" + prodln + ");'><span class=\"suitepicon suitepicon-action-select\"></span></button>";*/
    
    /*var product_name_obj = x.insertCell(cellCount);
    product_name_obj.innerHTML = "<input class='sqsEnabled product_name' autocomplete='off' type='text' name='product_name[" + prodln + "]' id='product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value='' style='width: 100%'><input type='hidden' name='product_product_id[" + prodln + "]' id='product_product_id" + prodln + "'  maxlength='50' value='' >";
    cellCount++;*/

    var customer_product_name_obj = x.insertCell(cellCount);
    customer_product_name_obj.innerHTML = "<input class='sqsEnabled product_name' autocomplete='off' type='text' name='product_ci_customeritems_aos_products_quotes_name[" + prodln + "]' id='product_ci_customeritems_aos_products_quotes_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value='' style='width: 100%'><input type='hidden' name='product_ci_customeritems_aos_products_quotesci_customeritems_ida[" + prodln + "]' id='product_ci_customeritems_aos_products_quotesci_customeritems_ida" + prodln + "'  maxlength='50' value='' >";
    cellCount++;

    var product_product_qty_obj = x.insertCell(cellCount);
    product_product_qty_obj.innerHTML = "<input type='text' name='product_product_qty[" + prodln + "]' id='product_product_qty" + prodln + "'  value='' title='' tabindex='116' onblur='calculateLinesCustom(" + prodln + ",\"product_\");' class='product_qty' style='width: 100%' maxlength='6' />";
    cellCount++;

    var product_product_unit_price_obj = x.insertCell(cellCount);
    product_product_unit_price_obj.innerHTML = "<input type='text' name='product_product_unit_price[" + prodln + "]' id='product_product_unit_price" + prodln + "' value='' title='' tabindex='116' onblur='calculateLinesCustom();' class='product_unit_price' style='width: 100%' maxlength='9' />";
    $('#' + "product_product_unit_price" + prodln).bind('blur', toAmountFormat); //adding Amount format
    cellCount++;

    var product_product_discount_obj = x.insertCell(cellCount);
    product_product_discount_obj.innerHTML = "<input type='text' name='product_product_discount[" + prodln + "]' id='product_product_discount" + prodln + "' value='' title='' tabindex='116'onblur='calculateLinesCustom(" + prodln + ",\"product_\");' class='product_discount_text' style='width: 100%' maxlength='9'><input type='hidden' name='product_product_discount_amount[" + prodln + "]' id='product_product_discount_amount" + prodln + "' value='' />"; 
    $('#' + "product_product_discount" + prodln).bind('blur', toAmountFormat); //adding Amount format
    cellCount++;

    /*h.innerHTML += "<select tabindex='116' name='product_discount[" + prodln + "]' id='product_discount" + prodln + "' onchange='calculateLine(" + prodln + ",\"product_\");' class='product_discount_amount_select'>" + discount_hidden + "</select>";*/

    /*var product_product_total_price_obj = x.insertCell(7);
    product_product_total_price_obj.innerHTML = "<input type='text' name='product_product_total_price[" + prodln + "]' id='product_product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_total_price'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";*/

    var j = x.insertCell(cellCount);
    j.innerHTML = "<input type='text' name='product_product_total_price[" + prodln + "]' id='product_product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_total_price' style='width: 100%'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";
    cellCount++;

  
    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("product_product_total_price" + prodln);
    }

    var product_requested_date_c_obj = x.insertCell(cellCount);
    product_requested_date_c_obj.innerHTML = "<div type='date' field='product_requested_date_c" + prodln + "'>";
    product_requested_date_c_obj.innerHTML += "<span class='dateTime'>";
    product_requested_date_c_obj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_requested_date_c[" + prodln + "]' id='product_requested_date_c" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    product_requested_date_c_obj.innerHTML += "<button type='button' id='product_requested_date_c" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    product_requested_date_c_obj.innerHTML += "</span>";
    product_requested_date_c_obj.innerHTML += "</div>";
    cellCount++;
    
    Calendar.setup ({ 
      inputField : 'product_requested_date_c' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_requested_date_c' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });

    var product_required_ship_date_c_obj = x.insertCell(cellCount);
    product_required_ship_date_c_obj.innerHTML = "<div type='date' field='product_required_ship_date_c" + prodln + "'>";
    product_required_ship_date_c_obj.innerHTML += "<span class='dateTime'>";
    product_required_ship_date_c_obj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_required_ship_date_c[" + prodln + "]' id='product_required_ship_date_c" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";

    product_required_ship_date_c_obj.innerHTML += "<button type='button' id='product_required_ship_date_c" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";

    product_required_ship_date_c_obj.innerHTML += "</span>";
    product_required_ship_date_c_obj.innerHTML += "</div>";
    cellCount++;
    
    Calendar.setup ({ 
      inputField : 'product_required_ship_date_c' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_required_ship_date_c' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });

    var product_promised_date_obj = x.insertCell(cellCount);
    product_promised_date_obj.innerHTML = "<div type='date' field='product_promised_date" + prodln + "'>";
    product_promised_date_obj.innerHTML += "<span class='dateTime'>";
    product_promised_date_obj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_promised_date[" + prodln + "]' id='product_promised_date" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    product_promised_date_obj.innerHTML += "<button type='button' id='product_promised_date" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    product_promised_date_obj.innerHTML += "</span>";
    product_promised_date_obj.innerHTML += "</div>";
    Calendar.setup ({ 
      inputField : 'product_promised_date' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_promised_date' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });
    cellCount++;

    var btn_delete_obj = x.insertCell(cellCount);
    btn_delete_obj.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''><button style='margin: 0px;' type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";
    cellCount++;

    /*
    if (typeof currencyFields !== 'undefined'){

      currencyFields.push("product_product_list_price" + prodln);
      currencyFields.push("product_product_cost_price" + prodln);

    }

    var d = x.insertCell(5);
    d.innerHTML = "<input type='text' name='product_quantity_shipped_c[" + prodln + "]' id='product_quantity_shipped_c" + prodln + "'  value='' title='' tabindex='116' onblur='Quantity_format2NumberCustom(" + prodln + ")' class='product_qty'>";


    var g = x.insertCell(8);
    g.innerHTML = "<input type='text' name='product_product_list_price[" + prodln + "]' id='product_product_list_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' onblur='calculateLine(" + prodln + ",\"product_\");' class='product_list_price'><input type='hidden' name='product_product_cost_price[" + prodln + "]' id='product_product_cost_price" + prodln + "' value=''  />";

    var k = x.insertCell(11);
    k.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''><button type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";

    */
  } else if(module_sugar_grp1 == 'AOS_Invoices'){
    //OnTrack #704 - Order Module Overhaul
    var cellObj = null;
    var requiredFields = '';
    
    cellObj = x.insertCell(cellCount);
    requiredFields = "<input class='product_order_line_number' autocomplete='off' type='text' name='product_order_line_number[" + prodln + "]' id='product_order_line_number" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>";
    //requiredFields += '<input type="hidden" name="product_id['+ prodln +']"  id="product_id['+ prodln +']" value="'+ uuidv4() +'" />';
    requiredFields += '<input type="hidden" name="product_unit_price['+ prodln +']" id="product_unit_price['+ prodln +']" value="0" />';
    requiredFields += "<input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";
    cellObj.innerHTML = requiredFields;
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input class='product_item_number_c' autocomplete='off' type='text' name='product_item_number_c[" + prodln + "]' id='product_item_number_c" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>";
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input class='product_name' autocomplete='off' type='text' name='product_name[" + prodln + "]' id='product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>";
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_product_qty[" + prodln + "]' id='product_product_qty" + prodln + "'  value='' title='' tabindex='116' onblur='Quantity_format2Number(" + prodln + ");calculateLinesCustom(" + prodln + ",\"product_\");' class='product_qty'>";
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_product_unit_price[" + prodln + "]' id='product_product_unit_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' onblur='calculateLinesCustom();' class='product_unit_price'>";
    $('#' + "product_product_unit_price" + prodln).bind('blur', toAmountFormat); //adding Amount format
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_product_discount[" + prodln + "]' id='product_product_discount" + prodln + "'  maxlength='50' value='' title='' tabindex='116'onblur='calculateLinesCustom(" + prodln + ",\"product_\");' class='product_discount_text'><input type='hidden' name='product_product_discount_amount[" + prodln + "]' id='product_product_discount_amount" + prodln + "' value=''  />"; 
    $('#' + "product_product_discount" + prodln).bind('blur', toAmountFormat); 
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_product_total_price[" + prodln + "]' id='product_product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_total_price'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";
    $('#' + "product_product_total_price" + prodln).bind('blur', toAmountFormat); 
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<div type='date' field='product_requested_date_c" + prodln + "'>";
    cellObj.innerHTML += "<span class='dateTime'>";
    cellObj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_requested_date_c[" + prodln + "]' id='product_requested_date_c" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    cellObj.innerHTML += "<button type='button' id='product_requested_date_c" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    cellObj.innerHTML += "</span>";
    cellObj.innerHTML += "</div>";
    
    Calendar.setup ({ 
      inputField : 'product_requested_date_c' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_requested_date_c' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<div type='date' field='product_required_ship_date_c" + prodln + "'>";
    cellObj.innerHTML += "<span class='dateTime'>";
    cellObj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_required_ship_date_c[" + prodln + "]' id='product_required_ship_date_c" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    cellObj.innerHTML += "<button type='button' id='product_required_ship_date_c" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    cellObj.innerHTML += "</span>";
    cellObj.innerHTML += "</div>";
    
    Calendar.setup ({ 
      inputField : 'product_required_ship_date_c' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_required_ship_date_c' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_qty_shipped_c[" + prodln + "]' id='product_qty_shipped_c" + prodln + "' maxlength='50' value='' title='' tabindex='116' class='product_qty_shipped_c' onblur='test()'>";
    //$('#product_qty_shipped_c' + prodln).bind('load', format2WholeNumber).blur(); 
    //format2WholeNumber(null, 'product_qty_shipped_c' + prodln);
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<div type='date' field='product_shipped_date_c" + prodln + "'>";
    cellObj.innerHTML += "<span class='dateTime'>";
    cellObj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_shipped_date_c[" + prodln + "]' id='product_shipped_date_c" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    cellObj.innerHTML += "<button type='button' id='product_shipped_date_c" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    cellObj.innerHTML += "</span>";
    cellObj.innerHTML += "</div>";
    
    Calendar.setup ({ 
      inputField : 'product_shipped_date_c' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_shipped_date_c' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='text' name='product_days_late_c[" + prodln + "]' id='product_days_late_c" + prodln + "' maxlength='50' value='' title='' tabindex='116' class='product_days_late_c'>";
    //$('#' + "product_product_total_price" + prodln).bind('blur', toAmountFormat); 
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<div type='date' field='product_promised_date" + prodln + "'>";
    cellObj.innerHTML += "<span class='dateTime'>";
    cellObj.innerHTML += "<input class='date_input' style='width:88px !important' autocomplete='off' type='text' name='product_promised_date[" + prodln + "]' id='product_promised_date" + prodln + "' title='' tabindex='116' size='11' maxlength='10'>";
    cellObj.innerHTML += "<button type='button' id='product_promised_date" + prodln + "_trigger' class='btn btn-danger' onclick='return false;'><span class='suitepicon suitepicon-module-calendar' alt='Enter Date'></span></button>";
    cellObj.innerHTML += "</span>";
    cellObj.innerHTML += "</div>";
    Calendar.setup ({ 
      inputField : 'product_promised_date' + prodln,
      form : 'EditView',
      ifFormat : '%m/%d/%Y %I:%M%P',
      daFormat : '%m/%d/%Y %I:%M%P',
      button : 'product_promised_date' + prodln + '_trigger',
      singleClick : true,
      dateStr : '02/10/2019',
      startWeekday: 0,
      step : 1,
      weekNumbers:false
    });
    cellCount++;

    cellObj = x.insertCell(cellCount);
    cellObj.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''><button type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";
    cellCount++;

    validateFields(prodln);
  } else if (module_sugar_grp1 == 'Cases') {
    let cellCtr = 0;

    x.insertCell(cellCtr)
        .innerHTML =
        "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_lot_name_button' style='margin-right:8px' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openLotPopup(" + prodln + ");'>" +
        "<span class=\"suitepicon suitepicon-action-select\"></span>" +
        "</button>" +
        "<input class='sqsEnabled product_lot_name' autocomplete='off' type='text' name='product_lot_name[" + prodln + "]' id='product_lot_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>" +
        "<input type='hidden' name='product_lot_id[" + prodln + "]' id='product_lot_id" + prodln + "'  maxlength='50' value=''>";
    cellCtr++;

    x.insertCell(cellCtr)
        .innerHTML =
        "<input class='product_customer_product_number custom-readonly' readonly='readonly' autocomplete='off' type='text' name='product_customer_product_number[" + prodln + "]' id='product_customer_product_number" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>" +
        "<input type='hidden' name='product_customer_product_id[" + prodln + "]' id='product_customer_product_id" + prodln + "'  maxlength='50' value=''>";
    cellCtr++;

    x.insertCell(cellCtr)
        .innerHTML =
        "<input class='product_customer_product_name custom-readonly' readonly='readonly' autocomplete='off' type='text' name='product_customer_product_name[" + prodln + "]' id='product_customer_product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>" +
        "<input type='hidden' name='product_name[" + prodln + "]' id='product_name" + prodln + "'  maxlength='50' value=''>" +
        "<input type='hidden' name='product_product_id[" + prodln + "]' id='product_product_id" + prodln + "'  maxlength='50' value='"+crypto.randomUUID()+"'>" +
        "<input type='hidden' name='product_product_unit_price[" + prodln + "]' id='product_product_unit_price" + prodln + "'  maxlength='50' value='0'>";
    cellCtr++;

    x.insertCell(cellCtr)
        .innerHTML = "<input type='text' name='product_customer_product_amount_lbs[" + prodln + "]' id='product_customer_product_amount_lbs" + prodln + "'  value='' title='' tabindex='116' class='product_customer_product_amount_lbs'>";
    cellCtr++;

    x.insertCell(cellCtr)
        .innerHTML =
        "<input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>" +
        "<button type='button' id='product_add_line" + prodln + "' class='btn btn-info glyphicon glyphicon-plus product_add_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_ADD_PRODUCT_LINE') + "' tabindex='116' onclick='insertProductLine(`product_group${groupn}`, groupn)'></button>" +
        "<br>";
    cellCtr++;

    x.insertCell(cellCtr)
        .innerHTML =
        "<input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'>" +
        "<input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''>" +
        "<button type='button' id='product_delete_line" + prodln + "' class='btn btn-info product_delete_line glyphicon glyphicon-minus product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'></button>" +
        "<br>";
    cellCtr++;

    validateFields(prodln);
    handleShowHidePlusMinusButtons();
  } else {
    var a = x.insertCell(0);
    a.innerHTML = "<input type='text' name='product_product_qty[" + prodln + "]' id='product_product_qty" + prodln + "'  value='' title='' tabindex='116' onblur='Quantity_format2Number(" + prodln + ");calculateLine(" + prodln + ",\"product_\");' class='product_qty'>";

    var b = x.insertCell(1);
    b.innerHTML = "<input class='sqsEnabled product_name' autocomplete='off' type='text' name='product_name[" + prodln + "]' id='product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''><input type='hidden' name='product_product_id[" + prodln + "]' id='product_product_id" + prodln + "'  maxlength='50' value=''>";

    var b1 = x.insertCell(2);
    b1.innerHTML = "<input class='sqsEnabled product_part_number' autocomplete='off' type='text' name='product_part_number[" + prodln + "]' id='product_part_number" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''>";

    var b2 = x.insertCell(3);
    b2.innerHTML = "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_part_number_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openProductPopup(" + prodln + ");'><span class=\"suitepicon suitepicon-action-select\"></span></button>";

    var c = x.insertCell(4);
    c.innerHTML = "<input type='text' name='product_product_list_price[" + prodln + "]' id='product_product_list_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' onblur='calculateLine(" + prodln + ",\"product_\");' class='product_list_price'><input type='hidden' name='product_product_cost_price[" + prodln + "]' id='product_product_cost_price" + prodln + "' value=''  />";

    if (typeof currencyFields !== 'undefined'){

      currencyFields.push("product_product_list_price" + prodln);
      currencyFields.push("product_product_cost_price" + prodln);

    }

    var d = x.insertCell(5);
    d.innerHTML = "<input type='text' name='product_product_discount[" + prodln + "]' id='product_product_discount" + prodln + "'  maxlength='50' value='' title='' tabindex='116' onblur='calculateLine(" + prodln + ",\"product_\");' onblur='calculateLine(" + prodln + ",\"product_\");' class='product_discount_text'><input type='hidden' name='product_product_discount_amount[" + prodln + "]' id='product_product_discount_amount" + prodln + "' value=''  />";
    d.innerHTML += "<select tabindex='116' name='product_discount[" + prodln + "]' id='product_discount" + prodln + "' onchange='calculateLine(" + prodln + ",\"product_\");' class='product_discount_amount_select'>" + discount_hidden + "</select>";

    var e = x.insertCell(6);
    e.innerHTML = "<input type='text' name='product_product_unit_price[" + prodln + "]' id='product_product_unit_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' onblur='calculateLine(" + prodln + ",\"product_\");' onblur='calculateLine(" + prodln + ",\"product_\");' class='product_unit_price'>";

    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("product_product_unit_price" + prodln);
    }

    var f = x.insertCell(7);
    f.innerHTML = "<input type='text' name='product_vat_amt[" + prodln + "]' id='product_vat_amt" + prodln + "' maxlength='250' value='' title='' tabindex='116' readonly='readonly' class='product_vat_amt_text'>";
    f.innerHTML += "<select tabindex='116' name='product_vat[" + prodln + "]' id='product_vat" + prodln + "' onchange='calculateLine(" + prodln + ",\"product_\");' class='product_vat_amt_select'>" + vat_hidden + "</select>";

    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("product_vat_amt" + prodln);
    }
    var g = x.insertCell(8);
    g.innerHTML = "<input type='text' name='product_product_total_price[" + prodln + "]' id='product_product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_total_price'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";

    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("product_product_total_price" + prodln);
    }
    var h = x.insertCell(9);
    h.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "' value=''><button type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";

  }

  enableQS(true);
  //QSFieldsArray["EditView_product_name"+prodln].forceSelection = true;
  
  if(! ['AOS_Quotes', 'AOS_Invoices', 'ODR_SalesOrders', 'Cases'].includes(module_sugar_grp1)) {
    var y = tablebody.insertRow(-1);
    y.id = 'product_note_line' + prodln;

    var h1 = y.insertCell(0);
    var h1 = y.insertCell(0);
    h1.colSpan = "5";
    h1.style.color = "rgb(68,68,68)";
    h1.innerHTML = "<span style='vertical-align: top;' class='product_item_description_label'>" + SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_DESCRIPTION') + " :&nbsp;&nbsp;</span>";
    h1.innerHTML += "<textarea tabindex='116' name='product_item_description[" + prodln + "]' id='product_item_description" + prodln + "' rows='2' cols='23' class='product_item_description'></textarea>&nbsp;&nbsp;";

    var i = y.insertCell(1);
    i.colSpan = "5";
    i.style.color = "rgb(68,68,68)";
    i.innerHTML = "<span style='vertical-align: top;' class='product_description_label'>"  + SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NOTE') + " :&nbsp;</span>";
    i.innerHTML += "<textarea tabindex='116' name='product_description[" + prodln + "]' id='product_description" + prodln + "' rows='2' cols='23' class='product_description'></textarea>&nbsp;&nbsp;"
  }

  function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }

  addAlignedLabels(prodln, 'product');

  prodln++;

  return prodln - 1;
}

var addAlignedLabels = function(ln, type) {
  if(typeof type == 'undefined') {
    type = 'product';
  }
  if(type != 'product' && type != 'service') {
    console.error('type could be "product" or "service" only');
  }
  var labels = [];
  $('tr#'+type+'_head td').each(function(i,e){
    if(type=='product' && $(e).attr('colspan')>1) {
      for(var i=0; i<parseInt($(e).attr('colspan')); i++) {
        if(i==0) {
          labels.push($(e).html());
        } else {
          labels.push('');
        }
      }
    } else {
      labels.push($(e).html());
    }
  });
  $('tr#'+type+'_line'+ln+' td').each(function(i,e){
    $(e).prepend('<span class="alignedLabel">'+labels[i]+'</span>');
  });
}


/**
 * Open product popup
 */
function openProductPopup(ln){

  lineno=ln;
  var popupRequestData = {
    "call_back_function" : "setProductReturn",
    "form_name" : "EditView",
    "field_to_name_array" : {
      "id" : "product_product_id" + ln,
      "name" : "product_name" + ln,
      "description" : "product_item_description" + ln,
      "part_number" : "product_part_number" + ln,
      "cost" : "product_product_cost_price" + ln,
      "price" : "product_product_list_price" + ln,
      "currency_id" : "product_currency" + ln
    }
  };

  open_popup('AOS_Products', 800, 850, '', true, true, popupRequestData);

}

function setProductReturn(popupReplyData){
  set_return(popupReplyData);
  formatListPrice(lineno);
}

function formatListPrice(ln){

  if (typeof currencyFields !== 'undefined'){
    var product_currency_id = document.getElementById('product_currency' + ln).value;
    product_currency_id = product_currency_id ? product_currency_id : -99;//Assume base currency if no id
    var product_currency_rate = get_rate(product_currency_id);
    var dollar_product_price = ConvertToDollar(document.getElementById('product_product_list_price' + ln).value, product_currency_rate);
    document.getElementById('product_product_list_price' + ln).value = format2Number(ConvertFromDollar(dollar_product_price, lastRate));
    var dollar_product_cost = ConvertToDollar(document.getElementById('product_product_cost_price' + ln).value, product_currency_rate);
    document.getElementById('product_product_cost_price' + ln).value = format2Number(ConvertFromDollar(dollar_product_cost, lastRate));
  }
  else
  {
    document.getElementById('product_product_list_price' + ln).value = format2Number(document.getElementById('product_product_list_price' + ln).value);
    document.getElementById('product_product_cost_price' + ln).value = format2Number(document.getElementById('product_product_cost_price' + ln).value);
  }

  calculateLine(ln,"product_");
}

function openLotPopup(ln) {
  let popupRequestData = {
    "call_back_function" : "setLotPopupReturn",
    "form_name" : "EditView",
    "field_to_name_array" : {
      "id" : "product_lot_id" + ln,
      "name" : "product_lot_name" + ln,
    }
  };

  let formattedAccountName = encodeURIComponent(document.getElementById('account_name').value.split("(")[0].trim());
  open_popup('APX_Lots', 800, 850, '&account_name_non_db_advanced=' + formattedAccountName, true, true, popupRequestData);
}

function setLotPopupReturn(popupReplyData) {
  set_return(popupReplyData);
}

/**
 * Insert Service Line
 */

function insertServiceLine(tableid, groupid) {

  if(!enable_groups){
    tableid = "service_group0";
  }
  if (document.getElementById(tableid + '_head') !== null) {
    document.getElementById(tableid + '_head').style.display = "";
  }

  var vat_hidden = document.getElementById("vathidden").value;
  var discount_hidden = document.getElementById("discounthidden").value;

  tablebody = document.createElement("tbody");
  tablebody.id = "service_body" + servln;
  document.getElementById(tableid).appendChild(tablebody);

  var x = tablebody.insertRow(-1);
  x.id = 'service_line' + servln;

  var a = x.insertCell(0);
  a.colSpan = "4";
  a.innerHTML = "<textarea name='service_name[" + servln + "]' id='service_name" + servln + "'  cols='64' title='' tabindex='116' class='service_name'></textarea><input type='hidden' name='service_product_id[" + servln + "]' id='service_product_id" + servln + "'  maxlength='50' value='0'>";

  var a1 = x.insertCell(1);
  a1.innerHTML = "<input type='text' name='service_product_list_price[" + servln + "]' id='service_product_list_price" + servln + "' maxlength='50' value='' title='' tabindex='116'   onblur='calculateLine(" + servln + ",\"service_\");' class='service_list_price'>";

  if (typeof currencyFields !== 'undefined'){
    currencyFields.push("service_product_list_price" + servln);
  }

  var a2 = x.insertCell(2);
  a2.innerHTML = "<input type='text' name='service_product_discount[" + servln + "]' id='service_product_discount" + servln + "'  maxlength='50' value='' title='' tabindex='116' onblur='calculateLine(" + servln + ",\"service_\");' onblur='calculateLine(" + servln + ",\"service_\");' class='service_discount_text'><input type='hidden' name='service_product_discount_amount[" + servln + "]' id='service_product_discount_amount" + servln + "' value=''/>";
  a2.innerHTML += "<select tabindex='116' name='service_discount[" + servln + "]' id='service_discount" + servln + "' onchange='calculateLine(" + servln + ",\"service_\");' class='service_discount_select'>" + discount_hidden + "</select>";

  var b = x.insertCell(3);
  b.innerHTML = "<input type='text' name='service_product_unit_price[" + servln + "]' id='service_product_unit_price" + servln + "' maxlength='50' value='' title='' tabindex='116'   onblur='calculateLine(" + servln + ",\"service_\");' class='service_unit_price'>";

  if (typeof currencyFields !== 'undefined'){
    currencyFields.push("service_product_unit_price" + servln);
  }
  var c = x.insertCell(4);
  c.innerHTML = "<input type='text' name='service_vat_amt[" + servln + "]' id='service_vat_amt" + servln + "' maxlength='250' value='' title='' tabindex='116' readonly='readonly' class='service_vat_text'>";
  c.innerHTML += "<select tabindex='116' name='service_vat[" + servln + "]' id='service_vat" + servln + "' onchange='calculateLine(" + servln + ",\"service_\");' class='service_vat_select'>" + vat_hidden + "</select>";
  if (typeof currencyFields !== 'undefined'){
    currencyFields.push("service_vat_amt" + servln);
  }

  var e = x.insertCell(5);
  e.innerHTML = "<input type='text' name='service_product_total_price[" + servln + "]' id='service_product_total_price" + servln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='service_total_price'><input type='hidden' name='service_group_number[" + servln + "]' id='service_group_number" + servln + "' value='"+ groupid +"'>";

  if (typeof currencyFields !== 'undefined'){
    currencyFields.push("service_product_total_price" + servln);
  }
  var f = x.insertCell(6);
  f.innerHTML = "<input type='hidden' name='service_deleted[" + servln + "]' id='service_deleted" + servln + "' value='0'><input type='hidden' name='service_id[" + servln + "]' id='service_id" + servln + "' value=''><button type='button' class='button service_delete_line' id='service_delete_line" + servln + "' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + servln + ",\"service_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";

  addAlignedLabels(servln, 'service');

  servln++;

  return servln - 1;
}


/**
 * Insert product Header
 */

function insertProductHeader(tableid){
  tablehead = document.createElement("thead");
  tablehead.id = tableid +"_head";
  tablehead.style.display="none";
  document.getElementById(tableid).appendChild(tablehead);


  var x=tablehead.insertRow(-1);
  x.id='product_head';

  if(module_sugar_grp1 == 'AOS_Quotes') {

    var a=x.insertCell(0);
    a.style.color="rgb(68,68,68)";
    a.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_QUANITY');

    var b=x.insertCell(1);
    b.style.color="rgb(68,68,68)";
    b.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NAME');

    var b1=x.insertCell(2);
    b1.colSpan = "2";
    b1.style.color="rgb(68,68,68)";
    b1.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PART_NUMBER');

    var c=x.insertCell(3);
    c.style.color="rgb(68,68,68)";
    c.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_CUSTOMER_ID');

    var c1=x.insertCell(4);
    c1.style.color="rgb(68,68,68)";
    c1.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_LDR');

    var c2=x.insertCell(5);
    c2.style.color="rgb(68,68,68)";
    c2.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_RESIN');

    var e=x.insertCell(6);
    e.style.color="rgb(68,68,68)";
    e.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_UNIT_PRICE');

    var g=x.insertCell(7);
    g.style.color="rgb(68,68,68)";
    g.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_TOTAL_PRICE');

    var h=x.insertCell(8);
    h.style.color="rgb(68,68,68)";
    h.innerHTML='&nbsp;';
  } else if(module_sugar_grp1 == 'ODR_SalesOrders') {
    //OnTrack #704 - Order Module Overhaul
    document.getElementById(tableid).style.borderSpacing="3px";
    document.getElementById(tableid).style.borderCollapse="separate";

    var a1 = x.insertCell(0);
    a1.style.width="3%";
    a1.style.color="rgb(68,68,68)";
    a1.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_ORDER_LINE_NUMBER');

    var a2=x.insertCell(1);
    a2.style.width="7%";
    a2.style.color="rgb(68,68,68)";
    a2.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PART_NUMBER');

    var b=x.insertCell(2);
    b.style.width="30%";
    b.style.color="rgb(68,68,68)";
    b.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NAME');

    var c=x.insertCell(3);
    c.style.width="6%";
    c.style.color="rgb(68,68,68)";
    c.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_QUANITY');

    var i=x.insertCell(4);
    i.style.width="7%";
    i.style.color="rgb(68,68,68)";
    i.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_UNIT_PRICE');

    var h=x.insertCell(5);
    h.style.width="7%";
    h.style.color="rgb(68,68,68)";
    h.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_DISCOUNT_AMT');

    var j=x.insertCell(6);
    j.style.width="10%";
    j.style.color="rgb(68,68,68)";
    j.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_TOTAL_PRICE');

    /*var d=x.insertCell(4);
    d.style.color="rgb(68,68,68";
    d.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_QUANTITY_SHIPPED');*/

    var e=x.insertCell(7);
    e.style.width="6%";
    e.style.color="rgb(68,68,68)";
    e.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_DUE_DATE');

    var f=x.insertCell(8);
    f.style.width="6%";
    f.style.color="rgb(68,68,68)";
    f.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_REQUIRED_SHIP_DATE');

    /*var g=x.insertCell(7);
    g.style.color="rgb(68,68,68";
    g.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_LIST_PRICE');*/

    var f=x.insertCell(9);
    f.style.width="6%";
    f.style.color="rgb(68,68,68)";
    f.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PROMISED_DATE');

    var k=x.insertCell(10);
    k.style.width="6%";
    k.style.color="rgb(68,68,68)";
    k.innerHTML='&nbsp;';
  } else if(module_sugar_grp1 == 'AOS_Invoices'){
    //OnTrack #704 - Order Module Overhaul
    var rowNumber = 0;
    var rowsObj = null;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_LINE_NO');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_ITEM_NO');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_ITEM_NAME');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_QTY_ORDERED');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_UNIT_PRICE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_DISCOUNT');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_LINE_TOTAL');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_REQUESTED_DATE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_REQUIRED_SHIP_DATE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_QTY_SHIPPED');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_SHIPPED_DATE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_DAYS_LATE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML= SUGAR.language.get(module_sugar_grp1, 'LBL_PROMISED_DATE');
    rowNumber++;

    rowsObj = x.insertCell(rowNumber);
    rowsObj.style.color="rgb(68,68,68)";
    rowsObj.innerHTML='&nbsp;';
    rowNumber++;
  } else if (module_sugar_grp1 == 'Cases') {
    let cellCtr = 0;
    let cellObj = null;

    cellObj = x.insertCell(cellCtr);
    cellObj.style.color="rgb(68,68,68)";
    cellObj.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_LOT_NUMBER') + '<span class="required" style="line-height: initial !important;">*</span>';
    cellCtr++;

    cellObj = x.insertCell(cellCtr);
    cellObj.style.color="rgb(68,68,68)";
    cellObj.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NUMBER');
    cellCtr++;

    cellObj = x.insertCell(cellCtr);
    cellObj.style.color="rgb(68,68,68)";
    cellObj.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NAME');
    cellCtr++;

    cellObj = x.insertCell(cellCtr);
    cellObj.style.color="rgb(68,68,68)";
    cellObj.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_AMOUNT_LBS') + '<span class="required" style="line-height: initial !important;">*</span>';
    cellCtr++;

    cellObj = x.insertCell(cellCtr);
    cellObj.style.color="rgb(68,68,68)";
    cellObj.innerHTML='&nbsp;';
    cellCtr++;
  } else {
    var a=x.insertCell(0);
    a.style.color="rgb(68,68,68)";
    a.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_QUANITY');

    var b=x.insertCell(1);
    b.style.color="rgb(68,68,68)";
    b.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PRODUCT_NAME');

    var b1=x.insertCell(2);
    b1.colSpan = "2";
    b1.style.color="rgb(68,68,68)";
    b1.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_PART_NUMBER');

    var c=x.insertCell(3);
    c.style.color="rgb(68,68,68)";
    c.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_LIST_PRICE');

    var d=x.insertCell(4);
    d.style.color="rgb(68,68,68)";
    d.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_DISCOUNT_AMT');

    var e=x.insertCell(5);
    e.style.color="rgb(68,68,68)";
    e.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_UNIT_PRICE');

    var f=x.insertCell(6);
    f.style.color="rgb(68,68,68)";
    f.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_VAT_AMT');

    var g=x.insertCell(7);
    g.style.color="rgb(68,68,68)";
    g.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_TOTAL_PRICE');

    var h=x.insertCell(8);
    h.style.color="rgb(68,68,68)";
    h.innerHTML='&nbsp;';
  }
  
}


/**
 * Insert service Header
 */

function insertServiceHeader(tableid){
  tablehead = document.createElement("thead");
  tablehead.id = tableid +"_head";
  tablehead.style.display="none";
  document.getElementById(tableid).appendChild(tablehead);

  var x=tablehead.insertRow(-1);
  x.id='service_head';

  var a=x.insertCell(0);
  a.colSpan = "4";
  a.style.color="rgb(68,68,68)";
  a.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_SERVICE_NAME');

  var b=x.insertCell(1);
  b.style.color="rgb(68,68,68)";
  b.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_SERVICE_LIST_PRICE');

  var c=x.insertCell(2);
  c.style.color="rgb(68,68,68)";
  c.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_SERVICE_DISCOUNT');

  var d=x.insertCell(3);
  d.style.color="rgb(68,68,68)";
  d.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_SERVICE_PRICE');

  var e=x.insertCell(4);
  e.style.color="rgb(68,68,68)";
  e.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_VAT_AMT');

  var f=x.insertCell(5);
  f.style.color="rgb(68,68,68)";
  f.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_TOTAL_PRICE');

  var g=x.insertCell(6);
  g.style.color="rgb(68,68,68)";
  g.innerHTML='&nbsp;';
}

/**
 * Insert Group
 */

function insertGroup()
{

  if(!enable_groups && groupn > 0){
    return;
  }
  var tableBody = document.createElement("tr");
  tableBody.id = "group_body"+groupn;
  tableBody.className = "group_body";
  document.getElementById('lineItems').appendChild(tableBody);

  var a=tableBody.insertCell(0);
  a.colSpan="100";
  var table = document.createElement("table");
  table.id = "group"+groupn;
  table.className = "group";

  table.style.whiteSpace = 'nowrap';

  a.appendChild(table);



  tableheader = document.createElement("thead");
  table.appendChild(tableheader);
  var header_row=tableheader.insertRow(-1);


  if(enable_groups){
    var header_cell = header_row.insertCell(0);
    header_cell.scope="row";
    header_cell.colSpan="8";
    header_cell.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_GROUP_NAME')+":&nbsp;&nbsp;<input name='group_name[]' id='"+ table.id +"name' maxlength='255'  title='' tabindex='120' type='text' class='group_name'><input type='hidden' name='group_id[]' id='"+ table.id +"id' value=''><input type='hidden' name='group_group_number[]' id='"+ table.id +"group_number' value='"+groupn+"'>";

    var header_cell_del = header_row.insertCell(1);
    header_cell_del.scope="row";
    header_cell_del.colSpan="2";
    header_cell_del.innerHTML="<span title='" + SUGAR.language.get(module_sugar_grp1, 'LBL_DELETE_GROUP') + "' style='float: right;'><a style='cursor: pointer;' id='deleteGroup' tabindex='116' onclick='markGroupDeleted("+groupn+")' class='delete_group'><span class=\"suitepicon suitepicon-action-clear\"></span></a></span><input type='hidden' name='group_deleted[]' id='"+ table.id +"deleted' value='0'>";
  }



  var productTableHeader = document.createElement("thead");
  table.appendChild(productTableHeader);
  var productHeader_row=productTableHeader.insertRow(-1);
  var productHeader_cell = productHeader_row.insertCell(0);
  productHeader_cell.colSpan="100";
  var productTable = document.createElement("table");
  productTable.id = "product_group"+groupn;
  productTable.className = "product_group";
  productHeader_cell.appendChild(productTable);

  insertProductHeader(productTable.id);

  var serviceTableHeader = document.createElement("thead");
  table.appendChild(serviceTableHeader);
  var serviceHeader_row=serviceTableHeader.insertRow(-1);
  var serviceHeader_cell = serviceHeader_row.insertCell(0);
  serviceHeader_cell.colSpan="100";
  var serviceTable = document.createElement("table");
  serviceTable.id = "service_group"+groupn;
  serviceTable.className = "service_group";
  serviceHeader_cell.appendChild(serviceTable);

  insertServiceHeader(serviceTable.id);


  tablefooter = document.createElement("tfoot");
  table.appendChild(tablefooter);
  var footer_row=tablefooter.insertRow(-1);
  var footer_cell = footer_row.insertCell(0);
  footer_cell.scope="row";
  footer_cell.colSpan="20";

  // Hide Add Product Line button if Cases module and set code to auto-add line item if no line item exists (Making the first line item mandatory)
  if (['Cases'].includes(module_sugar_grp1)) {
    setInterval(() => {
        if (jQuery("#lineItems:visible").length > 0 && jQuery("tr[id^='product_line']:visible").length <= 0) {
          insertProductLine(`product_group${groupn}`, groupn);
        }
      }, 100
    );
  } else {
    footer_cell.innerHTML = "<input type='button' tabindex='116' class='button add_product_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_ADD_PRODUCT_LINE') + "' id='" + productTable.id + "addProductLine' onclick='insertProductLine(\"" + productTable.id + "\",\"" + groupn + "\")' />";
  }

  if (! ['AOS_Quotes', 'AOS_Invoices', 'ODR_SalesOrders', 'Cases'].includes(module_sugar_grp1)) {
    footer_cell.innerHTML+=" <input type='button' tabindex='116' class='button add_service_line' value='"+SUGAR.language.get(module_sugar_grp1, 'LBL_ADD_SERVICE_LINE')+"' id='"+serviceTable.id+"addServiceLine' onclick='insertServiceLine(\""+serviceTable.id+"\",\""+groupn+"\")' />";
  }
  
  if(enable_groups){
    footer_cell.innerHTML+="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_TOTAL_AMT')+":</label><input name='group_total_amt[]' id='"+ table.id +"total_amt' class='group_total_amt' maxlength='26' value='' title='' tabindex='120' type='text' readonly></span>";

    var footer_row2=tablefooter.insertRow(-1);
    var footer_cell2 = footer_row2.insertCell(0);
    footer_cell2.scope="row";
    footer_cell2.colSpan="20";
    footer_cell2.innerHTML="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_DISCOUNT_AMOUNT')+":</label><input name='group_discount_amount[]' id='"+ table.id +"discount_amount' class='group_discount_amount' maxlength='26' value='' title='' tabindex='120' type='text' readonly></label>";

    var footer_row3=tablefooter.insertRow(-1);
    var footer_cell3 = footer_row3.insertCell(0);
    footer_cell3.scope="row";
    footer_cell3.colSpan="20";
    footer_cell3.innerHTML="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_SUBTOTAL_AMOUNT')+":</label><input name='group_subtotal_amount[]' id='"+ table.id +"subtotal_amount' class='group_subtotal_amount'  maxlength='26' value='' title='' tabindex='120' type='text' readonly></span>";

    var footer_row4=tablefooter.insertRow(-1);
    var footer_cell4 = footer_row4.insertCell(0);
    footer_cell4.scope="row";
    footer_cell4.colSpan="20";
    footer_cell4.innerHTML="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_TAX_AMOUNT')+":</label><input name='group_tax_amount[]' id='"+ table.id +"tax_amount' class='group_tax_amount' maxlength='26' value='' title='' tabindex='120' type='text' readonly></span>";

    if(document.getElementById('subtotal_tax_amount') !== null){
      var footer_row5=tablefooter.insertRow(-1);
      var footer_cell5 = footer_row5.insertCell(0);
      footer_cell5.scope="row";
      footer_cell5.colSpan="20";
      footer_cell5.innerHTML="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_SUBTOTAL_TAX_AMOUNT')+":</label><input name='group_subtotal_tax_amount[]' id='"+ table.id +"subtotal_tax_amount' class='group_subtotal_tax_amount' maxlength='26' value='' title='' tabindex='120' type='text' readonly></span>";

      if (typeof currencyFields !== 'undefined'){
        currencyFields.push("" + table.id+ 'subtotal_tax_amount');
      }
    }

    var footer_row6=tablefooter.insertRow(-1);
    var footer_cell6 = footer_row6.insertCell(0);
    footer_cell6.scope="row";
    footer_cell6.colSpan="20";
    footer_cell6.innerHTML="<span class='totals'><label>"+SUGAR.language.get(module_sugar_grp1, 'LBL_GROUP_TOTAL')+":</label><input name='group_total_amount[]' id='"+ table.id +"total_amount' class='group_total_amount'  maxlength='26' value='' title='' tabindex='120' type='text' readonly></span>";

    if (typeof currencyFields !== 'undefined'){
      currencyFields.push("" + table.id+ 'total_amt');
      currencyFields.push("" + table.id+ 'discount_amount');
      currencyFields.push("" + table.id+ 'subtotal_amount');
      currencyFields.push("" + table.id+ 'tax_amount');
      currencyFields.push("" + table.id+ 'total_amount');
    }
  }
  groupn++;
  return groupn -1;
}

/**
 * Mark Group Deleted
 */

function markGroupDeleted(gn)
{
  document.getElementById('group_body' + gn).style.display = 'none';

  var rows = document.getElementById('group_body' + gn).getElementsByTagName('tbody');

  for (x=0; x < rows.length; x++) {
    var input = rows[x].getElementsByTagName('button');
    for (y=0; y < input.length; y++) {
      if (input[y].id.indexOf('delete_line') != -1) {
        input[y].click();
      }
    }
  }

}

/**
 * Mark line deleted
 */

function markLineDeleted(ln, key)
{
  // collapse line; update deleted value
  document.getElementById(key + 'body' + ln).style.display = 'none';
  document.getElementById(key + 'deleted' + ln).value = '1';
  document.getElementById(key + 'delete_line' + ln).onclick = '';
  var groupid = 'group' + document.getElementById(key + 'group_number' + ln).value;
    
  if(checkValidate('EditView',key+'product_id' +ln)){
    removeFromValidate('EditView',key+'product_id' +ln);
  }

  // Return if modules like Customer Issue (Cases) don't need any calculations as data is for presentation purposes only
  if (['Cases'].includes(module_sugar_grp1)) {
    ['lot_id', 'lot_name', 'customer_product_amount_lbs'].forEach((fieldName)=> {
      if (checkValidate('EditView',key+ fieldName +ln)) {
        removeFromValidate('EditView',key+ fieldName +ln);
      }
    });

    return;
  }

  if (['ODR_SalesOrders', 'AOS_Invoices'].includes(module_sugar_grp1)) {
    calculateLinesCustom();
  } else {
    calculateTotal(groupid);
    calculateTotal();
  }
}


/**
 * Calculate Line Values
 */

function calculateLine(ln, key){
  
  if(module_sugar_grp1 == 'AOS_Quotes') {
    var productUnitPrice = unformat2Number(document.getElementById(key + 'product_unit_price' + ln).value);
    var productQty = 1;
    if(document.getElementById(key + 'product_qty' + ln) !== null){
      productQty = unformat2Number(document.getElementById(key + 'product_qty' + ln).value);
      Quantity_format2Number(ln);
    }

    if(document.getElementById(key + 'quantity_shipped_c' + ln) !== null){
      QtyShipped = unformat2Number(document.getElementById(key + 'quantity_shipped_c' + ln).value);
      Quantity_format2NumberCustom(ln);
    }
    
    var productTotalPrice = productQty * productUnitPrice;

    document.getElementById(key + 'product_unit_price' + ln).value = format2Number(productUnitPrice);
    document.getElementById(key + 'product_total_price' + ln).value = format2Number(productTotalPrice);
    var groupid = 0;
    if(enable_groups){
      groupid = document.getElementById(key + 'group_number' + ln).value;
    }
    groupid = 'group' + groupid;

    calculateTotal(groupid);
    calculateTotal();
  } 
  else if(module_sugar_grp1 == 'ODR_SalesOrders' || module_sugar_grp1 == 'AOS_Invoices') {
    /*var required = 'product_list_price';
    if(document.getElementById(key + required + ln) === null){
      required = 'product_unit_price';
    }

    if (document.getElementById(key + 'name' + ln).value === '' || document.getElementById(key + required + ln).value === ''){
      return;
    }

    if(key === "product_" && document.getElementById(key + 'product_qty' + ln) !== null && document.getElementById(key + 'product_qty' + ln).value === ''){
      document.getElementById(key + 'product_qty' + ln).value =1;
    }

    var productUnitPrice = unformat2Number(document.getElementById(key + 'product_unit_price' + ln).value);

    if(document.getElementById(key + 'product_list_price' + ln) !== null && document.getElementById(key + 'product_discount' + ln) !== null && document.getElementById(key + 'discount' + ln) !== null){
      var listPrice = get_value(key + 'product_list_price' + ln);
      var discount = get_value(key + 'product_discount' + ln);
      var dis = document.getElementById(key + 'discount' + ln).value;

      if(dis == 'Amount')
      {
        if(discount > listPrice)
        {
          document.getElementById(key + 'product_discount' + ln).value = listPrice;
          discount = listPrice;
        }
        productUnitPrice = listPrice - discount;
        document.getElementById(key + 'product_unit_price' + ln).value = format2Number(listPrice - discount);
      }
      else if(dis == 'Percentage')
      {
        if(discount > 100)
        {
          document.getElementById(key + 'product_discount' + ln).value = 100;
          discount = 100;
        }
        discount = (discount/100) * listPrice;
        productUnitPrice = listPrice - discount;
        document.getElementById(key + 'product_unit_price' + ln).value = format2Number(listPrice - discount);
      }
      else
      {
        document.getElementById(key + 'product_unit_price' + ln).value = document.getElementById(key + 'product_list_price' + ln).value;
        document.getElementById(key + 'product_discount' + ln).value = '';
        discount = 0;
      }
      document.getElementById(key + 'product_list_price' + ln).value = format2Number(listPrice);
      //document.getElementById(key + 'product_discount' + ln).value = format2Number(unformat2Number(document.getElementById(key + 'product_discount' + ln).value));
      document.getElementById(key + 'product_discount_amount' + ln).value = format2Number(-discount, 6);
    }

    var productQty = 1;
    if(document.getElementById(key + 'product_qty' + ln) !== null){
      productQty = unformat2Number(document.getElementById(key + 'product_qty' + ln).value);
      Quantity_format2Number(ln);
    }

    var productTotalPrice = productQty * productUnitPrice;

    document.getElementById(key + 'product_unit_price' + ln).value = format2Number(productUnitPrice);
    document.getElementById(key + 'product_total_price' + ln).value = format2Number(productTotalPrice);
    var groupid = 0;
    if(enable_groups){
      groupid = document.getElementById(key + 'group_number' + ln).value;
    }
    groupid = 'group' + groupid;
    */

    calculateTotal(groupid);
    calculateTotal();
  } else {
    var required = 'product_list_price';
    if(document.getElementById(key + required + ln) === null){
      required = 'product_unit_price';
    }

    if (document.getElementById(key + 'name' + ln).value === '' || document.getElementById(key + required + ln).value === ''){
      return;
    }

    if(key === "product_" && document.getElementById(key + 'product_qty' + ln) !== null && document.getElementById(key + 'product_qty' + ln).value === ''){
      document.getElementById(key + 'product_qty' + ln).value =1;
    }

    var productUnitPrice = unformat2Number(document.getElementById(key + 'product_unit_price' + ln).value);

    if(document.getElementById(key + 'product_list_price' + ln) !== null && document.getElementById(key + 'product_discount' + ln) !== null && document.getElementById(key + 'discount' + ln) !== null){
      var listPrice = get_value(key + 'product_list_price' + ln);
      var discount = get_value(key + 'product_discount' + ln);
      var dis = document.getElementById(key + 'discount' + ln).value;

      if(dis == 'Amount')
      {
        if(discount > listPrice)
        {
          document.getElementById(key + 'product_discount' + ln).value = listPrice;
          discount = listPrice;
        }
        productUnitPrice = listPrice - discount;
        document.getElementById(key + 'product_unit_price' + ln).value = format2Number(listPrice - discount);
      }
      else if(dis == 'Percentage')
      {
        if(discount > 100)
        {
          document.getElementById(key + 'product_discount' + ln).value = 100;
          discount = 100;
        }
        discount = (discount/100) * listPrice;
        productUnitPrice = listPrice - discount;
        document.getElementById(key + 'product_unit_price' + ln).value = format2Number(listPrice - discount);
      }
      else
      {
        document.getElementById(key + 'product_unit_price' + ln).value = document.getElementById(key + 'product_list_price' + ln).value;
        document.getElementById(key + 'product_discount' + ln).value = '';
        discount = 0;
      }
      document.getElementById(key + 'product_list_price' + ln).value = format2Number(listPrice);
      //document.getElementById(key + 'product_discount' + ln).value = format2Number(unformat2Number(document.getElementById(key + 'product_discount' + ln).value));
      document.getElementById(key + 'product_discount_amount' + ln).value = format2Number(-discount, 6);
    }

    var productQty = 1;
    if(document.getElementById(key + 'product_qty' + ln) !== null){
      productQty = unformat2Number(document.getElementById(key + 'product_qty' + ln).value);
      Quantity_format2Number(ln);
    }


    var vat = unformatNumber(document.getElementById(key + 'vat' + ln).value,',','.');

    var productTotalPrice = productQty * productUnitPrice;


    var totalvat=(productTotalPrice * vat) /100;

    if(total_tax){
      productTotalPrice=productTotalPrice + totalvat;
    }

    document.getElementById(key + 'vat_amt' + ln).value = format2Number(totalvat);

    document.getElementById(key + 'product_unit_price' + ln).value = format2Number(productUnitPrice);
    document.getElementById(key + 'product_total_price' + ln).value = format2Number(productTotalPrice);
    var groupid = 0;
    if(enable_groups){
      groupid = document.getElementById(key + 'group_number' + ln).value;
    }
    groupid = 'group' + groupid;

    calculateTotal(groupid);
    calculateTotal();
  }
}

//OnTrack #704 - Order Module Overhaul
function toWholeAmountFormat(elem, elemId){
  var elementObj = null;
  var val = 0;

  if(elemId != '' && elemId != null && elemId != undefined){
    elementObj = $('#' + elemId);
  }

  if(elem != null && elem.currentTarget != null){
    elementObj = $(elem.currentTarget);
  }

  if(elementObj != null && elementObj.val() != '' && elementObj.val() != null && elementObj.val() != undefined){
    val = parseFloat(elementObj.val());
  }

  alert(parseInt(val));
  elementObj.val(parseInt(val));
}

//OnTrack #704 - Order Module Overhaul
function toAmountFormat(elem, elemId){
  var elementObj = null;
  var val = 0;

  if(elemId != '' && elemId != null && elemId != undefined){
    elementObj = $('#' + elemId);
  }

  if(elem != null && elem.currentTarget != null){
    elementObj = $(elem.currentTarget);
  }

  if(elementObj != null && elementObj.val() != '' && elementObj.val() != null && elementObj.val() != undefined){
    val = parseFloat(elementObj.val());
  }

  elementObj.val(val.toFixed(2));
}

//OnTrack #704 - Order Module Overhaul
function calculateLinesCustom(){
  var tblLines = $('.product_group');
  var product_group_trs = tblLines.find('tbody tr');
  var total_price = 0;
  var total_discount = 0;
  var misc_amount_c_val = $('#misc_amount_c').val();
  misc_amount_c_val = (misc_amount_c_val != '' && misc_amount_c_val != null && misc_amount_c_val != undefined) ?
    parseFloat(misc_amount_c_val) : 0;
  var shipping_amount_val = $('#shipping_amount').val();
  shipping_amount_val = (shipping_amount_val != '' && shipping_amount_val != null && shipping_amount_val != undefined) ?
    parseFloat(shipping_amount_val) : 0;
  var tax_amount_val = $('#tax_amount').val();
  tax_amount_val = (tax_amount_val != '' && tax_amount_val != null && tax_amount_val != undefined) ?
    parseFloat(tax_amount_val) : 0;
  var subTotal = 0;
  var grand_total = 0;

  $.each(product_group_trs, function(index, product_group_tr){
    var product_group_tr_obj = $(product_group_tr);

    //product_product_total_price
    var product_product_total_price_obj = product_group_tr_obj.find('[id^=product_product_total_price]');
    var product_product_qty = product_group_tr_obj.find('[id^=product_product_qty]').val();
    product_product_qty = (product_product_qty != '' && product_product_qty != null && product_product_qty != undefined) ?
      product_product_qty : 0;
    var product_product_unit_price = product_group_tr_obj.find('[id^=product_product_unit_price]').val();
      product_product_unit_price= (product_product_unit_price != '' && product_product_unit_price != null 
        && product_product_unit_price != undefined) ? product_product_unit_price : 0;
    var product_product_discount = product_group_tr_obj.find('[id^=product_product_discount]').val();
      product_product_discount = (product_product_discount != '' && product_product_discount != null 
        && product_product_discount != undefined) ? product_product_discount : 0;
    var total_line_price = (product_product_qty * product_product_unit_price) - product_product_discount;
    total_price += total_line_price;
    subTotal = total_line_price - product_product_discount;
    total_discount += product_product_discount;

    product_product_total_price_obj.val(total_line_price.toFixed(2));
  });

  grand_total = misc_amount_c_val + shipping_amount_val + tax_amount_val + subTotal;

  $('#misc_amount_c').val(misc_amount_c_val.toFixed(2));
  $('#shipping_amount').val(shipping_amount_val.toFixed(2));
  $('#tax_amount').val(tax_amount_val.toFixed(2));
  $('#total_amt').val(parseFloat(total_price).toFixed(2));
  $('#subtotal_amount').val(parseFloat(subTotal).toFixed(2));
  $('#total_discount_c').val(parseFloat(total_discount).toFixed(2));
  $('#total_amount').val(grand_total.toFixed(2)); //Grand Total
}

function calculateAllLines() {
  $('.product_group').each(function(productGroupkey, productGroupValue) {
      $(productGroupValue).find('tbody').each(function(productKey, productValue) {

        // Skip modules like Cases from calculating line as it does not make use of the feature
        if (! ['Cases'].includes(module_sugar_grp1)) {
          calculateLine(productKey, "product_");
        }

        validateFields(productKey);
      });
  });

  $('.service_group').each(function(serviceGroupkey, serviceGroupValue) {
    $(serviceGroupValue).find('tbody').each(function(serviceKey, serviceValue) {
      calculateLine(serviceKey, "service_");
    });
  });
}

/**
 * Calculate totals
 */
function calculateTotal(key)
{
  if (typeof key === 'undefined') {  key = 'lineItems'; }
  var row = document.getElementById(key).getElementsByTagName('tbody');
  if(key == 'lineItems') key = '';
  var length = row.length;
  var head = {};
  var tot_amt = 0;
  var subtotal = 0;
  var dis_tot = 0;
  var tax = 0;

  for (i=0; i < length; i++) {
    var qty = 1;
    var list = null;
    var unit = 0;
    var deleted = 0;
    var dis_amt = 0;
    var product_vat_amt = 0;

    var input = row[i].getElementsByTagName('input');
    for (j=0; j < input.length; j++) {
      if (input[j].id.indexOf('product_qty') != -1) {
        qty = unformat2Number(input[j].value);
      }
      if (input[j].id.indexOf('product_list_price') != -1)
      {
        list = unformat2Number(input[j].value);
      }
      if (input[j].id.indexOf('product_unit_price') != -1)
      {
        unit = unformat2Number(input[j].value);
      }
      if (input[j].id.indexOf('product_discount_amount') != -1)
      {
        dis_amt = unformat2Number(input[j].value);
      }
      if (input[j].id.indexOf('vat_amt') != -1)
      {
        product_vat_amt = unformat2Number(input[j].value);
      }
      if (input[j].id.indexOf('deleted') != -1) {
        deleted = input[j].value;
      }

    }

    if(deleted != 1 && key !== ''){
      head[row[i].parentNode.id] = 1;
    } else if(key !== '' && head[row[i].parentNode.id] != 1){
      head[row[i].parentNode.id] = 0;
    }

    if (qty !== 0 && list !== null && deleted != 1) {
      tot_amt += list * qty;
    } else if (qty !== 0 && unit !== 0 && deleted != 1) {
      tot_amt += unit * qty;
    }

    if(module_sugar_grp1 == 'AOS_Quotes') {
      dis_amt = unformat2Number(get_value(key+'discount_amount'));

      if (dis_amt !== 0 && deleted != 1) {
        if(dis_amt < 0) {
          dis_tot += dis_amt * qty;
        } else if(dis_amt > 0) {
          dis_tot += -Math.abs(dis_amt) * qty;
        } else {
          dis_tot = 0;
        }
      }
    } else {
      if (dis_amt !== 0 && deleted != 1) {
        dis_tot += dis_amt * qty;
      }
    }
    
    if (product_vat_amt !== 0 && deleted != 1) {
      tax += product_vat_amt;
    }
  }

  for(var h in head){
    if (head[h] != 1 && document.getElementById(h + '_head') !== null) {
      document.getElementById(h + '_head').style.display = "none";
    }
  }

  subtotal = tot_amt + dis_tot;

  set_value(key+'total_amt',tot_amt);
  set_value(key+'subtotal_amount',subtotal);
  set_value(key+'discount_amount',dis_tot);

  if(module_sugar_grp1 == 'ODR_SalesOrders') {
    var tax = get_value(key+'tax_amount');
    var shipping = get_value(key+'shipping_amount');
    var misc = get_value(key+'misc_amount_c');
    
    tax = tax ? tax : 0;
    shipping = shipping ? shipping : 0;
    misc = misc ? misc : 0;
    
    set_value(key+'total_amount',subtotal + tax + shipping + misc);
  } else {
    var shipping = get_value(key+'shipping_amount');

    var shippingtax = get_value(key+'shipping_tax');

    var shippingtax_amt = shipping * (shippingtax/100);

    set_value(key+'shipping_tax_amt',shippingtax_amt);

    tax += shippingtax_amt;

    set_value(key+'tax_amount',tax);

    set_value(key+'subtotal_tax_amount',subtotal + tax);
    
    set_value(key+'total_amount',subtotal + tax + shipping);
  }
}

function set_value(id, value){
  if(document.getElementById(id) !== null)
  {
    document.getElementById(id).value = format2Number(value);
  }
}

function get_value(id){
  if(document.getElementById(id) !== null)
  {
    return unformat2Number(document.getElementById(id).value);
  }
  return 0;
}


function unformat2Number(num)
{
  return unformatNumber(num, num_grp_sep, dec_sep);
}

function format2Number(str, sig)
{
  if (typeof sig === 'undefined') { sig = sig_digits; }
  num = Number(str);
  if(sig == 2){
    str = formatCurrency(num);
  }
  else{
    str = num.toFixed(sig);
  }

  str = str.split(/,/).join('{,}').split(/\./).join('{.}');
  str = str.split('{,}').join(num_grp_sep).split('{.}').join(dec_sep);

  return str;
}

function formatCurrency(strValue)
{
  strValue = strValue.toString().replace(/\$|\,/g,'');
  dblValue = parseFloat(strValue);

  blnSign = (dblValue == (dblValue = Math.abs(dblValue)));
  dblValue = Math.floor(dblValue*100+0.50000000001);
  intCents = dblValue%100;
  strCents = intCents.toString();
  dblValue = Math.floor(dblValue/100).toString();
  if(intCents<10)
    strCents = "0" + strCents;
  for (var i = 0; i < Math.floor((dblValue.length-(1+i))/3); i++)
    dblValue = dblValue.substring(0,dblValue.length-(4*i+3))+','+
      dblValue.substring(dblValue.length-(4*i+3));
  return (((blnSign)?'':'-') + dblValue + '.' + strCents);
}

function Quantity_format2Number(ln)
{
  var str = '';
  var qty=unformat2Number(document.getElementById('product_product_qty' + ln).value);
  if(qty === null){qty = 1;}

  if(qty === 0){
    str = '0';
  } else {
    str = format2Number(qty);
    if(sig_digits){
      str = str.replace(/0*$/,'');
      str = str.replace(dec_sep,'~');
      str = str.replace(/~$/,'');
      str = str.replace('~',dec_sep);
    }
  }

  document.getElementById('product_product_qty' + ln).value=str;
}

function Quantity_format2NumberCustom(ln)
{
  var str = '';
  var qty=unformat2Number(document.getElementById('product_quantity_shipped_c' + ln).value);
  if(qty === null){qty = 1;}

  if(qty === 0){
    str = '0';
  } else {
    str = format2Number(qty);
    if(sig_digits){
      str = str.replace(/0*$/,'');
      str = str.replace(dec_sep,'~');
      str = str.replace(/~$/,'');
      str = str.replace('~',dec_sep);
    }
  }

  document.getElementById('product_quantity_shipped_c' + ln).value=str;
}

function formatNumber(n, num_grp_sep, dec_sep, round, precision) {
  if (typeof num_grp_sep == "undefined" || typeof dec_sep == "undefined") {
    return n;
  }
  if(n === 0) n = '0';

  n = n ? n.toString() : "";
  if (n.split) {
    n = n.split(".");
  } else {
    return n;
  }
  if (n.length > 2) {
    return n.join(".");
  }
  if (typeof round != "undefined") {
    if (round > 0 && n.length > 1) {
      n[1] = parseFloat("0." + n[1]);
      n[1] = Math.round(n[1] * Math.pow(10, round)) / Math.pow(10, round);
      n[1] = n[1].toString().split(".")[1];
    }
    if (round <= 0) {
      n[0] = Math.round(parseInt(n[0], 10) * Math.pow(10, round)) / Math.pow(10, round);
      n[1] = "";
    }
  }
  if (typeof precision != "undefined" && precision >= 0) {
    if (n.length > 1 && typeof n[1] != "undefined") {
      n[1] = n[1].substring(0, precision);
    } else {
      n[1] = "";
    }
    if (n[1].length < precision) {
      for (var wp = n[1].length; wp < precision; wp++) {
        n[1] += "0";
      }
    }
  }
  regex = /(\d+)(\d{3})/;
  while (num_grp_sep !== "" && regex.test(n[0])) {
    n[0] = n[0].toString().replace(regex, "$1" + num_grp_sep + "$2");
  }
  return n[0] + (n.length > 1 && n[1] !== "" ? dec_sep + n[1] : "");
}

function validateFields(prodln) {
  if(module_sugar_grp1 == 'AOS_Quotes') {
    addToValidate('EditView','product_customer_id_c'+prodln,'varchar',true,"Customer ID");
    addToValidate('EditView','product_ldr_c'+prodln,'decimal',true,"LDR");
    addToValidate('EditView','product_resin_c'+prodln,'varchar',true,"Resin");
  } else if (module_sugar_grp1 == 'ODR_SalesOrders') {
    addToValidate('EditView','product_order_line_number['+prodln+']','varchar',true,"Line #");
    addToValidate('EditView','product_requested_date_c['+prodln+']','date',true,"Requested Date");
    addToValidate('EditView','product_required_ship_date_c['+prodln+']','date',true,"Required Ship Date");
  } else if (module_sugar_grp1 == 'AOS_Invoices') {
    addToValidate('EditView','product_order_line_number['+prodln+']','varchar',true,"Line #");
    addToValidate('EditView','product_requested_date_c['+prodln+']','date',true,"Requested Date");
    addToValidate('EditView','product_required_ship_date_c['+prodln+']','date',true,"Required Ship Date");
  } else if (module_sugar_grp1 == 'Cases') {
    if (['Draft', 'CreatedInError'].includes(document.getElementById('status').value)) {
      ['lot_id', 'lot_name', 'customer_product_amount_lbs'].forEach((fieldName)=> {
        if (checkValidate('EditView','product_' + fieldName + prodln)) {
          removeFromValidate('EditView','product_' + fieldName + prodln);
        }
      });
    } else {
      if (jQuery(`#product_body${prodln}:visible`).length > 0) {
        addToValidate('EditView','product_lot_id'+prodln,'relate',false,"Lot #");
        addToValidate('EditView', 'product_lot_name'+prodln, 'relate', true,'Lot #');
        addToValidateBinaryDependency('EditView', 'product_lot_name'+prodln, 'alpha', true,'No match for field: Lot #', 'product_lot_id'+prodln);

        // Add range validation from 0 - 99999
        addToValidate('EditView', 'product_customer_product_amount_lbs'+prodln, 'currency', true, "Product Amount (Lbs)");
        validate['EditView'][validate['EditView'].length-1][jstypeIndex] = 'range';
        validate['EditView'][validate['EditView'].length-1][minIndex] = 0;
        validate['EditView'][validate['EditView'].length-1][maxIndex] = 99999;
      }
    }
  }
  
}

function check_form(formname) {
  calculateAllLines();
  if (typeof(siw) != 'undefined' && siw && typeof(siw.selectingSomething) != 'undefined' && siw.selectingSomething)
    return false;
  return validate_form(formname, '');
}

function handleShowHidePlusMinusButtons() {
  // Hide Plus(+) Buttons except last
  let plusButtons = document.querySelectorAll('[id^="product_add_line"]');

  if (plusButtons.length > 1) {
    for (let i = 0; i < plusButtons.length - 1; i++) {
      plusButtons[i].style.display = 'none';
    }
  }

  // Show Minus(-) Buttons if not last
  let deleteButtons = document.querySelectorAll('[id^="product_delete_line"]');

  for (let i = 0; i < deleteButtons.length; i++) {
    if (deleteButtons.length > 1) {
      deleteButtons[i].style.display = 'inline-block';
    } else {
      deleteButtons[i].style.display = 'none';
    }
  }

  // Listen event for when Minus(-) button is clicked
  document.addEventListener('click', function(event) {
    if (event.target && event.target.matches('.product_delete_line')) {
      let currentDeleteBtn = jQuery(`#${event.target.id}`);
      let currentRow = currentDeleteBtn.closest('tbody');
      let prevRow = currentRow.prevAll(":visible:first"); // Only retrieve prev row that is visible

      // Only show Plus(+) button if no others are currently shown yet
      if (jQuery('.product_add_line:visible').length === 0) {
        prevRow.find('.product_add_line').css('display', 'inline-block');
      }

      // Hide Minus(-) button if it is the only one visible row left
      if (jQuery('.product_delete_line:visible').length === 1) {
        jQuery('.product_delete_line').css('display', 'none');
      }
    }
  });
}