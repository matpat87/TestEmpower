$(document).ready(function(e){
    AmountJS();
    customValidateAvgSellPrice();
});

function AmountJS()
{
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };


    $('input[class="custom-currency"]').keydown(function(e){
        var key = e.which || e.charCode || e.keyCode || 0;
        var $currency = $(this);
        var allow = (key == 8 || 
            key == 9 ||
            key == 46 ||
            key == 190 ||
            key == 110 ||
            (key == 13 && detailViewIntervalObj != null) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 

        //console.log(key);

            // Don't let them remove the starting '$'
        if ($currency.val().length === 0 && (key === 8 || key === 46)) {
            $currency.val('$'); 
            return false;
        }
        // Reset if they highlight and type over first char.
        else if ($currency.val().charAt(0) !== '$') {
            $currency.val('$'+$currency.val()); 
        }

        return allow;
    }).blur(function(e){
        var currency_value = $(this).val();
        var number = currency_value.substring(1);
        number = number.replace(/,/g, '');
        var value = '$' + parseFloat(number).format(2);;

        $(this).val(value);
    });
}

function customValidateAvgSellPrice()
{
    min = 0;
    max = 999.99;
    formname = 'EditView';
    label = $("div[data-label='LBL_AVG_SELL_PRICE'").html().trim().replace(/:/g, '');
    addToValidate(formname, 'avg_sell_price_c', 'currency', true, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}