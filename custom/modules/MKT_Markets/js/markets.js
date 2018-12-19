$(document).ready(function(){
	$("#market_penetration, #gross_margin, #growth_rate").keydown(function (event) {
	    if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

        } else {
            event.preventDefault();
        }
        
        if($(this).val().indexOf('.') !== -1 && (event.keyCode == 190 || event.keyCode == 110))
            event.preventDefault();

	});
});

function customValidate() { 
    $('.custom-validator').hide();
    var marketPenetration = $('#market_penetration').val();
    var grossMargin = $('#gross_margin').val();
    var growthRate = $('#growth_rate').val();

    var marketPenetrationBoolean = true; 
    var grossMarginBoolean = true; 
    var growthRateBoolean = true; 

    // $('#market_penetration').closest('td').find("div").remove();
    // $('#gross_margin').closest('td').find("div").remove();
    // $('#growth_rate').closest('td').find("div").remove();
   
    if (marketPenetration > 100) {    	 	
    	// $('#market_penetration').closest('td').find("div").remove();
        // $('#market_penetration').closest('td').append('<div class="required validation-message">Value must not exceed 100%</div>');
        $('#market_penetration').after('<div class="required validation-message custom-validator">Value must not exceed 100%</div>');
        marketPenetrationBoolean = false;
    }

	if (grossMargin > 100) {    	 	
    	// $('#gross_margin').closest('td').find("div").remove();
        // $('#gross_margin').closest('td').append('<div class="required validation-message">Value must not exceed 100%</div>');
        $('#gross_margin').after('<div class="required validation-message custom-validator">Value must not exceed 100%</div>');
        grossMarginBoolean = false;
    }


	if (growthRate > 100) {    	 	
    	// $('#growth_rate').closest('td').find("div").remove();
        // $('#growth_rate').closest('td').append('<div class="required validation-message">Value must not exceed 100%</div>');
        $('#growth_rate').after('<div class="required validation-message custom-validator">Value must not exceed 100%</div>');
        growthRateBoolean = false;
    }

    if (marketPenetrationBoolean === false || grossMarginBoolean === false || grossMarginBoolean === false) { 
        $('#tab0').click();   
        check_form('EditView');    
        return false;
    } 
        
    if (check_form('EditView') === false ){
        $('#tab0').click();       
        return false; 
    } else {
        return true;
    }
    
    
    // return check_form('EditView');
    
        
    	// return marketPenetrationBoolean && grossMarginBoolean && grossMarginBoolean;
           
 }