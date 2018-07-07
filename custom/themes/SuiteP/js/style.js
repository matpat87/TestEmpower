var editViewIntervalObj;
var detailViewIntervalObj;

$(document).ready(function(e){
	editViewIntervalObj = setInterval(AddJSToEditView, 500);
    detailViewIntervalObj = setInterval(AddJSToDetailView, 500);
});

function AddJSToEditView()
{
	var editViewLength = $('#EditView').text();

	if(editViewLength.length > 0)
	{
		//Insert Codes here

		//Custom Codes for adding mask on phone class
		$('.phone').each(function(index, phoneObj){
			$(phoneObj).attr('placeholder', '(XXX) XXX-XXXXXXXXXX');
			$(phoneObj).blur(PhoneBlur).keydown(PhoneKeyDown).bind('focus click', PhoneFocus);
		});
		//End of Custom Codes for adding 

		clearInterval(editViewIntervalObj);
	}
}

function AddJSToDetailView()
{
    $('.phone').each(function(index, phoneObj){
        $(phoneObj).attr('placeholder', '(XXX) XXX-XXXXXXXXXX');
        $(phoneObj).blur(PhoneBlur).keydown(PhoneKeyDown).bind('focus click', PhoneFocus);
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