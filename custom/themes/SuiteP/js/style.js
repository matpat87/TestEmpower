var editViewIntervalObj;
var detailViewIntervalObj;

$(document).ready(function(e){
    GlobalInitialize();

	// editViewIntervalObj = setInterval(AddJSToEditView, 500);
    // detailViewIntervalObj = setInterval(AddJSToDetailView, 500);
});

function AddJSToEditView()
{
	var editViewLength = $('#EditView').text();

	if(editViewLength.length > 0)
	{
		//Insert Codes here
		// PhoneJS();
		// clearInterval(editViewIntervalObj);
	}
}

function GlobalInitialize()
{
    hideCurrentModuleFromTabs();
    PhoneJS();
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    $('input[class="custom-currency"]').each(function(index, item){
        var customCurrencyObj = $(item);

        if(customCurrencyObj.val().indexOf("$") < 0){
            customCurrencyObj.val( '$' + customCurrencyObj.val() );
        }
    });

    $('input[class="custom-currency"]').on('focusout', function(e){
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
            $currency.val('$0.00'); 
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
        number = (isNaN(number) || number == null || number == '') ? 0 : parseFloat(number);
        var value = '$' + number.format(2);

        $(this).val(value);
    });

    $('input[class="custom-currency"]').each(function(index, item){
        var customCurrencyObj = $(item);

        customCurrencyObj.blur();
    });
}

function AddJSToDetailView()
{
    PhoneJS();
}

//Custom Codes for adding mask on phone class
function PhoneJS()
{
    $('.phone').each(function(index, phoneObj){
        $(phoneObj).attr('placeholder', '(XXX) XXX-XXXXXXXXXX');
        // $(phoneObj).blur(PhoneBlur).keydown(PhoneKeyDown).bind('focus click', PhoneFocus);
        $(phoneObj).on('keyup', parsePhoneNumber);
    });
}

function PhoneBlur(e)
{
	$phone = $(this);

    if ($phone.val() === '(') {
        $phone.val('');
    }
}

function PhoneKeyDown(e)
{
	var key = e.which || e.charCode || e.keyCode || 0;
    $phone = $(this);
    var allow = (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key == 13 && detailViewIntervalObj != null) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 

    //if not enter and backspace key, maximum characters has been reached
    if($phone.val().length > 20 && (key != 13 && key != 8))
    {
    	return false;
    }

    // Don't let them remove the starting '('
    if ($phone.val().length === 1 && (key === 8 || key === 46)) {
        $phone.val('('); 
        return false;
    } 
    // Reset if they highlight and type over first char.
    else if ($phone.val().charAt(0) !== '(') {
        $phone.val('('+$phone.val()); 
    }

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($phone.val().length === 4) {
            $phone.val($phone.val() + ')');
        }
        if ($phone.val().length === 5) {
            $phone.val($phone.val() + ' ');
        }           
        if ($phone.val().length === 9) {
            $phone.val($phone.val() + '-');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return allow; 
}

function PhoneFocus(e)
{
	$phone = $(this);

    if ($phone.val().length === 0) {
        $phone.val('(');
    }
    else {
        var val = $phone.val();
        $phone.val('').val(val); // Ensure cursor remains at the end
    }
}

function parsePhoneNumber(e) {
    var val_old = e.target.value;
    var libephonenumberObj = new libphonenumber.AsYouType('US');

    var newString = libephonenumberObj.input(e.target.value);
    e.target.value = newString;
    // console.log(e);
}

function hideCurrentModuleFromTabs()
{
    var modulename = $('.nav .currentTab a').text();
    
    if (modulename.length > 0) {
        $('.topnav .notCurrentTab > ul.dropdown-menu li a:contains("' + modulename + '")')
            .hide()
            .parent()
            .prev()
            .find('a')
            .css('border-bottom', '0');
    }
}

//OnTrack #563 - Email Address validation, can be usable to other modules as well
const validateEmail = (email) => {
    return email.match(
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};